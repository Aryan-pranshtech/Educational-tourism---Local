<?php
/**
* Template Name: Home Page
*/

get_header(); ?>
<?php
$default_img = get_template_directory_uri().'/images/default_image/no_Image_banner.png';
if(function_exists('get_custom_field_value')){

    $banner_slider_images = get_custom_field_value('banner_slider_images');
    
    $banner_text = get_custom_field_value('banner_text') ?: 'Empty heading';
    $banner_desc = get_custom_field_value('banner_desc') ?: 'Empty heading';

    if (!empty($banner_slider_images)) {
        $image_urls = explode(',', $banner_slider_images);
        
        if (count($image_urls) === 1) {
            $image_urls = array($image_urls[0], $image_urls[0]);
        }
    } else {
        $image_urls = array($default_img, $default_img);
    }

    $our_clients_heading = get_custom_field_value('our_clients_heading') ?: 'Empty heading';
    $our_clients_desc = get_custom_field_value('our_clients_desc') ?: 'Empty description';
    $our_clients_desc2 = get_custom_field_value('our_clients_desc2') ?: 'Empty description';
    $our_clients_features = get_custom_field_value('our_clients_features') ?: array();

    $choose_us_heading = get_custom_field_value('choose_us_heading') ?: 'Empty heading';
    $choose_us_desc = get_custom_field_value('choose_us_desc') ?: 'Empty description';
    $choose_us_slider = get_custom_field_value('choose_us_slider');

    if (!empty($choose_us_slider)) {
        $choose_us_slider_urls = explode(',', $choose_us_slider);
        
        if (count($choose_us_slider_urls) === 1) {
            $choose_us_slider_urls = array($choose_us_slider_urls[0]);
        }
    } else {
        $choose_us_slider_urls = array($default_img);
    }

    $about_heading = get_custom_field_value('about_heading') ?: 'Empty heading';
    $about_desc = get_custom_field_value('about_desc') ?: 'Empty description';
    $about_video_link = get_custom_field_value('about_video_link') ?: '';
    $about_bottom_text = get_custom_field_value('about_bottom_text') ?: 'Empty text';

    $discovery_gallerys_heading = get_custom_field_value('discovery_gallerys_heading') ?: 'Empty heading';

    $discover_heading = get_custom_field_value('discover_heading') ?: 'Empty text';
    $discover_desc = nl2br(get_custom_field_value('discover_desc')) ?: 'Empty text';
    $discover_desc2 = nl2br(get_custom_field_value('discover_desc2')) ?: 'Empty text';
    $discover_button_text = get_custom_field_value('discover_button_text') ?: 'Empty text';
    $discover_button_url = get_custom_field_value('discover_button_url') ?: '#';
}
?>

