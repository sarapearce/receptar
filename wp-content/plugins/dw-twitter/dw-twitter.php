<?php  
/**
 * Plugin Name: DW Twitter
 * Author: DesignWall
 * Author URI: http://www.designwall.com
 * Description: Get/Search Tweets from Twitter, used Twitter API ver 1.1
 * Version: 1.2.2
 *
 * @version 1.2.2
 * @package  dw-twitter
 */

class dw_twitter_query_Widget extends WP_Widget {

    function dw_twitter_query_Widget() {
        $widget_ops = array( 'classname' => 'dw_twitter latest-twitter', 'description' => __('Display latest Tweets from Twitter. With query search: from:<your twitter name>, <@ or #><search string>','dw') );
        parent::__construct( 'dw_twitter', __('DW Twitter','dw'), $widget_ops );
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $instance = wp_parse_args( $instance, array(
            'title'             => 'Latest Tweets', 
            'query'             => 'from:designwall_com',
            'number'            =>  1,
            'show_follow'       => 'false',
            'show_avatar'       => 'false',
            'show_account'      => 'true',
            'exclude_replies'   => false,
            'consumer_key'      => '',
            'consumer_secret'   => ''
        ) );
        $this->get_tweets_bearer_token( $instance['consumer_key'], $instance['consumer_secret'] );
        echo $before_widget;
        echo $before_title . $instance['title'] . $after_title;
        echo '<div class="dw-twitter-inner '.(isset($instance['show_follow'])&&$instance['show_follow']?'has-follow-button':'').'" >';
        $this->get_tweets($instance); 
        echo '</div>';
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        if( ! isset($new_instance['show_follow']) ) {
            $new_instance['show_follow'] = false;
        }
        if( ! isset($new_instance['show_avatar']) ) {
            $new_instance['show_avatar'] = false;
        }
        if( ! isset($new_instance['show_account']) ) {
            $new_instance['show_account'] = false;
        }
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( $instance, array( 
            'title'             => 'Latest Tweets',
            'query'             => 'from:designwall_com',
            'number'            =>  1,
            'show_follow'       => 'false',
            'show_avatar'       => 'false',
            'show_account'      => 'true',
            'consumer_key'      => '',
            'consumer_secret'   => '',
            'exclude_replies'   => false
        ) );
    ?>     
    <p>
        <label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title','dw'); ?></label>
        <br>
        <input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" class="widefat" value="<?php echo $instance['title'] ?>">
    </p>
    <p><label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php _e('Consumer Key','dw') ?></label><br />
        <input type="text" name="<?php echo $this->get_field_name('consumer_key') ?>" id="<?php echo $this->get_field_id('consumer_key') ?>" class="widefat" value="<?php echo $instance['consumer_key'] ?>">
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('consumer_secret') ?>"><?php _e('Consumer Secret', 'dw') ?></label><br />
        <input type="text" name="<?php echo $this->get_field_name('consumer_secret') ?>"  class="widefat" id="<?php echo $this->get_field_id('consumer_secret') ?>" value="<?php echo $instance['consumer_secret'] ?>">
    </p>
    <p><label for="<?php echo $this->get_field_id('query') ?>"><?php _e('Search Query (<a href="https://dev.twitter.com/docs/using-search" target="_blank" title="Read more about Twitter Search query">?</a>)','dw') ?></label><br />
        <input type="text" name="<?php echo $this->get_field_name('query'); ?>" id="<?php echo $this->get_field_id('query'); ?>" class="widefat" value="<?php echo $instance['query'] ?>">
    </p>
    <p><label for="<?php echo $this->get_field_id('number') ?>"><?php _e('Number of Tweets','dw') ?></label>&nbsp;<input type="text" name="<?php echo $this->get_field_name
        ('number') ?>" id="<?php echo $this->get_field_id
        ('number') ?>" size="3" value="<?php echo $instance['number'] ?>" >
    </p>
    <p><label for="<?php echo $this->get_field_id('show_follow') ?>">
        <input type="checkbox" name="<?php echo $this->get_field_name('show_follow'); ?>" id="<?php echo $this->get_field_id('show_follow'); ?>" <?php checked( 'true', $instance['show_follow'] ) ?> value="true" >
        <?php _e('Show Follow Button?', 'dw') ?></label>
    </p>
    <p><label for="<?php echo $this->get_field_id('show_account') ?>">
        <input type="checkbox" name="<?php echo $this->get_field_name('show_account'); ?>" id="<?php echo $this->get_field_id('show_account'); ?>" <?php checked( 'true', $instance['show_account'] ) ?>  value="true"  >
        <?php _e('Show Account Info?', 'dw') ?></label>
    </p>
    <p><label for="<?php echo $this->get_field_id('show_avatar') ?>">
        <input type="checkbox" name="<?php echo $this->get_field_name('show_avatar'); ?>" id="<?php echo $this->get_field_id('show_avatar'); ?>" <?php checked( 'true', $instance['show_avatar'] ) ?>  value="true" >
        <?php _e('Show User Avatar?', 'dw') ?></label>
    </p>
    <p><label for="<?php echo $this->get_field_id('exclude_replies') ?>">
        <input type="checkbox" name="<?php echo $this->get_field_name('exclude_replies'); ?>" id="<?php echo $this->get_field_id('exclude_replies'); ?>" <?php checked( 'true', $instance['exclude_replies'] ) ?>  value="true" >
        <?php _e('Exclude replies for UserTimeline <span class="description">( from:* )<span>', 'dw') ?></label>
    </p>

    <?php
    }

