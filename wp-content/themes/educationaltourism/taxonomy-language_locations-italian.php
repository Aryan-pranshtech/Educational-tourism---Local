<?php
get_header(); 
$taxonomy = get_queried_object();
$image_url = get_term_meta($taxonomy->term_id, 'taxonomy_image', true);

$current_term = get_queried_object();
$term_id = $current_term->term_id;
$listing_and_single_image = get_field('listing_and_single_image', 'term_' . $term_id);

?>
<main class="main_wrapper">
    <section class="banner_section" style="background-image: url('<?php echo esc_url($listing_and_single_image['url']); ?>');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner_title">
                        <h1><?php echo $taxonomy->name; ?></h1>
                        <div class="breadcrumb_box">
                            <ul class="breadcrumb_list">
                                <li>
                                    <a href="<?php echo home_url(); ?>">Home</a>
                                </li>
                                <li>
                                    <span></span>
                                </li>
                                <li><?php echo $taxonomy->name; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="last_section ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading">
                        <h2>Destinations in <?php echo $taxonomy->name; ?></h2>
                        <p><?php echo nl2br($taxonomy->description); ?></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="swiper_country_wrappp">
                        <div class="swiper_country_menu">
                            <div class="swiper-wrapper">
                                <?php 
                                    $terms = get_terms(array(
                                        'taxonomy' => 'language_locations', 
                                        'hide_empty' => false,
                                        'parent' => 0,
                                    ));
                                    $queried_object_id = get_queried_object_id();
                                    if (!empty($terms) && !is_wp_error($terms)) {
                                        foreach ($terms as $term) {
                                            $image_url = get_term_meta($term->term_id, 'taxonomy_image', true);
                                            $active_class = ($term->term_id == $queried_object_id) ? ' country_menu_active' : '';
                                            if ($image_url) { ?>
                                                <div class="swiper-slide">
                                                    <div class="country_menu<?php echo $active_class; ?>">
                                                        <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                                            <span><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term->name); ?> imgs"></span>
                                                            <?php echo esc_html($term->name); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="courses_main">
                        <div class="row">
                        <?php
                            $parent_term = $taxonomy->slug;
                            $taxonomy = 'language_locations';
                            $parent_term = get_term_by('slug', $parent_term, $taxonomy);
                            $child_terms = get_terms(array(
                                'taxonomy' => $taxonomy,
                                'child_of' => $parent_term->term_id,
                                'hide_empty' => false,
                            ));
                            if (!empty($child_terms) && !is_wp_error($child_terms)) {
                                foreach ($child_terms as $child_name) {  
                                    $listing_and_single_image = get_field('listing_and_single_image', 'term_' . $child_name->term_id);
                                ?>
                                    <div class="col-md-6 col-lg-4 d-flex">
                                        <div class="card_box courses_card">
                                            <div class="courses_imgs">
                                                <?php if ($listing_and_single_image) { ?>
                                                    <img src="<?php echo esc_url($listing_and_single_image['url']); ?>" alt="<?php echo esc_attr($listing_and_single_image['alt']); ?>" />
                                                <?php } ?>
                                            </div>
                                            <div class="courses_content">
                                                <h4>
                                                    <a href="<?php echo get_term_link($child_name); ?>"><?php echo $child_name->name; ?></a>
                                                </h4>
                                                <p><?php echo $child_name->description; ?></p>

                                                <div class="courses_footer">
                                                    <div class="courses_price">
                                                        <span class="locations_tags"><?php echo $parent_term->name; ?></span>
                                                    </div>
                                                    <div class="courses_btns">
                                                        <a href="<?php echo get_term_link($child_name); ?>" class="button_main">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p style="text-align: center;">No data found.</p>';
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>