<?php
if (!function_exists('educational_setup')) :
   function educational_setup() {
       global $content_width;
       if (!isset($content_width)) {
           $content_width = 770;
       }
		/*
		 * Make Educational theme available for translation.
		 */
	   load_theme_textdomain( 'educational', get_template_directory() . '/languages' );
       add_theme_support('automatic-feed-links');
       add_theme_support( 'title-tag' );
       add_theme_support('post-thumbnails');
       set_post_thumbnail_size(672, 372, true);
       add_image_size('educational-full-width', 1038, 576, true);
       add_image_size('brands-full-width', 100, 31, true);
       add_image_size('our_features-full-width', 594, 396, true);
       add_image_size('article-thumb', 606, 404, true);
       add_image_size('journeys-thumb', 1024, 767, true);
       // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'header_menu' => __('Header Menu'),
            'footer_menu_1' => __('Footer Menu 1'),
            'footer_menu_2' => __('Footer Menu 2'),
            'copyright_menu' => __('Copyright Menu'),
        ));
        //custom background
        add_theme_support( 'custom-background', apply_filters( 'educational_custom_background_args', array(
                'default-color' => 'f5f5f5',
            ) ) );
        add_theme_support( 'custom-header', apply_filters( 'educational_custom_header_args', array(
            'uploads'       => true,
            'flex-height'   => true,
            'default-text-color' => '#000',
            'header-text' => true,
            'height' => '120',
            'width'  => '1260'
            ) ) );
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
            'priority' => 11,     
            'header-text' => array('img-responsive-logo', 'site-description-logo'),
        ) );
       /*
	   * Switch default core markup for search form, comment form, and comments
	   * to output valid HTML5.
	   */
       add_theme_support('html5', array(
           'search-form', 'comment-form', 'comment-list',
       ));
       // Add support for featured content.
       add_theme_support('featured-content', array(
           'featured_content_filter' => 'educational_get_featured_posts',
           'max_posts' => 6,
       ));
       
       add_theme_support( 'woocommerce' );

	   // This theme uses its own gallery styles.
		add_filter('use_default_gallery_style', '__return_false');   }
    
        // This theme uses wp_nav_menu() in one location.
	

endif;



// educational_setup
add_action('after_setup_theme', 'educational_setup');

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}


/***** Theme function files ******/
require get_template_directory() . "/inc/customizer.php";
require get_template_directory() . "/inc/enqueue_script.php";
require get_template_directory() . "/inc/breadcrumbs.php";




// Add by Mayur Patel 19-07-2024 Start

// Enqueue Select2 Scripts and Styles
// Enqueue Select2 Scripts and Styles
function enqueue_select2_scripts() {
    wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0', true);
    wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0');
}
add_action('admin_enqueue_scripts', 'enqueue_select2_scripts');

// Add custom meta box to WooCommerce products
function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'School List', // $title
        'show_custom_meta_box', // $callback
        'product', // $screen
        'side', // $context
        'default' // $priority
    );
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Show custom meta box
function show_custom_meta_box() {
    global $post;
    $custom_items = get_posts(array('post_type' => 'school', 'posts_per_page' => -1));
    $selected_item = get_post_meta($post->ID, 'custom_item', true);

    // Nonce field for security
    wp_nonce_field(basename(__FILE__), 'custom_meta_box_nonce');
    
    echo '<select name="custom_item" id="custom_item" style="width: 100%;">';
    echo '<option value="">Select a School</option>';
    foreach ($custom_items as $custom_item) {
        echo '<option value="' . esc_attr($custom_item->ID) . '" ' . selected($selected_item, $custom_item->ID, false) . '>' . esc_html($custom_item->post_title) . '</option>';
    }
    echo '</select>';

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#custom_item').select2({
                placeholder: "Select a School",
                allowClear: true
            });
        });
    </script>
    <?php
}

