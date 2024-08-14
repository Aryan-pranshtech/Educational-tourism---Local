<?php
/*
Plugin Name: Custom Theme Options
Description: A plugin to add custom theme options for name, image, email, and phone number.
Version: 1.0
Author: Mayur Patel
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $wpdb;

define('CUSTOM_FIELD_FILE_PATH', dirname(__FILE__));
define('CUSTOM_FIELD_FOLDER', dirname(plugin_basename(__FILE__)));
define('CUSTOM_FIELD_DIR_NAME', basename(CUSTOM_FIELD_FILE_PATH));
define('CUSTOM_FIELD_URL', plugin_dir_url(__FILE__));
define('CUSTOM_FIELD_TBL', $wpdb->prefix . 'cs_fields');

function create_cs_fields_table() {
    global $wpdb;
    
    $table_name = CUSTOM_FIELD_TBL; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        cs_field_name varchar(255) NOT NULL,
        cs_field_value text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
    dbDelta( $sql );
}

function cs_fields_delete_tables() {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS " . CUSTOM_FIELD_TBL);
}


register_activation_hook(__FILE__, 'create_cs_fields_table');
// register_deactivation_hook(__FILE__, 'cs_fields_delete_tables');

// Register settings
function custom_theme_options_init() {
    register_setting('custom_theme_options_group', 'custom_theme_options', 'custom_theme_options_validate');
}
add_action('admin_init', 'custom_theme_options_init');

// Add menu page
function custom_theme_options_add_page() {
    add_theme_page(
        'Custom Theme Options',   // Page title
        'Theme Options',          // Menu title
        'edit_theme_options',     // Capability
        'custom-theme-options',   // Menu slug
        'custom_theme_options_page' // Callback function
    );
}
add_action('admin_menu', 'custom_theme_options_add_page');

// Enqueue media uploader scripts
function custom_theme_options_enqueue_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('custom-theme-options-js', plugin_dir_url(__FILE__) . 'custom-theme-options.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'custom_theme_options_enqueue_scripts');

// Settings page content
function custom_theme_options_page() {
    ?>
    <style>
        * {box-sizing: border-box}
        body {font-family: "Lato", sans-serif;}

        /* Style the tab */
        .tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 15%;
            min-height: 300px;
        }

        /* Style the buttons inside the tab */
        .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 22px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            float: left;
            padding: 0px 12px;
            border: 1px solid #ccc;
            width: 85%;
            border-left: none;
            min-height: 300px;
        }
        .social-media-item{
            margin-bottom: 5px;
        }
        button.upload-image-button {
            display: block !important;
            margin-bottom: 10px !important;
        }
        
    </style>
    <div class="wrap">
        <h1 style="border: 1px solid #ccc;text-align: center;padding: 5px;font-weight: bold;background-color: #ccc;">Custom Theme Options </h1>
        <br>
        <?php if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) : ?>
            <div id="message" class="updated notice is-dismissible">
                <p><?php esc_html_e('Settings saved successfully.', 'textdomain'); ?></p>
            </div>
        <?php endif; ?>
        <br>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="custom-theme-options-form">

            <input type="hidden" name="action" value="save_custom_theme_options">
            <?php wp_nonce_field('custom_theme_options_nonce'); ?>
            <input type="hidden" id="activeTab" name="active_tab" value="">
            
            <div class="tab">
                <button type="button" class="tablinks" onclick="openTabs(event, 'general_settings')" id="defaultOpen" data-tab="general_settings">General Settings</button>
                <button type="button" class="tablinks" onclick="openTabs(event, 'social_media_settings')" data-tab="social_media_settings">Social Media Settings</button>
                <button type="button" class="tablinks" onclick="openTabs(event, 'homepage_settings')" data-tab="homepage_settings">Home Page Sections</button>
                <button type="button" class="tablinks" onclick="openTabs(event, 'about_us_settings')" data-tab="about_us_settings">About us Page Sections</button>
                <button type="button" class="tablinks" onclick="openTabs(event, 'contact_us_settings')" data-tab="contact_us_settings">Contact us Page Sections</button>
            </div>

            <div id="general_settings" class="tabcontent">
                <h3>General Settings</h3>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[copyright_text]">Copyright Text</label></th>
                        <td><input type="text" id="custom_theme_options[copyright_text]" name="custom_theme_options[copyright_text]" value="<?php echo esc_attr(get_custom_field_value('copyright_text')); ?>" size="50" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[copyright_name]">Copyright Name</label></th>
                        <td><input type="text" id="custom_theme_options[copyright_name]" name="custom_theme_options[copyright_name]" value="<?php echo esc_attr(get_custom_field_value('copyright_name')); ?>" size="50" /></td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[discovery_gallerys_heading]">Post type 'discovery_gallerys' Heading</label></th>
                        <td>
                            <textarea id="custom_theme_options[discovery_gallerys_heading]" name="custom_theme_options[discovery_gallerys_heading]" cols="100" rows="2"><?php echo esc_attr(get_custom_field_value('discovery_gallerys_heading')); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[our_features_heading]">Post type 'our_features' Heading</label></th>
                        <td>
                            <textarea id="custom_theme_options[our_features_heading]" name="custom_theme_options[our_features_heading]" cols="100" rows="2"><?php echo esc_attr(get_custom_field_value('our_features_heading')); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[our_features_desc]">Post type 'our_features' Description</label></th>
                        <td>
                            <textarea id="custom_theme_options[our_features_desc]" name="custom_theme_options[our_features_desc]" cols="100" rows="2"><?php echo esc_attr(get_custom_field_value('our_features_desc')); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[our_teams_heading]">Post type 'our_teams' Heading</label></th>
                        <td>
                            <textarea id="custom_theme_options[our_teams_heading]" name="custom_theme_options[our_teams_heading]" cols="100" rows="2"><?php echo esc_attr(get_custom_field_value('our_teams_heading')); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[our_teams_desc]">Post type 'our_teams' Description</label></th>
                        <td>
                            <textarea id="custom_theme_options[our_teams_desc]" name="custom_theme_options[our_teams_desc]" cols="100" rows="2"><?php echo esc_attr(get_custom_field_value('our_teams_desc')); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[our_teams_btn_text]">Post type 'our_teams' Button Text</label></th>
                        <td>
                            <input type="text" id="custom_theme_options[our_teams_btn_text]" name="custom_theme_options[our_teams_btn_text]" size="100" value="<?php echo esc_attr(get_custom_field_value('our_teams_btn_text')); ?>">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[our_teams_btn_url]">Post type 'our_teams' Button URL</label></th>
                        <td>
                            <input type="text" id="custom_theme_options[our_teams_btn_url]" name="custom_theme_options[our_teams_btn_url]" size="100" value="<?php echo esc_attr(get_custom_field_value('our_teams_btn_url')); ?>">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[brands_heading]">Post type 'brands' Heading </label></th>
                        <td>
                            <input type="text" id="custom_theme_options[brands_heading]" name="custom_theme_options[brands_heading]" size="100" value="<?php echo esc_attr(get_custom_field_value('brands_heading')); ?>">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[contact_section_title]">Contact section title </label></th>
                        <td>
                            <input type="text" id="custom_theme_options[contact_section_title]" name="custom_theme_options[contact_section_title]" size="100" value="<?php echo esc_attr(stripslashes(get_custom_field_value('contact_section_title'))); ?>">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="custom_theme_options[contact_section_desc]">Contact section Description</label></th>
                        <td>
                            <textarea id="custom_theme_options[contact_section_desc]" name="custom_theme_options[contact_section_desc]" cols="100" rows="4"><?php echo esc_attr(stripslashes(get_custom_field_value('contact_section_desc'))); ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="social_media_settings" class="tabcontent">
                <h3>Social Media Settings</h3>
                <button type="button" class="button button-primary" id="add-social-media" style="margin-bottom: 15px;">Add Social Media</button>
                <br>
                <div id="social-media-container">
                    <?php 
                    $social_media_data = get_custom_field_value('social_media');
                    if ( isset($social_media_data) && is_array($social_media_data) ) {
                        foreach ( $social_media_data as $index => $social_media ) {
                                        ?>
                        <div class="social-media-item">
                            <input type="text" required name="custom_theme_options[social_media][<?php echo $index; ?>][name]" value="<?php echo esc_attr($social_media['name']); ?>" placeholder="Name" />
                            <input type="url" name="custom_theme_options[social_media][<?php echo $index; ?>][url]" value="<?php echo esc_attr($social_media['url']); ?>" placeholder="URL" />
                            <input type="text" required name="custom_theme_options[social_media][<?php echo $index; ?>][icon]" value="<?php echo esc_attr($social_media['icon']); ?>" placeholder="Icon Class" />
                            <button type="button" class="remove-social-media button button-secondary">Remove</button>
                        </div>
                    <?php 
                        }
                    } 
                    ?>
                </div>
                
            </div>

            <div id="homepage_settings" class="tabcontent">
                <!-- Homepage General Tab -->
                <?php
                    add_settings_section( 'homepage_settings_section', 'Home General Settings', null, 'homepage-settings-general' );
            
                    add_settings_field( 'banner_text', 'Banner Heading', 'banner_text_callback', 'homepage-settings-general', 'homepage_settings_section' );            
                    add_settings_field( 'banner_desc', 'Banner Description', 'banner_desc_callback', 'homepage-settings-general', 'homepage_settings_section' );            
                    add_settings_field( 'banner_slider_images', 'Banner Slider Images', 'banner_slider_images_callback', 'homepage-settings-general', 'homepage_settings_section' );            
            
                    function banner_text_callback() {
                        $banner_text = get_custom_field_value('banner_text');
                        $banner_text = isset($banner_text) ? esc_textarea(stripslashes($banner_text)) : '';
                        echo '<textarea name="custom_theme_options[banner_text]" rows="3" cols="100">' . $banner_text . '</textarea>';
                    }

                    function banner_desc_callback() {
                        $banner_desc = get_custom_field_value('banner_desc');
                        $banner_desc = isset($banner_desc) ? esc_textarea(stripslashes($banner_desc)) : '';
                        echo '<textarea name="custom_theme_options[banner_desc]" rows="3" cols="100">' . $banner_desc . '</textarea>';
                    }

                    function banner_slider_images_callback() {
                        $banner_slider_images = get_custom_field_value('banner_slider_images');
                        $image_urls = isset($banner_slider_images) ? (array)$banner_slider_images : array();
                    
                        echo '<input type="button" class="button button-primary upload-images" value="Add Images" />';
                        
                        echo '<input type="hidden" id="custom_theme_options_banner_slider_images" name="custom_theme_options[banner_slider_images]" value="' . esc_attr(implode(',', $image_urls)) . '" />';
                        
                        echo '<div id="image-preview">';
                        
                        if ($image_urls) {
                            $image_urls = explode(',', $image_urls[0]);
                            foreach ($image_urls as $image_url) {
                                echo '<div class="image-item" style="display: inline-block; position: relative; margin: 5px;">';
                                echo '<img src="' . esc_url($image_url) . '" style="max-width: 150px;" />';
                                echo '<button type="button" class="button button-secondary delete-banner-image" data-url="' . esc_attr($image_url) . '" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none;">X</button>';
                                echo '</div>';
                            }
                        }
                        
                        echo '</div>';
                        
                        function sanitize_banner_slider_images($input) {
                            $input = array_map('esc_url_raw', explode(',', $input));
                            return $input;
                        }
                        add_filter('pre_update_option_custom_theme_options', 'sanitize_banner_slider_images');
                    }
                    
                ?>
                
                <!-- Homepage Our Clients Tab -->
                <?php
                    add_settings_section( 'homepage_settings_section', 'Home Our Clients Settings', null, 'homepage-settings-our-clients' );
            
                    add_settings_field( 'our_clients_heading', 'Banner Heading', 'our_clients_heading_callback', 'homepage-settings-our-clients', 'homepage_settings_section' );            
                    add_settings_field( 'our_clients_desc', 'Banner Description', 'our_clients_desc_callback', 'homepage-settings-our-clients', 'homepage_settings_section' );            
                    add_settings_field( 'our_clients_desc2', 'Banner Description 2', 'our_clients_desc2_callback', 'homepage-settings-our-clients', 'homepage_settings_section' );            
                    add_settings_field( 'our_clients_features', 'Banner Clients Features', 'our_clients_features_callback', 'homepage-settings-our-clients', 'homepage_settings_section' );            
            
                    function our_clients_heading_callback() {
                        $our_clients_heading = get_custom_field_value('our_clients_heading');
                        $our_clients_heading = isset($our_clients_heading) ? esc_textarea(stripslashes($our_clients_heading)) : '';
                        echo '<textarea name="custom_theme_options[our_clients_heading]" rows="3" cols="100">' . $our_clients_heading . '</textarea>';
                    }

                    function our_clients_desc_callback() {
                        $our_clients_desc = get_custom_field_value('our_clients_desc');
                        $our_clients_desc = isset($our_clients_desc) ? esc_textarea(stripslashes($our_clients_desc)) : '';
                        echo '<textarea name="custom_theme_options[our_clients_desc]" rows="3" cols="100">' . $our_clients_desc . '</textarea>';
                    }
                    function our_clients_features_callback() {
                        $our_clients_features = get_custom_field_value('our_clients_features') ?: array();
                        ?>
                        <table id="our-clients-features-table" class="widefat">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($our_clients_features as $index => $item): ?>
                                    <tr class="our-client-feature-item">
                                        <td>
                                            <input type="hidden" name="custom_theme_options[our_clients_features][<?php echo $index; ?>][image]" value="<?php echo esc_attr($item['image']); ?>" class="image-url" />
                                            <img src="<?php echo esc_url($item['image']); ?>" alt="Image" class="image-preview" style="max-width: 100px;" />
                                            <button type="button" class="button button-primary upload-image-button">Upload Image</button>
                                            <button type="button" class="button button-secondary remove-image-button">Remove Image</button>
                                        </td>
                                        <td>
                                            <input type="text" name="custom_theme_options[our_clients_features][<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" required/>
                                        </td>
                                        <td>
                                            <textarea name="custom_theme_options[our_clients_features][<?php echo $index; ?>][description]" rows="3" cols="30"><?php echo esc_textarea($item['description']); ?></textarea>
                                        </td>
                                        <td>
                                            <button type="button" class="button button-primary remove-client-feature-item">Remove</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="button" id="add-client-feature-item" class="button button-primary">Add More</button>
                        <?php
                    }

                    function our_clients_desc2_callback() {
                        $our_clients_desc2 = get_custom_field_value('our_clients_desc2');
                        $our_clients_desc2 = isset($our_clients_desc2) ? esc_textarea(stripslashes($our_clients_desc2)) : '';
                        echo '<textarea name="custom_theme_options[our_clients_desc2]" rows="3" cols="100">' . $our_clients_desc2 . '</textarea>';
                    }
                      
                ?>
                
                <!-- Homepage Our Why CHoose Us Tab -->
                <?php
                    add_settings_section( 'homepage_settings_section', 'Why Choose Us Settings', null, 'homepage-settings-choose-us' );
            
                    add_settings_field( 'choose_us_heading', 'Choose Us Heading', 'choose_us_heading_callback', 'homepage-settings-choose-us', 'homepage_settings_section' );     
                    add_settings_field( 'choose_us_desc', 'Choose Us Description', 'choose_us_desc_callback', 'homepage-settings-choose-us', 'homepage_settings_section' );     
                    // add_settings_field( 'choose_us_features', 'Choose Us Features', 'choose_us_features_callback', 'homepage-settings-choose-us', 'homepage_settings_section' );     
                    add_settings_field( 'choose_us_slider', 'Choose Us Features', 'choose_us_slider_callback', 'homepage-settings-choose-us', 'homepage_settings_section' );     

                    function choose_us_heading_callback() {
                        $choose_us_heading = get_custom_field_value('choose_us_heading');
                        $choose_us_heading = isset($choose_us_heading) ? esc_textarea(stripslashes($choose_us_heading)) : '';
                        echo '<textarea name="custom_theme_options[choose_us_heading]" rows="3" cols="100">' . $choose_us_heading . '</textarea>';
                    }
                    function choose_us_desc_callback() {
                        $choose_us_desc = get_custom_field_value('choose_us_desc');
                        $choose_us_desc = isset($choose_us_desc) ? esc_textarea(stripslashes($choose_us_desc)) : '';
                        echo '<textarea name="custom_theme_options[choose_us_desc]" rows="3" cols="100">' . $choose_us_desc . '</textarea>';
                    }

                    /*  function choose_us_features_callback() {
                            $choose_us_features = get_custom_field_value('choose_us_features') ?: array();
                            ?>
                            <table id="choose-us-features-table" class="widefat">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($choose_us_features as $index => $item): ?>
                                        <tr class="choose-us-feature-item">
                                            <td>
                                                <input type="hidden" name="custom_theme_options[choose_us_features][<?php echo $index; ?>][image]" value="<?php echo esc_attr($item['image']); ?>" class="image-url" />
                                                <img src="<?php echo esc_url($item['image']); ?>" alt="Image" class="image-preview" style="max-width: 100px;" />
                                                <button type="button" class="button button-primary upload-image-button">Upload Image</button>
                                                <button type="button" class="button button-secondary remove-image-button">Remove Image</button>
                                            </td>
                                            <td>
                                                <input type="text" name="custom_theme_options[choose_us_features][<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" required />
                                            </td>
                                            <td>
                                                <textarea name="custom_theme_options[choose_us_features][<?php echo $index; ?>][description]" rows="3" cols="30"><?php echo esc_textarea($item['description']); ?></textarea>
                                            </td>
                                            <td>
                                                <button type="button" class="button button-primary remove-choose-us-feature-item">Remove</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button type="button" id="add-choose-us-feature-item" class="button button-primary">Add More</button>
                            <?php
                        } 
                    */
                    
                    function choose_us_slider_callback() {
                        $choose_us_slider = get_custom_field_value('choose_us_slider');
                        $image_urls = isset($choose_us_slider) ? (array)$choose_us_slider : array();
                    
                        echo '<input type="button" class="button button-primary upload-choose-us-images" value="Add Images" />';
                        
                        echo '<input type="hidden" id="custom_theme_options_choose_us_slider" name="custom_theme_options[choose_us_slider]" value="' . esc_attr(implode(',', $image_urls)) . '" />';
                        
                        echo '<div id="choose-us-image-preview">';
                        
                        if ($image_urls) {
                            $image_urls = explode(',', $image_urls[0]);
                            foreach ($image_urls as $image_url) {
                                echo '<div class="image-item" style="display: inline-block; position: relative; margin: 5px;">';
                                echo '<img src="' . esc_url($image_url) . '" style="max-width: 150px;" />';
                                echo '<button type="button" class="button button-secondary delete-choose_us-image" data-url="' . esc_attr($image_url) . '" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none;">X</button>';
                                echo '</div>';
                            }
                        }
                        
                        echo '</div>';
                        
                        function sanitize_choose_us_slider($input) {
                            $input = array_map('esc_url_raw', explode(',', $input));
                            return $input;
                        }
                        add_filter('pre_update_option_custom_theme_options', 'sanitize_choose_us_slider');
                    }                    
                ?>

                <!-- Homepage About us Tab -->
                <?php
                    add_settings_section( 'homepage_settings_section', 'About Section Settings', null, 'homepage-settings-about' );
            
                    add_settings_field( 'about_heading', 'About Heading', 'about_heading_callback', 'homepage-settings-about', 'homepage_settings_section' );            
                    add_settings_field( 'about_desc', 'About Description', 'about_desc_callback', 'homepage-settings-about', 'homepage_settings_section' );            
                    add_settings_field( 'about_video_link', 'About Video URL', 'about_video_link_callback', 'homepage-settings-about', 'homepage_settings_section' );            
                    add_settings_field( 'about_bottom_text', 'About Bottom Text', 'about_bottom_text_callback', 'homepage-settings-about', 'homepage_settings_section' );            
            
                    function about_heading_callback() {
                        $about_heading = get_custom_field_value('about_heading');
                        $about_heading = isset($about_heading) ? esc_textarea(stripslashes($about_heading)) : '';
                        echo '<textarea name="custom_theme_options[about_heading]" rows="3" cols="100">' . $about_heading . '</textarea>';
                    }
                    function about_desc_callback() {
                        $about_desc = get_custom_field_value('about_desc');
                        $about_desc = isset($about_desc) ? esc_textarea(stripslashes($about_desc)) : '';
                        echo '<textarea name="custom_theme_options[about_desc]" rows="3" cols="100">' . $about_desc . '</textarea>';
                    }
                    function about_video_link_callback() {
                        $about_video_link = get_custom_field_value('about_video_link');
                        $about_video_link = $about_video_link ?: '';
                        echo '<input type="text" name="custom_theme_options[about_video_link]" size="100" value="' . $about_video_link . '" required/>';
                    }
                    function about_bottom_text_callback() {
                        $about_bottom_text = get_custom_field_value('about_bottom_text');
                        $about_bottom_text = $about_bottom_text ?: '';
                        echo '<input type="text" name="custom_theme_options[about_bottom_text]" size="100" value="' . $about_bottom_text . '" required/>';
                    }
                      
                ?>
                <!-- Homepage Discover Unforgettable Experiences Tab -->
                <?php
                    add_settings_section( 'homepage_settings_section', 'Discover Unforgettable Experiences Section Settings', null, 'homepage-settings-discover' );
            
                    add_settings_field( 'discover_heading', 'Discover Section Heading', 'discover_heading_callback', 'homepage-settings-discover', 'homepage_settings_section' );            
                    add_settings_field( 'discover_desc', 'Discover Section Description', 'discover_desc_callback', 'homepage-settings-discover', 'homepage_settings_section' );            
                    add_settings_field( 'discover_desc2', 'Discover Section Description 2', 'discover_desc2', 'homepage-settings-discover', 'homepage_settings_section' );            
                    add_settings_field( 'discover_button_text', 'Discover Section button text', 'discover_button_text_callback', 'homepage-settings-discover', 'homepage_settings_section' );            
                    add_settings_field( 'discover_button_url', 'Discover Section button URL', 'discover_button_url_callback', 'homepage-settings-discover', 'homepage_settings_section' );            
            
                    function discover_heading_callback() {
                        $discover_heading = get_custom_field_value('discover_heading');
                        $discover_heading = isset($discover_heading) ? esc_textarea(stripslashes($discover_heading)) : '';
                        echo '<textarea name="custom_theme_options[discover_heading]" rows="3" cols="100">' . $discover_heading . '</textarea>';
                    }
                    function discover_desc_callback() {
                        $discover_desc = get_custom_field_value('discover_desc');
                        $discover_desc = isset($discover_desc) ? esc_textarea(stripslashes($discover_desc)) : '';
                        echo '<textarea name="custom_theme_options[discover_desc]" rows="3" cols="100">' . $discover_desc . '</textarea>';
                    }
                    function discover_desc2() {
                        $discover_desc2 = get_custom_field_value('discover_desc2');
                        $discover_desc2 = $discover_desc2 ?: '';
                        echo '<textarea name="custom_theme_options[discover_desc2]" rows="3" cols="100">' . $discover_desc2 . '</textarea>';
                    }
                    function discover_button_text_callback() {
                        $discover_button_text = get_custom_field_value('discover_button_text');
                        $discover_button_text = $discover_button_text ?: '';
                        echo '<input type="text" name="custom_theme_options[discover_button_text]" size="100" value="' . $discover_button_text . '"/>';
                    }
                    function discover_button_url_callback() {
                        $discover_button_url = get_custom_field_value('discover_button_url');
                        $discover_button_url = $discover_button_url ?: '';
                        echo '<input type="text" name="custom_theme_options[discover_button_url]" size="100" value="' . $discover_button_url . '"/>';
                    }
                      
                ?>

                <!-- Homepage Articles Tab -->
                <?php
                    add_settings_section( 'homepage_settings_section', 'Article Section Settings', null, 'homepage-settings-article' );
            
                    add_settings_field( 'article_heading', 'Article Section Heading', 'article_heading_callback', 'homepage-settings-article', 'homepage_settings_section' );            
                    add_settings_field( 'article_desc', 'Article Section Description', 'article_desc_callback', 'homepage-settings-article', 'homepage_settings_section' );            
                    add_settings_field( 'article_button_text', 'Article Section Button Text', 'article_button_text_callback', 'homepage-settings-article', 'homepage_settings_section' );            
                    add_settings_field( 'article_button_url', 'Article Section Button Page', 'article_button_url_callback', 'homepage-settings-article', 'homepage_settings_section' );            
            
                    function article_heading_callback() {
                        $article_heading = get_custom_field_value('article_heading');
                        $article_heading = isset($article_heading) ? esc_textarea(stripslashes($article_heading)) : '';
                        echo '<textarea name="custom_theme_options[article_heading]" rows="3" cols="100">' . $article_heading . '</textarea>';
                    }
                    function article_desc_callback() {
                        $article_desc = get_custom_field_value('article_desc');
                        $article_desc = isset($article_desc) ? esc_textarea(stripslashes($article_desc)) : '';
                        echo '<textarea name="custom_theme_options[article_desc]" rows="3" cols="100">' . $article_desc . '</textarea>';
                    }
                    function article_button_text_callback() {
                        $article_button_text = get_custom_field_value('article_button_text');
                        $article_button_text = isset($article_button_text) ? esc_textarea(stripslashes($article_button_text)) : '';
                        echo '<input type="text" name="custom_theme_options[article_button_text]" size="50" value="' . $article_button_text . '">';
                    }
                    function article_button_url_callback() {
                        $article_button_url = get_custom_field_value('article_button_url');
                        $article_button_url = isset($article_button_url) ? esc_textarea(stripslashes($article_button_url)) : '';
                        echo '<input type="text" name="custom_theme_options[article_button_url]" size="50" value="' . $article_button_url . '">';
                    }
                ?>
                
                <!-- TABS WRAP -->
                <?php
                    $tabs = [
                        [ 'id' => 'tab-home-general', 'label' => 'Homepage General', 'settings_section' => 'homepage-settings-general', ],
                        [ 'id' => 'tab-home-about', 'label' => 'About Us Section', 'settings_section' => 'homepage-settings-about', ],
                        [ 'id' => 'tab-home-discover', 'label' => 'Discover Unforgettable Experiences Section', 'settings_section' => 'homepage-settings-discover', ],
                        [ 'id' => 'tab-home-our-clients', 'label' => 'Our Clients Section', 'settings_section' => 'homepage-settings-our-clients', ],
                        [ 'id' => 'tab-home-choose-us', 'label' => 'Why Choose Us Section', 'settings_section' => 'homepage-settings-choose-us', ],
                        [ 'id' => 'tab-home-article', 'label' => 'Article Section', 'settings_section' => 'homepage-settings-article', ],
                    ];
                ?>
                <div class="wrap">
                    <h2 class="nav-tab-wrapper">
                        <?php foreach ($tabs as $index => $tab): ?>
                            <a href="#<?php echo esc_attr($tab['id']); ?>" class="nav-tab <?php echo $index === 0 ? 'nav-tab-active' : ''; ?>">
                                <?php echo esc_html($tab['label']); ?>
                            </a>
                        <?php endforeach; ?>
                    </h2>

                    <?php foreach ($tabs as $index => $tab): ?>
                        <div id="<?php echo esc_attr($tab['id']); ?>" class="settings-tab" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                            <?php do_settings_sections($tab['settings_section']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

            
            <div id="about_us_settings" class="tabcontent">
                <!-- About General Tab -->
                <?php
                    add_settings_section( 'about_us_settings_section', 'About General Settings', null, 'about-settings-general' );
            
                    add_settings_field( 'about_main_heading', 'About Main Wrap Heading', 'about_main_heading_callback', 'about-settings-general', 'about_us_settings_section' );            
                    add_settings_field( 'about_main_desc', 'About Main Wrap Heading', 'about_main_desc_callback', 'about-settings-general', 'about_us_settings_section' );            
                    add_settings_field( 'about_main_img', 'About Main Image', 'about_main_img_callback', 'about-settings-general', 'about_us_settings_section' );            
                    add_settings_field( 'about_main_left_img', 'About Main Left Image', 'about_main_left_img_callback', 'about-settings-general', 'about_us_settings_section' );            
                    add_settings_field( 'about_main_right_img', 'About Main Right Image', 'about_main_right_img_callback', 'about-settings-general', 'about_us_settings_section' );         
                    add_settings_field( 'about_us_video_link', 'About Video Section URL', 'about_us_video_link_callback', 'about-settings-general', 'about_us_settings_section' );            

                    function about_main_heading_callback() {
                        $about_main_heading = get_custom_field_value('about_main_heading');
                        $about_main_heading = isset($about_main_heading) ? esc_textarea(stripslashes($about_main_heading)) : '';
                        echo '<textarea name="custom_theme_options[about_main_heading]" rows="3" cols="100">' . $about_main_heading . '</textarea>';
                    }
                    function about_main_desc_callback() {
                        $about_main_desc = get_custom_field_value('about_main_desc');
                        $about_main_desc = isset($about_main_desc) ? esc_textarea(stripslashes($about_main_desc)) : '';
                        echo '<textarea name="custom_theme_options[about_main_desc]" rows="10" cols="100">' . $about_main_desc . '</textarea>';
                    }
                    function about_main_img_callback() {
                        $image_url = get_custom_field_value('about_main_img') ?? '';
                        ?>
                        <div class="image-field-container">
                            <input type="hidden" class="image-field-url" name="custom_theme_options[about_main_img]" value="<?php echo esc_url($image_url); ?>" />
                            <img class="image-preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 20%; height: auto; display: <?php echo $image_url ? 'block' : 'none'; ?>;" />
                            <input type="button" class="button upload-image-button" value="Upload Image" />
                            <input type="button" class="button remove-image-button" value="Remove Image" style="display: <?php echo $image_url ? 'inline-block' : 'none'; ?>;" />
                        </div>
                        <?php
                    }
                    
                    function about_main_left_img_callback() {
                        $image_url = get_custom_field_value('about_main_left_img') ?? '';
                        ?>
                        <div class="image-field-container">
                            <input type="hidden" class="image-field-url" name="custom_theme_options[about_main_left_img]" value="<?php echo esc_url($image_url); ?>" />
                            <img class="image-preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 20%; height: auto; display: <?php echo $image_url ? 'block' : 'none'; ?>;" />
                            <input type="button" class="button upload-image-button" value="Upload Image" />
                            <input type="button" class="button remove-image-button" value="Remove Image" style="display: <?php echo $image_url ? 'inline-block' : 'none'; ?>;" />
                        </div>
                        <?php
                    }
                    function about_main_right_img_callback() {
                        $image_url = get_custom_field_value('about_main_right_img') ?? '';
                        ?>
                        <div class="image-field-container">
                            <input type="hidden" class="image-field-url" name="custom_theme_options[about_main_right_img]" value="<?php echo esc_url($image_url); ?>" />
                            <img class="image-preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 20%; height: auto; display: <?php echo $image_url ? 'block' : 'none'; ?>;" />
                            <input type="button" class="button upload-image-button" value="Upload Image" />
                            <input type="button" class="button remove-image-button" value="Remove Image" style="display: <?php echo $image_url ? 'inline-block' : 'none'; ?>;" />
                        </div>
                        <?php
                    }
                    function about_us_video_link_callback() {
                        $about_us_video_link = get_custom_field_value('about_us_video_link');
                        $about_us_video_link = $about_us_video_link ?: '';
                        echo '<input type="text" name="custom_theme_options[about_us_video_link]" size="100" value="' . $about_us_video_link . '" required/>';
                    }
                    
                ?>  
                <!-- About Our mission Tab -->
                <?php
                    add_settings_section( 'about_us_settings_section', 'About Our mission Settings', null, 'about-settings-our-mission' );
            
                    add_settings_field( 'about_mission_heading', 'About Main Wrap Heading', 'about_mission_heading_callback', 'about-settings-our-mission', 'about_us_settings_section' );            
                    add_settings_field( 'about_mission_desc', 'About Main Wrap Heading', 'about_mission_desc_callback', 'about-settings-our-mission', 'about_us_settings_section' );            
                    add_settings_field( 'about_mission_slider', 'Choose Us Features', 'about_mission_slider_callback', 'about-settings-our-mission', 'about_us_settings_section' );     

                    function about_mission_heading_callback() {
                        $about_mission_heading = get_custom_field_value('about_mission_heading');
                        $about_mission_heading = isset($about_mission_heading) ? esc_textarea(stripslashes($about_mission_heading)) : '';
                        echo '<textarea name="custom_theme_options[about_mission_heading]" rows="3" cols="100">' . $about_mission_heading . '</textarea>';
                    }
                    function about_mission_desc_callback() {
                        $about_mission_desc = get_custom_field_value('about_mission_desc');
                        $about_mission_desc = isset($about_mission_desc) ? esc_textarea(stripslashes($about_mission_desc)) : '';
                        echo '<textarea name="custom_theme_options[about_mission_desc]" rows="10" cols="100">' . $about_mission_desc . '</textarea>';
                    }
                    
                    function about_mission_slider_callback() {
                        $about_mission_slider = get_custom_field_value('about_mission_slider');
                        $image_urls = isset($about_mission_slider) ? (array)$about_mission_slider : array();
                    
                        echo '<input type="button" class="button button-primary upload-mission-images" value="Add Images" />';
                        
                        echo '<input type="hidden" id="custom_theme_options_about_mission_slider" name="custom_theme_options[about_mission_slider]" value="' . esc_attr(implode(',', $image_urls)) . '" />';
                        
                        echo '<div id="mission-image-preview">';
                        
                        if ($image_urls) {
                            $image_urls = explode(',', $image_urls[0]);
                            foreach ($image_urls as $image_url) {
                                echo '<div class="image-item" style="display: inline-block; position: relative; margin: 5px;">';
                                echo '<img src="' . esc_url($image_url) . '" style="max-width: 150px;" />';
                                echo '<button type="button" class="button button-secondary delete-mission-image" data-url="' . esc_attr($image_url) . '" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none;">X</button>';
                                echo '</div>';
                            }
                        }
                        
                        echo '</div>';
                        
                        function sanitize_about_mission_slider($input) {
                            $input = array_map('esc_url_raw', explode(',', $input));
                            return $input;
                        }
                        add_filter('pre_update_option_custom_theme_options', 'sanitize_about_mission_slider');
                    }   
                    
                ?> 

                <!-- TABS WRAP -->
                <?php
                $tabs = [
                    [ 'id' => 'tab-about-general', 'label' => 'About us page General', 'settings_section' => 'about-settings-general', ],
                    [ 'id' => 'tab-about-our-mission', 'label' => 'AboutOur Mission Section', 'settings_section' => 'about-settings-our-mission', ],
                ];
                ?>
                <div class="wrap">
                    <h2 class="nav-tab-wrapper">
                        <?php foreach ($tabs as $index => $tab): ?>
                            <a href="#<?php echo esc_attr($tab['id']); ?>" class="nav-tab <?php echo $index === 0 ? 'nav-tab-active' : ''; ?>">
                                <?php echo esc_html($tab['label']); ?>
                            </a>
                        <?php endforeach; ?>
                    </h2>

                    <?php foreach ($tabs as $index => $tab): ?>
                        <div id="<?php echo esc_attr($tab['id']); ?>" class="settings-tab" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                            <?php do_settings_sections($tab['settings_section']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>              
            </div>

            <div id="contact_us_settings" class="tabcontent">
                <!-- Contact General Tab -->
                <?php
                    add_settings_section( 'contact_us_settings_section', 'Contact us Settings', null, 'contact-general-settings' );
            
                    add_settings_field( 'contact_main_heading', 'Contact us Main Heading', 'contact_main_heading_callback', 'contact-general-settings', 'contact_us_settings_section' );            
                    add_settings_field( 'contact_main_desc', 'Contact us Description Heading', 'contact_main_desc_callback', 'contact-general-settings', 'contact_us_settings_section' ); 
                    add_settings_field( 'contact_main_img', 'Contact us Main Image', 'contact_main_img_callback', 'contact-general-settings', 'contact_us_settings_section' );            
                    add_settings_field( 'contact_main_form', 'Contact us Form', 'contact_main_form_callback', 'contact-general-settings', 'contact_us_settings_section' );            
                    add_settings_field( 'contact_map_link', 'Contact us Map iframe', 'contact_map_link_callback', 'contact-general-settings', 'contact_us_settings_section' );            


                    function contact_main_heading_callback() {
                        $contact_main_heading = get_custom_field_value('contact_main_heading');
                        $contact_main_heading = isset($contact_main_heading) ? esc_textarea(stripslashes($contact_main_heading)) : '';
                        echo '<textarea name="custom_theme_options[contact_main_heading]" rows="2" cols="100">' . $contact_main_heading . '</textarea>';
                    }
                    function contact_main_desc_callback() {
                        $contact_main_desc = get_custom_field_value('contact_main_desc');
                        $contact_main_desc = isset($contact_main_desc) ? esc_textarea(stripslashes($contact_main_desc)) : '';
                        echo '<textarea name="custom_theme_options[contact_main_desc]" rows="2" cols="100">' . $contact_main_desc . '</textarea>';
                    }
                    
                    function contact_main_img_callback() {
                        $image_url = get_custom_field_value('contact_main_img') ?? '';
                        ?>
                        <div class="image-field-container">
                            <input type="hidden" class="image-field-url" name="custom_theme_options[contact_main_img]" value="<?php echo esc_url($image_url); ?>" />
                            <img class="image-preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 20%; height: auto; display: <?php echo $image_url ? 'block' : 'none'; ?>;" />
                            <input type="button" class="button upload-image-button" value="Upload Image" />
                            <input type="button" class="button remove-image-button" value="Remove Image" style="display: <?php echo $image_url ? 'inline-block' : 'none'; ?>;" />
                        </div>
                        <?php
                    }
                    function contact_main_form_callback() {
                        $selected_form = get_custom_field_value('contact_main_form');
                        
                        $forms = get_posts(array(
                            'post_type' => 'wpcf7_contact_form', // Post type for Contact Form 7 forms
                            'numberposts' => -1 // Retrieve all forms
                        ));
                        
                        echo '<select name="custom_theme_options[contact_main_form]">';
                        foreach ($forms as $form) {
                            $form_id = $form->ID;
                            $form_title = $form->post_title;
                            echo '<option value="' . esc_attr($form_id) . '"' . selected($selected_form, $form_id, false) . '>' . esc_html($form_title) . '</option>';
                        }
                        echo '</select>';
                    }
                    
                    function contact_map_link_callback() {
                        $contact_map_link = get_custom_field_value('contact_map_link');
                        $contact_map_link = isset($contact_map_link) ? esc_textarea(stripslashes($contact_map_link)) : '';
                        echo '<textarea name="custom_theme_options[contact_map_link]" rows="4" cols="100">' . $contact_map_link . '</textarea>';
                    }
                    
                ?> 
                <!-- Contact Details Tab -->
                <?php
                    add_settings_section( 'contact_us_settings_section', 'Contact Details Settings', null, 'contact-details-settings' );
            
                    add_settings_field( 'contact_email', 'Contact Email', 'contact_email_callback', 'contact-details-settings', 'contact_us_settings_section' );            
                    add_settings_field( 'contact_phone', 'Contact phone number', 'contact_phone_callback', 'contact-details-settings', 'contact_us_settings_section' );            
                    add_settings_field( 'contact_address', 'Contact Address', 'contact_address_callback', 'contact-details-settings', 'contact_us_settings_section' );            


                    function contact_email_callback() {
                        $contact_email = get_custom_field_value('contact_email');
                        $contact_email = isset($contact_email) ? esc_textarea(stripslashes($contact_email)) : '';
                        echo '<input type="email" name="custom_theme_options[contact_email]" size="50" value="' . $contact_email . '">';
                    }
                    function contact_phone_callback() {
                        $contact_phone = get_custom_field_value('contact_phone');
                        $contact_phone = isset($contact_phone) ? esc_textarea(stripslashes($contact_phone)) : '';
                        echo '<input type="tel" maxlength="13" name="custom_theme_options[contact_phone]" size="50" value="' . $contact_phone . '">';
                    }
                    function contact_address_callback() {
                        $contact_address = get_custom_field_value('contact_address');
                        $contact_address = isset($contact_address) ? esc_textarea(stripslashes($contact_address)) : '';
                        echo '<textarea name="custom_theme_options[contact_address]" rows="2" cols="100">' . $contact_address . '</textarea>';
                    }   
                ?> 

                <!-- TABS WRAP -->
                <?php
                    $tabs = [
                        [ 'id' => 'tab-contact-general', 'label' => 'Contact us General', 'settings_section' => 'contact-general-settings', ],
                        [ 'id' => 'tab-contact-details', 'label' => 'Contact Details', 'settings_section' => 'contact-details-settings', ],
                    ];
                ?>
                <div class="wrap">
                    <h2 class="nav-tab-wrapper">
                        <?php foreach ($tabs as $index => $tab): ?>
                            <a href="#<?php echo esc_attr($tab['id']); ?>" class="nav-tab <?php echo $index === 0 ? 'nav-tab-active' : ''; ?>">
                                <?php echo esc_html($tab['label']); ?>
                            </a>
                        <?php endforeach; ?>
                    </h2>

                    <?php foreach ($tabs as $index => $tab): ?>
                        <div id="<?php echo esc_attr($tab['id']); ?>" class="settings-tab" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                            <?php do_settings_sections($tab['settings_section']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>              
            </div>
             <br style="clear: both;">
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Validate input
function custom_theme_options_validate($input) {
    $text_fields = ['name','contact_phone'];
    foreach ($text_fields as $text_field) {
        if (isset($input[$text_field])) {
            $input[$text_field] = sanitize_text_field($input[$text_field]);
        }
    }

    $textarea_fields = ['discovery_gallerys_heading','contact_section_desc','our_features_heading','our_features_desc','our_teams_heading','our_teams_desc',''];
    foreach ($textarea_fields as $textarea_field) {
        if (isset($input[$textarea_field])) {
            $input[$textarea_field] = sanitize_textarea_field(stripslashes($input[$textarea_field]));
        }
    }
    
    $img_fields = [];
    $input['contact_email'] = sanitize_email($input['contact_email']);
    $input['image'] = esc_url_raw($input['image']);

    if (isset($input['our_clients_features']) && is_array($input['our_clients_features'])) {
        foreach ($input['our_clients_features'] as $key => $value) {
            $image = esc_url_raw($value['image']);
            $title = sanitize_text_field($value['title']);
            $description = sanitize_textarea_field($value['description']);

            if (!empty($image) && !empty($title) && !empty($description)) {
                $input['our_clients_features'][$key] = [
                    'image' => $image,
                    'title' => $title,
                    'description' => $description,
                ];
            } else {
                unset($input['our_clients_features'][$key]);
            }
        }

        $input['our_clients_features'] = array_values($input['our_clients_features']);
    }
    return $input;
}

function process_custom_theme_options() {
    if ( isset($_POST['custom_theme_options']) && check_admin_referer('custom_theme_options_nonce') ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cs_fields';
        $new_values = $_POST['custom_theme_options']; 

        $current_fields = $wpdb->get_col( "SELECT cs_field_name FROM $table_name" );

        $fields_in_use = [];

        foreach ( $new_values as $field_name => $field_value ) {

            $fields_in_use[] = $field_name;

            $existing = $wpdb->get_var( $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE cs_field_name = %s",
                $field_name
            ));

            if ( $existing > 0 ) {
                $wpdb->update(
                    $table_name,
                    array('cs_field_value' => maybe_serialize($field_value)),
                    array('cs_field_name' => $field_name),
                    array( '%s' ),
                    array( '%s' )
                );
            } else {
                $wpdb->insert(
                    $table_name,
                    array(
                        'cs_field_name'  => $field_name,
                        'cs_field_value' => maybe_serialize($field_value),
                    ),
                    array( '%s', '%s' )
                );
            }
        }

        $fields_to_remove = array_diff( $current_fields, $fields_in_use );

        if ( !empty( $fields_to_remove ) ) {
            foreach ( $fields_to_remove as $field_to_remove ) {
                $wpdb->delete(
                    $table_name,
                    array('cs_field_name' => $field_to_remove),
                    array( '%s' )
                );
            }
        }

        wp_redirect(admin_url('admin.php?page=custom-theme-options&settings-updated=true'));
        exit;
    }
}
add_action('admin_post_save_custom_theme_options', 'process_custom_theme_options');

function get_custom_field_value($field_name) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cs_fields';

    $result = $wpdb->get_var( $wpdb->prepare(
        "SELECT cs_field_value FROM $table_name WHERE cs_field_name = %s",
        $field_name
    ));

    // Apply stripslashes if the value is a string and is not an URL
    if (is_string($result) && !filter_var($result, FILTER_VALIDATE_URL)) {
        $result = stripslashes($result);
    }

    return maybe_unserialize($result);
}

?>
