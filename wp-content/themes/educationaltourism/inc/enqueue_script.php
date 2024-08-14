<?php
/*
 * Enqueue scripts and styles for the front end.
 */
function educational_scripts() {
    global $educational_options;

    // Main CSS
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css', array(), null, 'all');
    wp_enqueue_style('owl-carousel-css', get_template_directory_uri() . '/css/owl-carousel.css', array(), null, 'all');
    wp_enqueue_style('owl-theme-css', get_template_directory_uri() . '/css/owl-theme.css', array(), null, 'all');
    wp_enqueue_style('select2-css', get_template_directory_uri() . '/css/select2.css', array(), null, 'all');
    wp_enqueue_style('swiper-css', get_template_directory_uri() . '/css/swiper.css', array(), null, 'all');
    wp_enqueue_style('slick-css', get_template_directory_uri() . '/css/slick.css', array(), null, 'all');
    // wp_enqueue_style('responsive-css', get_template_directory_uri() . '/css/responsive.css', array(), null, 'all');

    // Fonts CSS
    wp_enqueue_style('fontawesome-css', get_template_directory_uri() . '/css/fontawesome.css', array(), null, 'all');
    wp_enqueue_style('fonts-css', get_template_directory_uri() . '/css/fonts.css', array(), null, 'all');

    // Main theme style
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_style('responsive-css', get_template_directory_uri() . '/css/responsive.css', array(), null, 'all');

    // Main JS 
    wp_enqueue_script('jquery'); // Ensure jQuery is enqueued first
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), null, true);
    wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/js/owl-carousel.js', array('jquery'), null, true);
    wp_enqueue_script('select2-js', get_template_directory_uri() . '/js/select2.js', array('jquery'), null, true);
    wp_enqueue_script('slick-js', get_template_directory_uri() . '/js/slick.js', array('jquery'), null, true);
    wp_enqueue_script('swiper-js', get_template_directory_uri() . '/js/swiper.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-validation', '//cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js', array('jquery'), null, true);
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);

    wp_localize_script('custom-js', 'userData', array(
        'isLoggedIn' => is_user_logged_in()
    ));

    if ( is_product() ) {
        wp_enqueue_script( 'custom-tabs', get_stylesheet_directory_uri() . '/js/custom-tabs.js', array( 'jquery' ), null, true );
        wp_enqueue_style( 'custom-tabs-style', get_stylesheet_directory_uri() . '/css/custom-tabs.css' );
    }

    
}
add_action('wp_enqueue_scripts', 'educational_scripts');
?>