<main class="main_wrapper">
    <section class="hero_wrapper">
        <div id="heroslider" class="carousel slide carousel-fade heroslider" data-bs-ride="carousel" data-bs-interval="7000" data-bs-pause="false">
            <div class="carousel-inner">
                <?php
                    $slider = 0;
                    foreach ($image_urls as $image_url) {
                        $slider++;
                        $active = $slider==1 ?: 'active';
                        echo '
                        <div class="carousel-item '.$active.'">
                            <div class="slide">
                                <img src="'.$image_url.'" alt="slide-'.$slider.'" class="mainImage">
                                <div class="roundOuter"><img src="'.$image_url.'" alt="slide-'.$slider.'"></div>
                                <div class="roundInner"><img src="'.$image_url.'" alt="slide-'.$slider.'"></div>
                            </div>
                        </div>';
                    }
                ?>
                <?php /*
                <div class="carousel-item active">
                    <div class="slide">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/slider-imgs1.jpg" alt="slide-1" class="mainImage">
                        <div class="roundOuter"><img src="<?php echo get_template_directory_uri(); ?>/images/slider-imgs1.jpg" alt="slide-1"></div>
                        <div class="roundInner"><img src="<?php echo get_template_directory_uri(); ?>/images/slider-imgs1.jpg" alt="slide-1"></div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="slide">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/slider-imgs2.jpg" alt="slide-1" class="mainImage">
                        <div class="roundOuter"><img src="<?php echo get_template_directory_uri(); ?>/images/slider-imgs2.jpg" alt="slide-2"></div>
                        <div class="roundInner"><img src="<?php echo get_template_directory_uri(); ?>/images/slider-imgs2.jpg" alt="slide-2"></div>
                    </div>
                </div>
                */ ?>
            </div>
        </div>

        <div class="hero_banner_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="hero_content">
                            <h1><?php echo $banner_text; ?></h1>
                            <h6><?php echo $banner_desc; ?></h6>

                            <?php /* <div class="banner_filter">
                                <h5>What is Your Next Travel & Learning Experience?</h5>
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
                            </div> */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about_section" style="display: none">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about_content">
                        <div class="main_heading main_heading_center">
                            <h2><?php echo nl2br($about_heading); ?></h2>
                            <p><?php echo nl2br($about_desc); ?></p>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12 col-lg-11 col-xl-10 col-xxl-9">
                                <div class="about_video">
                                    <iframe width="100%" height="550px" src="https://www.youtube.com/embed/8xHMsYb7RDA" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                        <p><?php echo $about_bottom_text; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	
	<section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading  main_heading_center">
                        <h2>All services </h2>
                        <p>Explore a Variety of Top Destinations to Learn Spanish in Spain</p>
                        <div class="banner_filter_bg" style="display: none;">
                            <div class="banner_filter_box">
                                <div class="banner_filter_icon">
                                    <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/activity_icon.svg" alt="">
                                </div>
                                <div class="banner_filter_text">
                                    <h6>Cultural studies</h6>
                                    <select id="ActivitySelect">
                                        <option value="0">Select</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="banner_filter_box">
                                <div class="banner_filter_icon">
                                    <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/location_icon.svg" alt="">
                                </div>
                                <div class="banner_filter_text">
                                    <h6>Location</h6>
                                    <select id="LocationSelect">
                                        <option value="0">Select</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="banner_filter_box">
                                <div class="banner_filter_icon">
                                    <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/experience_icon.svg" alt="">
                                </div>
                                <div class="banner_filter_text">
                                    <h6>School</h6>
                                    <select id="ExperienceSelect">
                                        <option value="0">Select</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="banner_filter_box">
                                <div class="banner_filter_icon">
                                    <img width="40px" src="<?php echo get_template_directory_uri(); ?>/images/courses_icon.svg" alt="">
                                </div>
                                <div class="banner_filter_text">
                                    <h6>Courses</h6>
                                    <select id="CoursesSelect">
                                        <option value="0">Select</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="banner_filter_search"> Search
                                <span class="fa-solid fa-magnifying-glass"></span>
                            </div>
                        </div>
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

    <section class="section_bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
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

     <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
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

    <section class="discovery_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2><?php echo $discovery_gallerys_heading; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="gallerySlider owl-carousel owl-theme">
            <?php
            $args = array(
                'post_type' => 'discovery_gallerys',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'order' => 'ASC'
            );
            $gallery_query = new WP_Query($args);

            if ($gallery_query->have_posts()) :
                while ($gallery_query->have_posts()) : $gallery_query->the_post();
                    $gallery_image = get_the_post_thumbnail_url(get_the_ID(), 'full')  ?? $default_img;
                    if ($gallery_image) :
                        ?>
                        <div class="item">
                            <img src="<?php echo esc_url($gallery_image); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                        <?php
                    endif;
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>
    
    <section class="explorer_section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/explorer_bg.jpg');">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-md-10 col-lg-9 col-xl-8 col-xxl-7">
                    <div class="explorer_main">
                        <div class="main_heading">
                            <h2><?php echo stripslashes($our_clients_heading); ?></h2>
                            <p><?php echo nl2br(stripslashes($our_clients_desc)); ?></p>
                        </div>
                        <div class="explorer_main_list">
                        <?php
                            foreach($our_clients_features as $field){
                                $image = $field['image'] ?: '';
                                $title = $field['title'] ?: 'Empty title';
                                $description = $field['description'] ?: 'Empty description';
                                echo '
                                <div class="explorer_content">
                                    <div class="explorer_icon">
                                        <img src="'.$image.'" alt="students icon">
                                    </div>
                                    <div class="explorer_text">
                                        <h4>'.$title.'</h4>
                                        <p>'.nl2br($description).'</p>
                                    </div>
                                </div>';
                            }
                            ?>
                            <p><?php echo nl2br(stripslashes($our_clients_desc2)); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="choose_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2><?php echo nl2br($choose_us_heading); ?></h2>
                        <p><?php echo nl2br($choose_us_desc); ?></p>
                    </div>
                    <div class="choose_main">
                        <div class="row">
                            <div class="col-md-12 col-xl-7">
                                <div class="row">
                                    <?php
                                        $args = array(
                                            'post_type' => 'other_settings',
                                            'posts_per_page' => -1,
                                            'other_setting_taxonomy' => 'why-choose-us',
                                            'order' => 'ASC',
                                        );
                                        $other_settings_query = new WP_Query($args);
                                        if ($other_settings_query->have_posts()) :
                                            $i = 0;
                                            while ($other_settings_query->have_posts()) : $other_settings_query->the_post();
                                                $i++;
                                                $icon = get_the_post_thumbnail_url( get_the_ID(), 'choose-us-thumb' ); 
                                                $title = get_the_title(); 
                                                $description = get_the_content(); 
                                                $bg_class = ($i % 4 == 2 || $i % 4 == 3) ? ' choose_bg' : '';
                                        ?>
                                                <div class="col-md-6 d-flex">
                                                    <div class="choose_box <?php echo $bg_class; ?>">
                                                        <span class="choose_icon">
                                                            <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>">
                                                        </span>
                                                        <h6><?php echo esc_html($title); ?></h6>
                                                        <p><?php echo $description; ?></p>
                                                    </div>
                                                </div>
                                        <?php
                                            endwhile;
                                            wp_reset_postdata();
                                        endif;
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-5">
                                <div class="choose_slider_main">
                                    <div class="chooseSlider owl-theme owl-carousel">
                                        <?php
                                            foreach ($choose_us_slider_urls as $img_url) {
                                                echo '
                                                    <div class="item">
                                                        <div class="choose_imgs" style="background-image: url('.$img_url.')"></div>
                                                    </div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2>Destinations</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme relatedCities">
                    <?php 
                        if (is_front_page() || is_home()) {
                            $cat = get_queried_object();
                            $taxonomy = 'language_locations';

                            $top_terms = get_terms(array(
                                'taxonomy'   => $taxonomy,
                                'parent'     => 0, 
                                'hide_empty' => false
                            ));

                            foreach ($top_terms as $top_term) {
                                $cats = get_terms(array(
                                    'taxonomy'   => $taxonomy,
                                    'parent'     => $top_term->term_id,
                                    'hide_empty' => false
                                ));

                                if (!empty($cats) && !is_wp_error($cats)) {
                                    foreach ($cats as $cat) {
                                        $url = esc_url(get_term_link($cat));
                                        $listing_and_single_image = get_field('listing_and_single_image', 'term_' . $cat->term_id);
                                        $default_img = get_template_directory_uri() . '/images/default_image/no_Image_banner.png';
                                        ?>
                                        <div class="item">
                                            <div class="card_box courses_card">
                                                <div class="courses_imgs">
                                                <?php if ($listing_and_single_image) { ?>
                                                    <img src="<?php echo esc_url($listing_and_single_image['url']); ?>" alt="<?php echo esc_attr($listing_and_single_image['alt']); ?>" />
                                                <?php } else { ?>
                                                    <img src="<?php echo $default_img; ?>" alt="Default Image">
                                                <?php } ?>
                                                </div>
                                                <div class="courses_content">
                                                    <h4>
                                                        <a href="<?php echo $url; ?>"><?php echo esc_html($cat->name); ?></a>
                                                    </h4>
                                                    <p><?php echo esc_html(wp_trim_words($cat->description, 17)); ?></p>

                                                    <div class="courses_footer">
                                                        <div class="courses_price">
                                                            <?php
                                                                $taxonomy_category = get_term($cat->parent, $cat->taxonomy);
                                                            ?>
                                                            <span class="locations_tags"><?php echo esc_html($taxonomy_category->name); ?></span>
                                                        </div>
                                                        <div class="courses_btns">
                                                            <a href="<?php echo $url; ?>" class="button_main">Read More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                    }
                                }
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php
        $article_heading = get_custom_field_value('article_heading') ?: 'Empty heading';
        $article_desc = nl2br(get_custom_field_value('article_desc')) ?: 'Empty description';
        $article_button_text =get_custom_field_value('article_button_text') ?: 'Empty text';
        $article_button_url = get_custom_field_value('article_button_url') ?: '#';
    ?>
    <section class="section_bg blog_section last_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <?php echo '<h2>'.$article_heading .'<h2>'; ?>
                        <?php echo '<p>'. $article_desc .'</p>'; ?></p>
                    </div>
                </div>
                    <?php
                    $default_img = get_template_directory_uri() .'/images/default_image/no_Image_banner.png';
                    // Query the latest posts
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 5,
                    );
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        $count = 0; // Initialize counter
                        
                        while ($query->have_posts()) : $query->the_post();
                            $post_title = get_the_title();
                            $post_excerpt = get_the_excerpt();
                            $post_permalink = get_the_permalink();
                            $post_img = get_the_post_thumbnail_url( get_the_ID(), 'article-thumb') ?: $default_img;
                            $post_date = get_the_date('M j Y');
                            $post_author = get_the_author();
                            $post_tag = get_field('article_top_tag', get_the_ID());

                            if ($count == 0) :
                    ?>
                        <div class="col-md-12 col-lg-6">
                            <div class="card_box blog_card">
                                <?php if($post_tag) {
                                    echo '<div class="blog_tags">'.$post_tag.'</div>';
                                    } ?>
                                <div class="blog_imgs"> 
                                    <img src="<?php echo $post_img; ?>" alt="<?php echo $post_title; ?>" title="<?php echo $post_title; ?>">
                                </div>
                                <div class="blog_content">
                                    <div class="blog_tags_list">
                                        <ul>
                                            <li> <span class="fa-solid fa-calendar-days"></span> <?php echo $post_date; ?> </li>
                                            <li> <span class="tags_blog_border"></span> </li>
                                            <li> <span class="fa-solid fa-user"></span> By <?php echo $post_author; ?> </li>
                                        </ul>
                                    </div>
                                    <h4>
                                        <a href="<?php echo $post_permalink; ?>"><?php echo $post_title; ?></a>
                                    </h4>
                                    <p><?php echo wp_trim_words($post_excerpt, 20, '...'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                        elseif ($count <= 4) :
                            if ($count == 1) echo '<div class="col-md-12 col-lg-6"><div class="row">'; // Start of the next posts container
                    ?>
                        <div class="col-md-6">
                            <div class="card_box blog_card blog_margin">
                                
                                <?php if($post_tag) {
                                    echo '<div class="blog_tags">'.$post_tag.'</div>';
                                    } ?>
                                <div class="blog_imgs"> 
                                    <img src="<?php echo $post_img; ?>" alt="<?php echo $post_title; ?>" title="<?php echo $post_title; ?>">
                                </div>
                                <div class="blog_content">
                                    <div class="blog_tags_list">
                                        <ul>
                                            <li> <span class="fa-solid fa-calendar-days"></span> <?php echo $post_date; ?> </li>
                                            <li> <span class="tags_blog_border"></span> </li>
                                            <li> <span class="fa-solid fa-user"></span> By <?php echo $post_author; ?> </li>
                                        </ul>
                                    </div>
                                    <h6>
                                        <a href="<?php echo $post_permalink; ?>"><?php echo wp_trim_words($post_title, 5, '...'); ?></a>
                                    </h6>
                                    <p><?php echo wp_trim_words($post_excerpt, 4, '...'); ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                                if ($count == 4) echo '</div></div>'; // End of the next posts container
                            endif;
                            $count++;
                        endwhile;

                        wp_reset_postdata();
                    else :
                        echo '<p>No articles found.</p>';
                    endif;
                ?>
                <div class="col-md-12">
                    <div class="blogbtns">
                        <a href="<?php echo $article_button_url; ?>" class="button_main"><?php echo $article_button_text; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>