<?php
class HT_Ultimate_Favicon_Settings_Page {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $sizes;

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ) );

        $this->sizes = array(
                'ico' => 'Standard Icon File',
                '16' => 'Default Size (ico)',
                '32' => 'Default Size (ico)',
                '48' => 'Windows site icons (ico)',
                '57' => 'Standard iOS home screen',
                '72' => 'iPad home screen icon',
                '120' => 'iPhone retina touch icon',
                '128' => 'Chrome Web Store icon',
                '144' => 'IE10 Metro tile for pinned site',
                '152' => 'iPad retina touch icon',
                '195' => 'Opera Speed Dial icon',
                '228' => 'Opera Coast icon'
            );

        $this->options  = array();
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            __( 'Heroic Favicon Generator' , 'ht-ultimate-favicon' ), 
            'manage_options', 
            'ht-ultimate-favicon-options', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option( 'ht_ultimate_favicon_options' );

        if(!$this->options){
            //deafults
            $this->options = array();
            $standard_set = array('16','32','48','57','72','96','120','128','144','152','195','228',' 230','ico');
            if( !array_key_exists('enabled', $this->options) ||  !$this->options['enabled'] ){
                    foreach ($standard_set as $key => $value) {
                        $this->options['enabled'][$value]=true;
                    }
            }
            if( !array_key_exists('overrides', $this->options) || !$this->options['overrides'] ){
                    foreach ($standard_set as $key => $value) {
                        $this->options['overrides'][$value]=0;
                    }
            }
        }


        $this->icon_set = array();
        
        //var_dump($this->options['enabled']);

        if( !empty ( $this->options['attachment_id'] ) ){
            $this->icon_set = HT_Ultimate_Favicon::create_icons_from_attachment_id( esc_attr( $this->options['attachment_id']) );
        }

        if( !empty ( $this->options['overrides'] ) ){
            foreach ($this->options['overrides'] as $key => $value) {
                if(!empty($value)){
                    

                    $new_key = HT_Ultimate_Favicon::create_icon_from_attachment_for_size($key, $value);
                    $this->icon_set[$key] = $new_key;
                }
            }
            
        }
        $this->populateGlobalIconSet();
        
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php _e( 'Heroic Favicon Generator Settings' , 'ht-ultimate-favicon'); ?></h2>           
            <form method="post" id="ht-ultimate-favicon-form" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'ht_ultimate_favicon_option' );   
                do_settings_sections( 'ht-ultimate-favicon-options' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
    * Creates the global iconset
    */
    public function populateGlobalIconSet() {
        $icon_urls = array();
        if($this->icon_set){
            foreach ($this->icon_set as $icon_key => $icon_path) {
                //if enabled, set the path
                if( is_array($this->options['enabled']) && array_key_exists($icon_key, $this->options['enabled'] ) ){                    
                    $icon_urls[$icon_key] = $this->urlFromFilePath( $icon_path );
                }
            }
        }

        //delete root ico icon if not enabled
        if( !isset($this->options['enabled']['ico']) ){
            HT_Ultimate_Favicon::delete_ico_from_root();
        }
        

        update_option( HT_ULTIMATE_FAVICONS_OPTION_KEY, $icon_urls );
    }

    /**
    * Returns a uri from file path
    */
    public function urlFromFilePath( $file ) {
        if( strpos( $file, ABSPATH ) === 0 ){
            return home_url( substr( $file, strlen( ABSPATH ) ) );
        } else {
            return "not valid";
        }
    }



    /**
     * Register and add settings
     */
    public function page_init() {       
        register_setting(
            'ht_ultimate_favicon_option', // Option group
            'ht_ultimate_favicon_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        
        add_settings_section(
            'select_favicon', 
            __( 'Select Favicon' , 'ht-ultimate-favicon'), 
            array( $this, 'print_select_favicon_info' ), 
            'ht-ultimate-favicon-options' 
        );  
        

        add_settings_section(
            'setting_section_id', 
            '', // Title
            array( $this, 'print_section_info' ), 
            'ht-ultimate-favicon-options' 
        );  

        add_settings_field(
            'attachment_id', 
            '', // Title 
            array( $this, 'attachment_id_callback' ), 
            'ht-ultimate-favicon-options', 
            'setting_section_id'           
        ); 


        add_settings_section(
            'preview_favicon', 
            __( 'Previews' , 'ht-ultimate-favicon'),
            array( $this, 'print_preview_selection_info' ), 
            'ht-ultimate-favicon-options' 
        );        
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        $new_input = array();
        if( isset( $input['attachment_id'] ) )
            $new_input['attachment_id'] = absint( $input['attachment_id'] );

        if( isset( $input['overrides'] ) ){
            foreach ($input['overrides'] as $key => $value) {
                if( isset( $input['overrides'][$key] ) ){
                    $new_input['overrides'][$key] =  absint( $value );
                }
            }
        }

        if( isset( $input['enabled'] ) ){
            foreach ($input['enabled'] as $key => $value) {
                if( isset( $input['enabled'][$key] ) ){
                    $new_input['enabled'][$key] =  absint( $value );
                }
            }
        }

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_select_favicon_info() {
        _e('Current Favicon', 'ht-ultimate-favicon' );
        echo '<div class="clearfix"></div>';
        echo '<div class="preview-favicon-main">';
        if( !empty( $this->icon_set['230'] ) ){
            echo '<img src="' . $this->urlFromFilePath( $this->icon_set['230'] ) . '" class="favicon-display"/>';
        } else {
            echo '<img src="' . plugins_url( 'img/favicon-default.png' , dirname(__FILE__) ) . '" class="favicon-display favicon-default"/>';
        }
        echo '<div class="preview-favicon-main-buttons">';
        echo '<a href="#" id="ht-select-favicon" class="button button-large button-primary favicon-control">' . __( 'Select Favicon', 'ht-ultimate-favicon') . '</a>';
        echo '<a href="#" id="ht-clear-favicon" class="button button-large button-secondary favicon-control">' . __( 'Clear Favicon', 'ht-ultimate-favicon') . '</a>';
        echo '</div> <!-- preview-favicon-main-buttons -->';
        echo '</div> <!-- preview-favicon-main -->';
    }



    /** 
     * Print the Section text
     */
    public function print_section_info() {
        //na
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function attachment_id_callback() {
        printf(
            '<input type="hidden" id="attachment_id" name="ht_ultimate_favicon_options[attachment_id]" value="%s" />',
            isset( $this->options['attachment_id'] ) ? esc_attr( $this->options['attachment_id']) : ''
        );
    }

    /** 
     * Display the attachment ID input used for the override
     */
    public function attachment_id_display($index) {
        
        printf(
            '<input type="text" id="override_id_' . $index . '" name="ht_ultimate_favicon_options[overrides][' . $index . ']" class="favicon-override-id" value="%s" />',
            isset( $this->options['overrides'][$index] ) ? esc_attr( $this->options['overrides'][$index] ) : ''
        );
    }

    /** 
     * Display the favicon enabled checkbox
     */
    public function favicon_enabled_display($index) {
        echo '<div class="favicon-enabled">';
        printf(
            '<input type="checkbox" id="enabled_id_' . $index . '" name="ht_ultimate_favicon_options[enabled][' . $index . ']" class="favicon-enabled-checkbox" %s />',
            isset( $this->options['enabled'][$index] ) ? 'checked' : ''
        );
        echo '&nbsp;';
        _e( 'Favicon Enabled', 'ht-ultimate-favicon' );
        echo '</div> <!-- favicon-enabled -->';
    }   


    /** 
     * Print the Preview Seciton
     */
    public function print_preview_selection_info() {
        //var_dump( $this->icon_set );   
        //_e('Preview Favicon', 'ht-ultimate-favicon' );
        echo '<ul class="preview-items-list">';
        foreach ($this->sizes as $key => $description) {
            $this->preview_image($key, $description);
        }
        echo '</ul>';
        echo '<br/>';
        
    }

    /**
    * Preview an image
    */
    public function preview_image($index, $description) {

        $sizes = ( $index=='ico' ) ? '(16x16, 32x32 and 42x42)' : '(' . $index . 'x' . $index .')' ;
        $current_ico = array_key_exists($index, $this->icon_set) ? $this->icon_set[$index] : null;
        $preview_url = ( $index=='ico' && $this->options['overrides']['ico']==null ) ? $this->icon_set['32'] : $current_ico ;
        $preview_url = !empty($preview_url) ? $this->urlFromFilePath( $preview_url ) : null;
        echo '<li class="preview-item">';
        echo '<div class="preview-favicon">';                 
        echo '<div class="preview-favicon-title">';
        echo '<h3>' . $description . ' ' . $sizes . '</h3>';
        echo '</div> <!-- preview-favicon-title -->';
        echo '<div class="preview-favicon-main">';
        echo '<div class="preview-favicon-image">';
        if( !empty( $preview_url ) ){            
            echo '<img src="' . $preview_url . '" alt="' . $sizes . '" class="centered" />';                      
        } else {
            echo '<div class="ht-not-generated">' . $description . ' : ' . __( 'Not Generated', 'ht-ultimate-favicon' ) . '</div>';
        }
        echo '</div> <!-- preview-favicon-image -->'; 
        $this->attachment_id_display($index);
        $this->favicon_enabled_display($index);
        echo '<a href="#" class="button button-primary replace-generated" data-id="' . $index . '">' . __( 'Replace Generated Image', 'ht-ultimate-favicon' ) . '</a>';
        echo '<a href="#" class="button button-secondary restore-generated" data-id="' . $index . '">' . __( 'Restore Generated Image', 'ht-ultimate-favicon' ) . '</a>';
        echo '</div> <!-- preview-favicon-main -->';
        echo '</div> <!-- preview-favicon -->';
        echo '</li>';
    }

    /**
    * Enqueue scripts and styles
    */
    public function enqueue_scripts_and_styles() {
        $screen = get_current_screen();
        if(  $screen->base == 'settings_page_ht-ultimate-favicon-options' ) {
            wp_enqueue_media();
            wp_enqueue_script( 'ht-gallery-manager-scripts', plugins_url( 'js/ht-ultimate-favicon-scripts.js', dirname( __FILE__ ) ), array( 'jquery' ) );
            wp_enqueue_style( 'ht-gallery-manager-styles', plugins_url( 'css/ht-ultimate-favicon-styles.css', dirname( __FILE__ ) ) ); 
        }
    }

}

if( is_admin() )
    $ht_ultimate_favicon_settings_page_init = new HT_Ultimate_Favicon_Settings_Page();