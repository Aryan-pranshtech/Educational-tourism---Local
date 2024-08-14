<?php
/**
* Template Name: Languages Page
*/

get_header(); ?>
<style>
    .custom-pagination ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 20px 0;
        justify-content: center;
        align-items: center;
    }

    .custom-pagination ul li {
        margin: 0 5px;
    }

    .custom-pagination ul li a,
    .custom-pagination ul li span {
        color: #002E57; 
        padding: 8px 16px;
        border: 1px solid #002E57; 
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
    }

    .custom-pagination ul li a:hover,
    .custom-pagination ul li span.current {
        background-color: #002E57;
        color: #fff; 
    }

    .custom-pagination ul li span.current {
        border-color: #002E57; 
        padding: 15px 20px;
    }
</style>
<main class="main_wrapper">
    <section class="banner_section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/about_banner.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner_title">
                        <h1>Educational <br> Tourism Experiences</h1>
                        <div class="breadcrumb_box">
                            <ul class="breadcrumb_list">
                                <li>
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                                </li>
                                <li>
                                    <span></span>
                                </li>
                                <li>All services </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                      <div class="banner_filter_bg">
                                    <div class="banner_filter_box">
                                        <div class="banner_filter_icon">
                                            <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/activity_icon.svg" alt="">
                                        </div>
                                        <div class="banner_filter_text">
                                            <h6>Languages</h6>
                                            <select id="ActivitySelect" style="width: 100%;">
                                            <option value="0">Select</option>
                                                <?php 
                                                    $terms = get_terms(array(
                                                        'taxonomy' => 'language_locations', 
                                                        'hide_empty' => false,
                                                        'parent' => 0,
                                                    ));
                                                    if (!empty($terms) && !is_wp_error($terms)) {
                                                        foreach ($terms as $term) {
                                                            ?>
                                                                <option value="<?php echo esc_html($term->term_id); ?>"><?php echo mb_strimwidth($term->name, 0, 25, '...'); ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="banner_filter_box">
                                        <div class="banner_filter_icon">
                                            <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/location_icon.svg" alt="">
                                        </div>
                                        <div class="banner_filter_text">
                                                <h6>Location</h6>
                                                <select id="LocationSelect" style="width: 100%;">
                                                    <option value="0">Select</option>
                                                    <?php 
                                                        $terms = get_terms(array(
                                                            'taxonomy' => 'language_locations', 
                                                            'hide_empty' => false,
                                                            // 'parent' => 0,
                                                        ));
                                                        if (!empty($terms) && !is_wp_error($terms)) {
                                                            foreach ($terms as $term) {
                                                                ?>
                                                                    <option value="<?php echo esc_html($term->term_id); ?>"><?php echo mb_strimwidth($term->name, 0, 25, '...'); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                    </div>
                                    
                                    <div class="banner_filter_box">
                                        <div class="banner_filter_icon">
                                            <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/experience_icon.svg" alt="">
                                        </div>
                                        <div class="banner_filter_text">
                                                <h6>School</h6>
                                                <select id="ExperienceSelect" style="width: 100%;">
                                                    <option value="0">Select</option>
                                                    <?php 
                                                        $args = array(
                                                            'post_type' => 'school', 
                                                        );
                                                        $query = new WP_Query($args);
                                                        if ($query->have_posts()) {
                                                            $counter = 0; // Counter to check for odd/even posts
                                                            while ($query->have_posts()) : $query->the_post();
                                                                echo '<option value="'.get_the_id().'">'.mb_strimwidth(get_the_title(), 0, 25, '...').'</option>';
                                                            endwhile;
                                                            wp_reset_postdata();
                                                        } 
                                                    ?>   
                                                </select>
                                            </div>
                                    </div>
                                    
                                    <div class="banner_filter_box">
                                        <div class="banner_filter_icon">
                                            <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/courses_icon.svg" alt="">
                                        </div>
                                        <div class="banner_filter_text">
                                                <h6>Courses</h6>
                                                <select id="CoursesSelect" style="width: 100%;">
                                                    <option value="0">Select</option>
                                                    <?php 
                                                        $args = array(
                                                            'post_type' => 'product', 
                                                        );
                                                        $query = new WP_Query($args);
                                                        if ($query->have_posts()) {
                                                            while ($query->have_posts()) : $query->the_post();
                                                                echo '<option value="'.get_the_id().'">'.mb_strimwidth(get_the_title(), 0, 25, '...').'</option>';
                                                            endwhile;
                                                            wp_reset_postdata();
                                                        } 
                                                    ?>  
                                                </select>
                                            </div>
                                    </div>
                                    <div class="banner_filter_search"> Search
                                        <span class="fa-solid fa-magnifying-glass"></span>
                                    </div>
                                </div>
                                <br><br>
                    <div class="main_heading">
                        <h2>All services </h2>
                        <p>Explore a Variety of Top Destinations to Learn Spanish in Spain</p>
                      
                    </div>
                </div>
            </div>

            <div class="row">
                <?php 
                    $terms = get_terms(array(
                        'taxonomy' => 'language_locations',
                        'hide_empty' => false,
                        'parent' => 0,
                    ));
                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            $image_url = get_term_meta($term->term_id, 'taxonomy_image', true);
                            $listing_and_single_image = get_field('listing_and_single_image', 'term_' . $term->term_id);
                            if ($image_url) { ?>
                                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                    <div class="courses_card card_box">
                                        <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                            <img src="<?php echo esc_url($listing_and_single_image['url']); ?>" alt="<?php echo esc_html($term->name); ?>" />
                                            <h5><?php echo esc_html($term->name); ?></h5>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }

                    /* $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $terms_per_page = 8;
                    $terms = get_terms(array( 'taxonomy' => 'language_locations', 'hide_empty' => false, 'number' => $terms_per_page, 'offset' => ($paged - 1) * $terms_per_page, 'parent' => 0, ));
                    
                    $total_terms = count(get_terms(array( 'taxonomy' => 'language_locations', 'hide_empty' => false, 'parent' => 0, 'fields' => 'ids', )));

                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            $image_url = get_term_meta($term->term_id, 'taxonomy_image', true);
                            $listing_and_single_image = get_field('listing_and_single_image', 'term_' . $term->term_id);
                            if ($listing_and_single_image) { ?>
                                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                    <div class="courses_card card_box">
                                        <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                            <img src="<?php echo esc_url($listing_and_single_image['url']); ?>" alt="<?php echo esc_html($term->name); ?>" />
                                            <h5><?php echo esc_html($term->name); ?></h5>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    
                        // Display pagination links
                        $total_pages = ceil($total_terms / $terms_per_page);
                        $pagination_args = array( 'total'        => $total_pages, 'current'      => $paged, 'prev_text'    => '&laquo;', 'next_text'    => '&raquo;', 'type'         => 'list', );

                        $pagination = paginate_links($pagination_args);

                        if ($pagination) { echo '<div class="custom-pagination">' . $pagination . '</div>'; }
                    } else {
                        echo 'No terms found.';
                    } */
                ?>
            </div>
        </div>
    </section>

    <section class="last_section section_bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading">
                        <h2>Study Tours</h2>
                        <p>Explore a Variety of Top Destinations to Learn Spanish in Spain</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                    <div class="courses_card card_box">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/denmark_imgs.jpg" alt="Denmark imgs">
                            <h5>Denmark</h5>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                    <div class="courses_card card_box">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/spain_img.jpg" alt="Spain imgs">
                            <h5>Spain</h5>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                    <div class="courses_card card_box">
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/mexico_imgs.jpeg" alt="Mexico imgs">
                            <h5>Mexico</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="last_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading">
                        <h2>Secondary Education (Coming Soon)</h2>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <a href="#">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/malaga_city_img.webp" alt="Denmark imgs">
                </a>
            </div>
        </div>
    </section>


</main>



<?php get_footer(); ?>