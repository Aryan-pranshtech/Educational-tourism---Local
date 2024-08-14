<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Educational_Tourism
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php wp_head();  ?>
</head>
<body <?php body_class(); ?>>
<header class="header_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header_main">
                    <div class="language_main">
                        <span>English</span>
                        <!-- <span>Spanish</span> -->
                    </div>
                    
                    <div class="logo_main">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img width="100px" src="<?php echo do_shortcode('[custom_logo]'); ?>" alt="educational tourism">
                        </a>
                    </div>
                    <div class="header_right">
                        <div class="header_menu">
                            <nav class="navbar header_main">
                                <div class="offcanvas offcanvas-top header_menu_bg" tabindex="-1" id="HeaderMenu" aria-labelledby="HeaderMenuLabel">
                                    <span type="button" class="btnclose" data-bs-dismiss="offcanvas" aria-label="Close">
                                        <span class="toggler_close_icon">Close</span>
                                    </span>
                                    <div class="menu_bar">
                                        <?php
                                            wp_nav_menu(array(
                                                'theme_location' => 'header_menu', // The location registered in functions.php
                                                'container'      => false,          // No container element
                                                'menu_class'     => 'menu',          // CSS class for the <ul> element
                                            // 'walker'         => new Custom_Walker_Nav_Menu() // Optional: Custom walker for more control
                                            ));
                                        ?>
                                    </div>
                                </div>
                                <div class="header_right">
                                    <div class="navbar_toggle" data-bs-toggle="offcanvas" data-bs-target="#HeaderMenu" aria-controls="HeaderMenu" aria-label="Toggle navigation">
                                        <span class="toggler_menu_icon">Menu</span>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</header>


<?php
wp_head();  ?>



  
    