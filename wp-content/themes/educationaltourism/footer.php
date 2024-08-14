<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Educational_Tourism
 */

?>
<?php
if(function_exists('get_custom_field_value')){
    $contact_email = get_custom_field_value('contact_email') ?: '#';
    $contact_phone = get_custom_field_value('contact_phone') ?: 'Empty field';
    $contact_address = get_custom_field_value('contact_address') ?: 'Empty field';
    $copyright_name = get_custom_field_value('copyright_name') ?: 'Empty field';
    $copyright_text = get_custom_field_value('copyright_text') ?: 'Empty field';
    $contact_section_title = get_custom_field_value('contact_section_title') ?: 'Empty field';
    $contact_section_desc = get_custom_field_value('contact_section_desc') ?: 'Empty field';
    $contact_main_form = get_custom_field_value('contact_main_form') ?: '';
    $social_media = get_custom_field_value('social_media');
    /* Post Types Heading */
    $brands_heading = get_custom_field_value('brands_heading') ?: 'Empty heading';

}
?>

<footer class="footer_wrapp">
    <?php if(!is_page('contact-us')){ ?>
        <section class="footer_top_main">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="subscribe_footer_left">
                            <div class="main_heading">
                                <h3>Submit your request!</h3>
                                <p>Ready to embark on an unforgettable adventure?</p>
                                <p>Share your vision with us by submitting your request, and we'll swiftly respond to make your travel dreams a splendid reality.</p>
                            </div>
        
                            <div class="client_heading">
                                <h4>Trusted by all the largest travel brands</h4>
                            </div>
                            
                            <div class="row">
                                <?php
                                    $args = array(
                                        'post_type' => 'brands',
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish',
                                        'orderby' => 'title',
                                        'order' => 'ASC'
                                    );
                                    $brands_query = new WP_Query($args);
                                    if ($brands_query->have_posts()) :
                                        while ($brands_query->have_posts()) : $brands_query->the_post();
                                            $brand_logo = get_the_post_thumbnail_url(get_the_ID(), 'brands-full-width');
                                            if ($brand_logo) :
                                                ?>
                                                <div class="col-6 col-sm-4 col-md-4">
                                                    <div class="client_logo">
                                                        <img src="<?php echo esc_url($brand_logo); ?>" alt="<?php the_title_attribute(); ?>">
                                                    </div>
                                                </div>
                                                <?php
                                            endif;
                                        endwhile;
                                        wp_reset_postdata();
                                    endif;
                                ?>
                                <?php /*
                                <div class="col-6 col-sm-4 col-md-4">
                                    <div class="client_logo">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/client_logo1.svg" alt="client logo">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-4">
                                    <div class="client_logo">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/client_logo2.svg" alt="client logo">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-4">
                                    <div class="client_logo">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/client_logo3.svg" alt="client logo">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-4">
                                    <div class="client_logo">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/client_logo4.svg" alt="client logo">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-4">
                                    <div class="client_logo">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/client_logo5.svg" alt="client logo">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4 col-md-4">
                                    <div class="client_logo">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/client_logo6.svg" alt="client logo">
                                    </div>
                                </div>
                                */ ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <div class="subscribe_footer_right">
                            <form action="#" method="#">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form_group">
                                            <input type="text" name="name" placeholder="Your Name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form_group">
                                            <input type="email" name="email" placeholder="Your Email" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form_group">
                                            <input type="text" name="Subject" placeholder="Your Subject" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form_group">
                                            <input type="text" name="phone" placeholder="Your Phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form_group">
                                            <textarea name="massage" id="" placeholder="Your Massage" rows="8" cols="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form_group_button">
                                            <input type="submit" name="button" value="Submit" class="button_main">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
    <div class="footer_main">
        <div class="footer_top_wrapp">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-5 col-md-6">
                        <div class="footer_logo">
                            <a href="#">
                                <img width="150" src="<?php echo get_template_directory_uri(); ?>/images/educational-tourism.png" alt="educational tourism">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-6">
                        <div class="footer_socail">
                            <h4>Follow Us</h4>
                            <ul>
                                <li>
                                    <a href="#">
                                        <span class="fa-brands fa-facebook-f"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa-brands fa-instagram"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa-brands fa-x-twitter"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa-brands fa-linkedin-in"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa-brands fa-youtube"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer_bottom_wrapp">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer_bottom">
                            <div class="footer_left">
                                <div class="footer_contact">
                                    <h4 class="footer_heading">Contact</h4>
                                    <div class="footer_info">
                                        <h6>
                                            <span class="fa-regular fa-location-dot"></span> Address
                                        </h6>
                                        <p>Sønder Boulevard 87. 1720, Copenhagen, Denmark</p>
                                    </div>
                                    <div class="footer_info">
                                        <h6>
                                            <span class="fa-regular fa-at"></span> Email
                                        </h6>
                                        <p><a href="mailto:contact@educationltourism.com">contact@educationltourism.com</a></p>
                                    </div>
                                    <div class="footer_info">
                                        <h6>
                                            <span class="fa-regular fa-phone-volume"></span> Phone
                                        </h6>
                                        <p><a href="telto:+4542465140">+45 42465140</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="footer_right">
                                <div class="footer_right_top">
                                    <div class="footermenu">
                                    <?php if (is_active_sidebar('footer-one')) {
                                        echo '<div class="footer_menu">';
                                        dynamic_sidebar('footer-one');
                                        echo '</div>';
                                    } ?>
                                    <?php if (is_active_sidebar('footer-two')) {
                                        echo '<div class="footer_menu">';
                                        dynamic_sidebar('footer-two');
                                        echo '</div>';
                                    } ?>
                                    <?php if (is_active_sidebar('footer-three')) {
                                        echo '<div class="footer_menu">';
                                        dynamic_sidebar('footer-three');
                                        echo '</div>';
                                    } ?>
                                        <!-- <div class="footer_menu">
                                            <h4 class="footer_heading">Company</h4>
                                            <ul>
                                                <li>
                                                    <a href="index.html">Home</a>
                                                </li>
                                                <li>
                                                    <a href="about-us.html">About Us</a>
                                                </li>
                                                <li>
                                                    <a href="courses.html">Our Courses</a>
                                                </li>
                                                <li>
                                                    <a href="#">Embark Denmark</a>
                                                </li>
                                                <li>
                                                    <a href="contact-us.html">Contact Us</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="footer_menu">
                                            <h4 class="footer_heading">Support</h4>
                                            <ul>
                                                <li>
                                                    <a href="#">Get in Touch</a>
                                                </li>
                                                <li>
                                                    <a href="#">Help Center</a>
                                                </li>
                                                <li>
                                                    <a href="#">Live Chat</a>
                                                </li>
                                                <li>
                                                    <a href="#">How it works</a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                    <div class="footer_newsletter">
                                        <h4 class="footer_heading">Newsletter</h4>
                                        <p>Newsletter Subscribe to the free newsletter and stay up to date Your email address Send</p>
                                        <div class="newsletter_from">
                                            <form action="#" method="#">
                                                <div class="form_group">
                                                    <input type="email" name="email" placeholder="Your Email">
                                                    <input type="submit" name="button" value="Send" class="input_btns">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer_right_bottom">
                                    <div class="footer_company_rigis">
                                        <h5>CVR: 44872951</h5>
                                    </div>
                                    <div class="footer_payment">
                                        <ul>
                                            <li>
                                                <span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/visa_logo.png" alt="visa logo">
                                                </span>
                                                <span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/paypal_logo.png" alt="paypal logo">
                                                </span>
                                                <span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/master_logo.png" alt="master logo">
                                                </span>
                                                <span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/applepay_logo.png" alt="applepay logo">
                                                </span>
                                                <span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/Gpay_logo.png" alt="Gpay logo">
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright_footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="copytight">© Copyright <a href="index.html">Educational Tourism</a> 2024</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="footer_bottom_menu">
                            <ul>
                                <li>
                                    <a href="#">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="#">Terms of service</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>