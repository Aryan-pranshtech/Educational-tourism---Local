<?php
get_header(); 
$taxonomy = get_queried_object();
$image_url = get_term_meta($taxonomy->term_id, 'taxonomy_image', true);

$current_term = get_queried_object();
$term_id = $current_term->term_id;
$listing_and_single_image = get_field('listing_and_single_image', 'term_' . $term_id);

?>
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
                            // $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                            $paged = isset($_GET['page']) ? $_GET['page'] : 1;
                            $terms_per_page = 6;

                            $parent_term = $taxonomy->slug;
                            $taxonomy_slug = 'language_locations';
                            $parent_term = get_term_by('slug', $parent_term, $taxonomy_slug);

                            $child_terms = get_terms(array(
                                'taxonomy' => $taxonomy_slug,
                                'child_of' => $parent_term->term_id,
                                'hide_empty' => false,
                                'number' => $terms_per_page,
                                'offset' => ($paged - 1) * $terms_per_page,        
                            ));

                            $total_terms = count(get_terms(array(
                                'taxonomy' => $taxonomy_slug,
                                'child_of' => $parent_term->term_id,
                                'hide_empty' => false,
                                'fields' => 'ids',
                            )));

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
                                            <p><?php echo wp_trim_words($child_name->description, 17); ?></p>

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

                            // Display pagination links
                            $big = 999999999;
                            $total_pages = ceil($total_terms / $terms_per_page);
                            $pagination_args = array(
                                'total' => $total_pages,
                                'current' => $paged,
                                'prev_text' => '&laquo;',
                                'next_text' => '&raquo;',
                                'type' => 'list',
                                'format' => '?page=%#%'
                            );

                            $pagination = paginate_links($pagination_args);

                            if ($pagination) {
                                echo '<div class="custom-pagination">' . $pagination . '</div>';
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