// Save the custom meta box data
function save_custom_meta_box_data($post_id) {
    // Verify nonce
    if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check user permissions
    if (isset($_POST['post_type']) && 'product' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    } else {
        return $post_id;
    }

    // Save or delete the custom item
    $new_value = (isset($_POST['custom_item']) ? sanitize_text_field($_POST['custom_item']) : '');
    $meta_key = 'custom_item';

    if ($new_value) {
        update_post_meta($post_id, $meta_key, $new_value);
    } else {
        delete_post_meta($post_id, $meta_key);
    }
}
add_action('save_post', 'save_custom_meta_box_data');





function enqueue_media_uploader() {
    if (is_admin()) {
        wp_enqueue_media();
        wp_enqueue_script('taxonomy-image-upload', get_template_directory_uri() . '/js/taxonomy-image-upload.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

// Add the form field to add a new term
function add_taxonomy_image_field() {
    ?>
    <div class="form-field">
        <label for="taxonomy_image"><?php _e('Image', 'your-text-domain'); ?></label>
        <input type="text" name="taxonomy_image" id="taxonomy_image" class="taxonomy-image-url" value="" />
        <button class="taxonomy-image-upload-button button"><?php _e('Upload/Add Image', 'your-text-domain'); ?></button>
        <p class="description"><?php _e('Enter the URL of the image or upload an image.', 'your-text-domain'); ?></p>
    </div>
    <?php
}
add_action('language_locations_add_form_fields', 'add_taxonomy_image_field', 10, 2);

// Add the form field to edit a term
function edit_taxonomy_image_field($term) {
    $image_url = get_term_meta($term->term_id, 'taxonomy_image', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="taxonomy_image"><?php _e('Image', 'your-text-domain'); ?></label></th>
        <td>
            <input type="text" name="taxonomy_image" id="taxonomy_image" class="taxonomy-image-url" value="<?php echo esc_attr($image_url) ? esc_attr($image_url) : ''; ?>" />
            <button class="taxonomy-image-upload-button button"><?php _e('Upload/Add Image', 'your-text-domain'); ?></button>
            <p class="description"><?php _e('Enter the URL of the image or upload an image.', 'your-text-domain'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('language_locations_edit_form_fields', 'edit_taxonomy_image_field', 10, 2);

// Save the form field
function save_taxonomy_image($term_id) {
    if (isset($_POST['taxonomy_image']) && '' !== $_POST['taxonomy_image']) {
        $image_url = sanitize_text_field($_POST['taxonomy_image']);
        add_term_meta($term_id, 'taxonomy_image', $image_url, true);
    }
}
add_action('created_language_locations', 'save_taxonomy_image', 10, 2);

// Save the form field on term edit
function update_taxonomy_image($term_id) {
    if (isset($_POST['taxonomy_image']) && '' !== $_POST['taxonomy_image']) {
        $image_url = sanitize_text_field($_POST['taxonomy_image']);
        update_term_meta($term_id, 'taxonomy_image', $image_url);
    } else {
        delete_term_meta($term_id, 'taxonomy_image');
    }
}
add_action('edited_language_locations', 'update_taxonomy_image', 10, 2);



function custom_theme_woocommerce_template_loader( $template, $template_name, $template_path ) {
    global $woocommerce;

    $_template = $template;

    if ( ! $template_path ) $template_path = $woocommerce->template_url;

    $plugin_path  = WP_PLUGIN_DIR . '/woocommerce/templates/';

    $theme_template = locate_template( array(
        $template_path . $template_name,
        $template_name
    ) );

    if ( $theme_template ) {
        $template = $theme_template;
    } else {
        $template = $plugin_path . $template_name;
    }

    return $template;
}
add_filter( 'woocommerce_locate_template', 'custom_theme_woocommerce_template_loader', 10, 3 );

function get_custom_excerpt($length = 140, $source = null) {
    if ($source == null) {
        $source = get_the_excerpt();
        if (empty($source)) {
            $source = get_the_content();
        }
    }
    $source = strip_tags(strip_shortcodes($source)); // Remove HTML and shortcodes
    if (strlen($source) <= $length) {
        return $source;
    }
    $excerpt = substr($source, 0, $length);
    $space_pos = strrpos($excerpt, ' ');
    if ($space_pos) {
        $excerpt = substr($excerpt, 0, $space_pos);
    }
    return $excerpt . '...';
}

add_action( 'wp_footer', 'show_template' );
function show_template() {
    global $template;
    // print_r( $template );
}

/* ******************************** SVG Image Support ******************************* */

function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function arino_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer One', 'educational' ),
		'id'            => 'footer-one',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Two', 'educational' ),
		'id'            => 'footer-two',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Three', 'educational' ),
		'id'            => 'footer-three',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Copyright Menu', 'educational' ),
		'id'            => 'copyright_menu_sidebar',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'arino_widgets_init' );

// Function to display custom logo
function custom_logo_shortcode() {
    $logo_url = get_theme_mod('custom_logo');
    
    if ($logo_url) {
        $logo_img = wp_get_attachment_image_url($logo_url, 'full');
        return $logo_img;
    } else {
        return 'No logo found.';
    }
}
add_shortcode('custom_logo', 'custom_logo_shortcode');


/* ADD MORE SCHOOL FEATURES */
function admin_script_enqueue(){
    wp_enqueue_script('jquery'); 
    wp_enqueue_script('enque-admin-script', get_template_directory_uri() . '/js/enque-admin-script.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'admin_script_enqueue');

function school_add_more_features_meta_box() {
    add_meta_box(
        'school_features_meta_box', // Unique ID
        'School Features', // Box title
        'school_features_meta_box_callback', // Content callback, must be of type callable
        'school', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'school_add_more_features_meta_box');

function school_features_meta_box_callback($post) {
    wp_nonce_field('school_save_features_data', 'school_features_meta_box_nonce');
    
    $features = get_post_meta($post->ID, '_school_features', true);
    
    echo '<div id="school-features-wrapper">';
    
    if (!empty($features)) {
        foreach ($features as $feature) {
            echo '
            <div class="school-feature-item" style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
                <p><label style="font-weight: bold;">Title:</label>
                <input type="text" name="school_features_title[]" value="' . esc_attr($feature['title']) . '" style="width: 100%;  margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;" /></p>
                <p><label style="font-weight: bold;">Description:</label>
                <textarea name="school_features_description[]" style="width: 100%;  margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">' . esc_textarea($feature['description']) . '</textarea></p>
                <button type="button" class="remove-feature" style="background-color: #e74c3c; color: #fff; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;">Remove</button>
            </div>';
        }
    }
    
    echo '</div>
    <button type="button" id="add-school-features" style="background-color: #002E57; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Add More Features</button>';
    
    ?>
    <?php
}

function school_save_features_data($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['school_features_meta_box_nonce'])) {
        return;
    }
    
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['school_features_meta_box_nonce'], 'school_save_features_data')) {
        return;
    }

    // Check if this is an autosave routine. If it is, our form has not been submitted; so we do nothing.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if the current user is allowed to edit the post.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Validate and sanitize data
    if (isset($_POST['school_features_title']) && isset($_POST['school_features_description'])) {
        $titles = $_POST['school_features_title'];
        $descriptions = $_POST['school_features_description'];
        
        $features = [];

        foreach ($titles as $key => $title) {
            $title = sanitize_text_field($title);
            $description = sanitize_textarea_field($descriptions[$key]);

            // Only add feature if title and description are not empty
            if (!empty($title) && !empty($description)) {
                $features[] = [
                    'title' => $title,
                    'description' => $description,
                ];
            }
        }

        if (!empty($features)) {
            update_post_meta($post_id, '_school_features', $features);
        } else {
            delete_post_meta($post_id, '_school_features');
        }
    } else {
        // If fields are not set, delete the post meta
        delete_post_meta($post_id, '_school_features');
    }
}
add_action('save_post', 'school_save_features_data');


/* ADD MORE Excursions meta box */
function excursions_add_more_features_meta_box() {
    add_meta_box(
        'excursions_features_meta_box', // Unique ID
        'excursions Features', // Box title
        'excursions_features_meta_box_callback', // Content callback, must be of type callable
        'excursions', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'excursions_add_more_features_meta_box');

function excursions_features_meta_box_callback($post) {
    wp_nonce_field('excursions_save_features_data', 'excursions_features_meta_box_nonce');
    
    $features = get_post_meta($post->ID, '_excursions_features', true);
    
    echo '<div id="excursions-features-wrapper">';
    
    if (!empty($features)) {
        foreach ($features as $feature) {
            echo '
            <div class="excursions-feature-item" style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
                <p><label style="font-weight: bold;">Description:</label>
                <textarea name="excursions_features_description[]" style="width: 100%;  margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;" required>' . esc_textarea($feature['description']) . '</textarea></p>
                <button type="button" class="remove-feature" style="background-color: #e74c3c; color: #fff; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer;">Remove</button>
            </div>';
        }
    }
    
    echo '</div>
    <button type="button" id="add-excursions-features" style="background-color: #002E57; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Add More Features</button>';
    
    ?>
    <?php
}

function excursions_save_features_data($post_id) {
    if (!isset($_POST['excursions_features_meta_box_nonce'])) { return; }
    
    if (!wp_verify_nonce($_POST['excursions_features_meta_box_nonce'], 'excursions_save_features_data')) { return; }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }

    if (!current_user_can('edit_post', $post_id)) { return; }

    if (isset($_POST['excursions_features_description'])) {
        $descs = $_POST['excursions_features_description'];
        
        $features = [];

        foreach ($descs as $key => $desc) {
            $description = sanitize_textarea_field($descs[$key]);

            if ( !empty($description)) {
                $features[] = [ 'description' => $description,];
            }
        }

        if (!empty($features)) {
            update_post_meta($post_id, '_excursions_features', $features);
        } else {
            delete_post_meta($post_id, '_excursions_features');
        }
    } else {
        delete_post_meta($post_id, '_excursions_features');
    }
}
add_action('save_post', 'excursions_save_features_data');

/* ADD MORE Excursions meta box - END*/

function set_default_featured_image($post_id) {
    if (!has_post_thumbnail($post_id)) {
        $default_image_id = 182; // Replace with the ID of your default image
        set_post_thumbnail($post_id, $default_image_id);
    }
}

add_action('save_post', 'set_default_featured_image');


/* NEW 'product'  meta boxes */

function create_product_metabox($id, $title, $callback, $post_type = 'post', $context = 'normal', $priority = 'high') {
    add_meta_box($id, $title, $callback, $post_type, $context, $priority);
}

function product_metabox_callback($post, $meta_key, $fields) {
    wp_nonce_field($meta_key . '_nonce', $meta_key . '_nonce');
    $meta_value = get_post_meta($post->ID, $meta_key, true);

    echo '
    <div id="' . esc_attr($meta_key) . '-container" style="margin-bottom: 20px;">';
    if ($meta_value) {
        foreach ($meta_value as $index => $item) {
            echo '<div class="wrap-' . esc_attr($meta_key) . '" data-index="' . esc_attr($index) . '" style="margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;">
            <button type="button" class="remove-' . esc_attr($meta_key) . '-wrap" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-bottom: 10px;">Remove Wrap</button>';
            foreach ($fields as $field_key => $placeholder) {
                echo '<input type="text" name="' . esc_attr($meta_key) . '[' . esc_attr($index) . '][' . esc_attr($field_key) . ']" value="' . esc_attr($item[$field_key]) . '" placeholder="' . esc_attr($placeholder) . '" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"/>';
            }
            echo '
            <div class="titles-container" style="margin-top: 10px;">';
            if (!empty($item['titles'])) {
                foreach ($item['titles'] as $titleIndex => $title) {
                    echo '<div class="title-' . esc_attr($meta_key) . '" data-index="' . esc_attr($titleIndex) . '" style="margin-bottom: 10px;">';
                    echo '<input type="text" name="' . esc_attr($meta_key) . '[' . esc_attr($index) . '][titles][' . esc_attr($titleIndex) . ']" value="' . esc_attr($title) . '" placeholder="Title" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"/>';
                    echo '<button type="button" class="remove-' . esc_attr($meta_key) . '-title" style="background-color: #d9534f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-left: 10px;">Remove Title</button>';
                    echo '</div>';
                }
            }
            echo '</div>
            <button type="button" class="add-' . esc_attr($meta_key) . '-title" style="background-color: #5bc0de; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-top: 10px;">Add Title</button>';
            echo '</div>';
        }
    }
    echo '</div>
    <button type="button" id="add-wrap-' . esc_attr($meta_key) . '" style="background-color: #5cb85c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">Add Wrap</button>';
}


function save_product_metabox_data($post_id, $meta_key, $fields) {
    if (!isset($_POST[$meta_key . '_nonce']) || !wp_verify_nonce($_POST[$meta_key . '_nonce'], $meta_key . '_nonce')) { return; }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }

    if (!current_user_can('edit_post', $post_id)) { return; }

    if (isset($_POST[$meta_key])) {
        $meta_value = array_map(function($item) use ($fields) {
            $sanitized = [];
            foreach ($fields as $field_key => $placeholder) {
                $sanitized[$field_key] = sanitize_text_field($item[$field_key]);
            }
            if (!empty($item['titles'])) {
                $sanitized['titles'] = array_map('sanitize_text_field', $item['titles']);
            }

            return $sanitized;
        }, $_POST[$meta_key]);
        update_post_meta($post_id, $meta_key, $meta_value);
    } else {
        delete_post_meta($post_id, $meta_key);
    }
}

add_action('add_meta_boxes', function() {
    create_product_metabox(
        'whats_included_meta_box', 
        'What\'s included', 
        function($post) {
            product_metabox_callback($post, 'whats_included', ['title' => 'Wrap Title']);
        }, 
        'product'
    );

    create_product_metabox(
        'optional_addons_meta_box', 
        'Optional Add ons', 
        function($post) {
            product_metabox_callback($post, 'optional_addons', ['title' => 'Wrap Title']);
        }, 
        'product'
    );

    create_product_metabox(
        'course_highlights_meta_box', 
        'Course Highlights', 
        function($post) {
            product_metabox_callback($post, 'course_highlights', ['title' => 'Wrap Title']);
        }, 
        'product'
    );
});

add_action('save_post', function($post_id) {
    save_product_metabox_data($post_id, 'whats_included', ['title' => 'Wrap Title']);
    save_product_metabox_data($post_id, 'optional_addons', ['title' => 'Wrap Title']);
    save_product_metabox_data($post_id, 'course_highlights', ['title' => 'Wrap Title']);
});

/* NEW 'product'  meta boxes - END */



function custom_enqueue_scripts() {
    if ( is_product() ) {
        wp_enqueue_script( 'custom-tabs', get_stylesheet_directory_uri() . '/js/custom-tabs.js', array( 'jquery' ), null, true );
        wp_enqueue_style( 'custom-tabs-style', get_stylesheet_directory_uri() . '/css/custom-tabs.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );


add_action('wp_ajax_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart'); 
add_action('wp_ajax_nopriv_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');          
function ql_woocommerce_ajax_add_to_cart() {  
    $product_id = apply_filters('ql_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id); 
    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) { 
    do_action('ql_woocommerce_ajax_added_to_cart', $product_id);
        if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) { 
            wc_add_to_cart_message(array($product_id => $quantity), true); 
        } 
        WC_AJAX :: get_refreshed_fragments(); 
    } else { 
        $data = array( 
            'error' => true,
            'product_url' => apply_filters('ql_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
        echo wp_send_json($data);
    }
    wp_die();
}