<?php
    /* 
        Plugin Name: sh easy social button widget
        Plugin URI: 
        Description: Easily add social Like and Share buttons in your widget area
        Version: 1.1
        Author: Shan
        Author URI: https://in.linkedin.com/in/santanubiswas925
    
        Copyright 2010  Shan
        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.
        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
        You should have received a copy of the GNU General Public License 
        along with this program; if not, write to the Free Software 
        Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    */
?>

<?php

    // Plugin version
    if ( ! defined( 'sh_easy_social_button_widget_version' ) ) {
        define( 'sh_easy_social_like_button_widget_version', '1.1' );
    }

    // Action hook to create plugin widget 
    add_action( 'widgets_init', 'shwsbw_register_widgets' );
    
    //register our widget 
    function shwsbw_register_widgets() {
        register_widget( 'shwsbw_widget' );
    }
    
    class shwsbw_widget extends WP_Widget{
        function __construct() {
            $widget_ops = array(
                                'classname'     => 'shwsbw_widget',
                                'description'   => 'Easily add social Like and Share buttons in your widget area'
                            );
            parent::__construct(
                                // Base ID of the Widget
                                'shwsbw_widget',
                                // Name
                                'sh easy social like button',
                                $widget_ops
                            );
            add_action( 'admin_enqueue_scripts', array($this, 'load_scripts') );
        }
        
        function load_scripts() {
            wp_enqueue_style( 'style_sheet', plugin_dir_url(__FILE__).'shwsbw_style.css', '' );
            wp_enqueue_script( 'upload_jquery', plugin_dir_url(__FILE__).'shwsbw_script.js', array( 'jquery' ), sh_easy_social_button_widget_version, true );
        }
        
        // build our widget settings form
        function form($instance) {
            $defaults = array(
                                'title'             => '',
                                'fb_app_id'         => '',
                                'fb_page_url'       => '',
                                'fb_show'           => '',
                                'twitter_page_url'  => '',
                                'twitter_show'      => '',
                                'g_plus_page_url'   => '',
                                'g_plus_show'       => ''
                            );
            $instance = wp_parse_args( (array) $instance, $defaults );
            
            $title          = isset($instance['title']) ? esc_attr($instance['title']) : '';
            
            // Facebook
            $fb_app_id      = isset($instance['fb_app_id']) ? esc_attr($instance['fb_app_id']) : '';                                                        
            $fb_page_url    = isset($instance['fb_page_url']) ? esc_attr($instance['fb_page_url']) : ''; 
            $fb_show        = isset($instance['fb_show']) ? esc_attr($instance['fb_show']) : '';
            if($fb_show) { $fb_checked = ' checked ="checked" '; }
            
            // Twitter
            $twitter_show       = isset($instance['twitter_show']) ? esc_attr($instance['twitter_show']) : '';
            $twitter_page_url   = isset($instance['twitter_page_url']) ? esc_attr($instance['twitter_page_url']) : '';
            if($twitter_show) { $twitter_checked = ' checked ="checked" '; }
            
            // Google plus
            $g_plus_show        = isset($instance['g_plus_show']) ? esc_attr($instance['g_plus_show']) : '';
            $g_plus_page_url    = isset($instance['g_plus_page_url']) ? esc_attr($instance['g_plus_page_url']) : '';
            if($g_plus_show) { $g_plus_checked = ' checked ="checked" '; }
            
            ?>
            <table class="title_container">
                <tr valign="top">
                    <td><?php _e( 'Widget Title', 'sh-easy-social-button-widget' ); ?></td>
                    <td><input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" /></td>
                </tr>
            </table>
            
            <!-- Facebook setting start -->
                <p class="social_checkbox">
                    <input type="checkbox" name="<?php echo $this->get_field_name('fb_show'); ?>" id="<?php echo $this->get_field_id('fb_show'); ?>" class="fb_checkbox" <?php echo $fb_checked; ?> />
                    <span>Facebook</span>
                </p>
                <div class="fb_container">
                    <table>
                        <tr>
                            <td>App ID</td>
                            <td>Page URL</td>
                        </tr>
                        <tr>
                            <td><input type="text" name="<?php echo $this->get_field_name('fb_app_id'); ?>" id="<?php echo $this->get_field_id('fb_app_id'); ?>" value="<?php echo $fb_app_id; ?>" /></td>
                            <td><input type="text" name="<?php echo $this->get_field_name('fb_page_url'); ?>" id="<?php echo $this->get_field_id('fb_page_url'); ?>" value="<?php echo $fb_page_url; ?>" /></td>
                        </tr>
                    </table>
                </div>
            <!-- Facebook setting end -->
            
            
            <!-- Twitter setting start -->
                <p class="social_checkbox">
                    <input type="checkbox" name="<?php echo $this->get_field_name('twitter_show'); ?>" id="<?php echo $this->get_field_id('twitter_show'); ?>" class="twitter_checkbox" <?php echo $twitter_checked; ?> />
                    <span>Twitter</span>
                </p>
                <div class="twitter_container">
                    <table>
                        <tr>
                            <td>Profile URL</td>
                        </tr>
                        <tr>
                            <td><input type="text" name="<?php echo $this->get_field_name('twitter_page_url'); ?>" id="<?php echo $this->get_field_id('twitter_page_url'); ?>" value="<?php echo $twitter_page_url; ?>" /></td>
                        </tr>
                    </table>
                </div>
            <!-- Twitter setting end -->
            
            <!-- Google plus setting start -->
                <p class="social_checkbox">
                    <input type="checkbox" name="<?php echo $this->get_field_name('g_plus_show'); ?>" id="<?php echo $this->get_field_id('g_plus_show'); ?>" class="g_plus_checkbox" <?php echo $g_plus_checked; ?> />
                    <span>Google Plus</span>
                </p>
                <div class="g_plus_container">
                    <table>
                        <tr>
                            <td>Profile URL</td>
                        </tr>
                        <tr>
                            <td><input type="text" name="<?php echo $this->get_field_name('g_plus_page_url'); ?>" id="<?php echo $this->get_field_id('g_plus_page_url'); ?>" value="<?php echo $g_plus_page_url; ?>" /></td>
                        </tr>
                    </table>
                </div>
            <!-- Google plus setting end -->
                
            <?php
        }
        
        // save or update our Widget settings
        function update( $new_instance, $old_instance ) {
            $instance   = $old_instance;
            $instance['title']          = strip_tags($new_instance['title']);
            
            $instance['fb_app_id']      = strip_tags($new_instance['fb_app_id']);
            $instance['fb_page_url']    = strip_tags($new_instance['fb_page_url']);
            $instance['fb_show']        = strip_tags($new_instance['fb_show']);
            
            $instance['twitter_page_url']    = strip_tags($new_instance['twitter_page_url']);
            $instance['twitter_show']        = strip_tags($new_instance['twitter_show']);
            
            $instance['g_plus_page_url']    = strip_tags($new_instance['g_plus_page_url']);
            $instance['g_plus_show']        = strip_tags($new_instance['g_plus_show']);
            
            return $instance;
        }
        
        function widget( $args, $instance ) {
            extract($args);
            
            // Get the data
            $title          = apply_filters( 'widget_title', $instance['title'] );
            
            $fb_app_id      = $instance['fb_app_id'];
            $fb_page_url    = $instance['fb_page_url'];
            $fb_show        = $instance['fb_show'];
            
            $twitter_page_url    = $instance['twitter_page_url'];
            $twitter_show        = $instance['twitter_show'];
            
            $g_plus_page_url    = $instance['g_plus_page_url'];
            $g_plus_show        = $instance['g_plus_show'];
            
            // Setup SDK
            
            /* facebook SDK */
            $fb_sdk     = '<div id="fb-root"></div>
                            <script>(function(d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s); js.id = id;
                              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId='.$fb_app_id.'";
                              fjs.parentNode.insertBefore(js, fjs);
                            }(document, \'script\', \'facebook-jssdk\'));</script>';
                            
            $fb_content = '<div class="fb-like" data-href="'.$fb_page_url.'" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div>';
            $fb_final   = $fb_sdk . $fb_content;
            
            /* Twitter SDK */
            $twitter_sdk    = '<script>window.twttr = (function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0],
                                  t = window.twttr || {};
                                if (d.getElementById(id)) return t;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "https://platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                               
                                t._e = [];
                                t.ready = function(f) {
                                  t._e.push(f);
                                };
                               
                                return t;
                              }(document, "script", "twitter-wjs"));</script>';
            $twitter_content = '<a class="twitter-follow-button" href="https://twitter.com/shan_biswas15" data-show-count="false" data-show-screen-name="false">Follow</a>';
            $twitter_final   = $twitter_sdk . $twitter_content;
            
            /* Google plus */
            $g_plus_sdk     = '<script src="https://apis.google.com/js/platform.js" async defer></script>';
            $g_plus_content = '<div class="g-follow" data-annotation="none" data-height="20" data-href="'.$g_plus_page_url.'" data-rel="author"></div>';
            $g_plus_final   = $g_plus_sdk . $g_plus_content;
            
            
            // Dsiplay our widget
            echo $before_widget;
            
            $content = $final_content = '';
            
            // Facebook
            if( $fb_show && $fb_app_id && $fb_page_url )
            {
                $content .= $fb_final;
            }
            
            // Twitter
            if( $twitter_show && $twitter_page_url )
            {
                $content .= ' ' . $twitter_final;
            }
            
            // Google Plus
            if( $g_plus_show && $g_plus_page_url )
            {
                $content .= ' ' . $g_plus_final;
            }
            
            if( $content == '' ) { $content = "Nothing to display"; }
            
            if( empty($title) ) {
                $title = $before_title . "Like us on Social Media" . $after_title;
            }
            else {
                $title = $before_title . $title . $after_title;
            }
            
            $final_content = $title.$content;
            echo $final_content;
            
            
            echo $after_widget;
        }
    }
    
