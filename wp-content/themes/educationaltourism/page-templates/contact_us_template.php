<?php
/**
* Template Name: Contact Us Page
*/

get_header(); ?>
<?php
$default_img = get_template_directory_uri().'/images/default_image/no_Image_banner.png';

if(function_exists('get_custom_field_value')){
    $contact_main_heading = get_custom_field_value('contact_main_heading') ?: 'Empty heading';
    $contact_main_desc = nl2br(get_custom_field_value('contact_main_desc')) ?: 'Empty description';
    $contact_main_img = get_custom_field_value('contact_main_img') ?: $default_img;
    $contact_main_form = get_custom_field_value('contact_main_form') ?: '';
    $contact_map_link = stripslashes(get_custom_field_value('contact_map_link'));

}
?>
<main class="main_wrapper">
    <section class="banner_section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/about_banner.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner_title">
                        <h1><?php the_title(); ?></h1>
                        <div class="breadcrumb_box">
                            <ul class="breadcrumb_list">
                                <li>
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                                </li>
                                <li>
                                    <span></span>
                                </li>
                                <li><?php the_title(); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2><?php echo $contact_main_heading; ?></h2>
                        <p><?php echo $contact_main_desc; ?></p>
                    </div>
                </div>
            </div>

            <div class="contact_bg">
                <div class="row">
                    <div class="col-md-6 col-lg-5">
                        <div class="contact_imgs" style="background-image: url('<?php echo $contact_main_img; ?>');"></div>
                    </div>
                    <div class="col-md-6 col-lg-7">
                        <div class="subscribe_footer_right" id="contact_us_form">
                            <?php
                            if ($contact_main_form) {
                                echo do_shortcode('[contact-form-7 id="' . $contact_main_form . '"]');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="last_section map_wrapp">
        <div class="map_logo">
            <img src="<?php echo do_shortcode('[custom_logo]'); ?>" alt="logo">
        </div>
        <!-- MAP iframe  -->
        <?php
            if($contact_map_link){ echo $contact_map_link; }
        ?>
    </section>

</main>

<?php get_footer(); ?>