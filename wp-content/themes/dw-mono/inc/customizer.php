<?php
function dw_mono_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'dw_mono_theme_options[site_logo]', array(
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_logo', array(
		'label' => __( 'Site Logo', 'dw-mono' ),
		'section' => 'title_tagline',
		'settings' => 'dw_mono_theme_options[site_logo]',
	)));

	$wp_customize->add_setting('dw_mono_theme_options[enable_overlay]', array(
    'capability' => 'edit_theme_options',
    'type'       => 'option',
    'default' => true,
    'sanitize_callback' => 'dw_mono_return_value'
  ));

  $wp_customize->add_control('enable_overlay', array(
    'label'    => __( 'Enable Overlay?', 'dw-mono' ),
    'section'  => 'header_image',
    'type'     => 'checkbox',
    'settings' => 'dw_mono_theme_options[enable_overlay]',
  ));

  $wp_customize->add_setting( 'dw_mono_theme_options[overlay_color]', array(
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'default' => '#006cff',
		'sanitize_callback' => 'dw_mono_return_value',
	));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'overlay_color', array(
		'label' => __( 'Overlay Color', 'dw-mono' ),
		'section' => 'header_image',
		'settings' => 'dw_mono_theme_options[overlay_color]',
	)));

	$wp_customize->add_setting( 'dw_mono_theme_options[overlay_opacity]', array(
		'capability' => 'edit_theme_options',
		'type'       => 'option',
		'default' 	 => '0.3',
		'sanitize_callback' => 'dw_mono_return_value',
	));

	$wp_customize->add_control( 'overlay_opacity', array(
    'type'        => 'range',
    'section'     => 'header_image',
    'label'       => 'Overlay Opacity',
    'input_attrs' => array(
        'min'   => 0,
        'max'   => 1,
        'step'  => 0.1,
        'class' => 'overlay-opacity',
        'style' => 'padding: 0',
    ),
    'settings' => 'dw_mono_theme_options[overlay_opacity]',
	));

}
add_action( 'customize_register', 'dw_mono_customize_register' );


function dw_mono_get_theme_option( $option_name, $default = '' ) {
  $options = get_option( 'dw_mono_theme_options' );
  if( isset($options[$option_name]) ) {
    return $options[$option_name];
  }
  return $default;
}

function dw_mono_return_value( $value ) {
	if ( '' != $value ) {
		return $value;
	} else {
		return '';
	}
}