    function update_tweet_urls($content) {
        $maxLen = 16;
        //split long words
        $pattern = '/[^\s\t]{'.$maxLen.'}[^\s\.\,\+\-\_]+/';
        $content = preg_replace($pattern, '$0 ', $content);

        //
        $pattern = '/\w{2,5}\:\/\/[^\s\"]+/';
        $content = preg_replace($pattern, '<a href="$0" title="" target="_blank">$0</a>', $content);
        
        //search
        $pattern = '/\#([a-zA-Z0-9_-]+)/';
        $content = preg_replace($pattern, '<a href="https://twitter.com/search?q=%23$1&src=hash" title="" target="_blank">$0</a>', $content);
        //user
        $pattern = '/\@([a-zA-Z0-9_-]+)/';
        $content = preg_replace($pattern, '<a href="https://twitter.com/#!/$1" title="" target="_blank">$0</a>', $content);

        return $content;
    }


    function get_tweets_bearer_token( $consumer_key, $consumer_secret ){
        $consumer_key = rawurlencode( $consumer_key );
        $consumer_secret = rawurlencode( $consumer_secret );
        if( !$consumer_secret || !$consumer_key ) {
            return false;
        }
        $token = maybe_unserialize( get_option( 'dw_twitter_widget' ) );
        if( ! is_array($token) || empty($token) || $token['consumer_key'] != $consumer_key || empty($token['access_token']) ) {
            $authorization = base64_encode( $consumer_key . ':' . $consumer_secret );

            $args = array(
                'httpversion' => '1.1',
                'headers' => array( 
                    'Authorization' => 'Basic ' . $authorization,
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ),
                'body' => array( 'grant_type' => 'client_credentials' )
            );
            add_filter('https_ssl_verify', '__return_false');

            $remote_get_tweets = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );
            $result = json_decode( wp_remote_retrieve_body(  $remote_get_tweets ) );
            if( ! isset($result->access_token) ) {
                return false;
            }
            $token = serialize( array(
                'consumer_key'      => $consumer_key,
                'access_token'      => $result->access_token
            ) );
            update_option( 'dw_twitter_widget', $token );
            return $token;
        }
    }

    function get_tweets( $instance ){
        extract($instance);
        $token = maybe_unserialize( get_option( 'dw_twitter_widget' ) );
        
        if( empty($token) || !isset($token['access_token']) ) {
            $token = $this->get_tweets_bearer_token( $consumer_key, $consumer_secret );
            if( !$token ) {
                return false;
            }
        }
        if( strpos($query, 'from:') === 0  ) {
            $query_type = 'user_timeline';
            $query = substr($query, 5);
            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.rawurlencode($query).'&count='.$number;
            if( $exclude_replies ) {
                $url .= '&exclude_replies=true';
            }
        } else {
            $query_type = 'search';
            $url =  'https://api.twitter.com/1.1/search/tweets.json?q='.rawurlencode($query).'&count='.$number;
            if( $exclude_replies ) {
                $url .= '&exclude_replies=true';
            }
        }

        $remote_get_tweets = wp_remote_get( $url, array(
            'headers'   => array(
                'Authorization' => 'Bearer '. (is_array($token) && isset($token['access_token']) ? $token['access_token'] : '')
            ),
             // disable checking SSL sertificates               
            'sslverify'=>false
        ) );

        $result = json_decode( wp_remote_retrieve_body( $remote_get_tweets ) );

        if( empty($result) || (isset( $result->errors ) && ( $result->errors[0]->code == 89 || $result->errors[0]->code == 215 ) ) ) {

            delete_option( 'dw_twitter_widget' );
            $this->get_tweets_bearer_token($consumer_key,$consumer_secret);
            return $this->get_tweets($instance);
        } 

        $tweets = array();
        if( 'user_timeline' == $query_type ) {
            if( !empty($result) ) {
                $tweets = $result;
            }
        } else {
            if( !empty($result->statuses) ) {
                $tweets = $result->statuses;
            }

        }

        $follow_button = '<a href="https://twitter.com/__name__" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @__name__</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

        if( !empty($tweets) ) {
            foreach ($tweets as $tweet ) {
                $text = $this->update_tweet_urls( $tweet->text );
                $time = human_time_diff( strtotime($tweet->created_at), time() );
                $url = 'http://twitter.com/'.$tweet->user->id.'/status/'.$tweet->id_str;
                $screen_name = $tweet->user->screen_name;
                $name = $tweet->user->name;
                $profile_image_url = $tweet->user->profile_image_url;

                echo '<div class="tweet-item '.$query_type.'">';
                if( 'search' == $query_type ) {
                    echo '<div class="twitter-user">';
                    if( $show_account ) {
                        echo '<a href="https://twitter.com/'.$screen_name.'" class="user">';
                        if( $show_avatar && $profile_image_url ) {
                            echo '<img src="'.$profile_image_url.'" width="16px" height="16px" >';
                        }
                        echo '&nbsp;<strong class="name">'.$name.'</strong>&nbsp;<span class="screen_name">@'.$screen_name.'</span></a>';
                    }
                    echo '</div>';
                }

                echo    '<div class="tweet-content">'.$text.' <span class="time"><a target="_blank" title="" href="'.$url.'"> about '.$time.' ago</a></span></div>';
                
                if( 'search' == $query_type ) {
                    if( $show_follow ) {
                        echo str_replace('__name__', $screen_name, $follow_button);
                    }
                }
                echo '</div>';
            }

            if( 'user_timeline' == $query_type ) {
                echo    '<div class="twitter-user">';
                if( $show_account ) {
                    echo '<a href="https://twitter.com/'.$screen_name.'" class="user">';
                    if( $show_avatar && $profile_image_url ) {
                        echo '<img src="'.$profile_image_url.'" width="16px" height="16px" >';
                    }
                    echo '&nbsp;<strong class="name">'.$name.'</strong>&nbsp;<span class="screen_name">@'.$screen_name.'</span></a>';
                }
                if( $show_follow ) {
                    echo str_replace('__name__', $screen_name, $follow_button);
                }
                echo    '</div>';
            }

            
        }
    }
}
add_action( 'widgets_init', create_function( '', "register_widget('dw_twitter_query_Widget');" ) );

?>
