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
    <?php 
        $title = get_field('schools_title_section_1', 'term_' . $term_id);
        $description = get_field('schools_description_section_1', 'term_' . $term_id);
    if(isset($title) || isset($description)){
    ?>
        <section class="city_section">
            <div class="container">
                <div class="row">
                        <div class="col-md-12">
                            <div class="main_heading">
                                <?php 
                                    if(isset($title)){ echo '<h2>'.$title.'</h2>'; }else{}
                                    if(isset($description)){ echo '<p>'.nl2br($description).'</p>'; }else{}
                                ?>
                            </div>
                        </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php 
        $current_term = get_queried_object();
        $term_id = $current_term->term_id;
        $title = get_field('schools_title_section_2', 'term_' . $term_id);
        $description = get_field('schools_description_section_2', 'term_' . $term_id);
        if(isset($title) && !empty($title) || isset($description) && !empty($description)){
    ?>
    
        <section class="about_wrapp">
            <div class="container">
                <?php 
                    $top_image1 = get_field('top_image_1', 'term_' . $term_id);
                    $sub_image2 = get_field('sub_image_2', 'term_' . $term_id);
                    $sub_image3 = get_field('sub_image_3', 'term_' . $term_id);
                ?>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="about_imgs_wrapp">
                            <div class="about_imgs_shap">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/about-shape.png" alt="about-shape">
                            </div>
                            <div class="row">
                                <?php if( !empty( $top_image1 ) ): ?>
                                    <div class="col-md-12">
                                        <div class="about_imgs_box">
                                            <img src="<?php echo esc_url($top_image1['url']); ?>" alt="<?php echo esc_attr($top_image1['alt']); ?>" />
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if( !empty( $sub_image2 ) ): ?>
                                    <div class="col-md-6">
                                        <div class="about_imgs_box">
                                            <img src="<?php echo esc_url($sub_image2['url']); ?>" alt="<?php echo esc_attr($sub_image2['alt']); ?>" />
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if( !empty( $sub_image3 ) ): ?>
                                    <div class="col-md-6">
                                        <div class="about_imgs_box">
                                            <img src="<?php echo esc_url($sub_image3['url']); ?>" alt="<?php echo esc_attr($sub_image3['alt']); ?>" />
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about_right_content">
                                <div class="main_heading">
                                    <?php 
                                        if(isset($title)){ echo '<h2>'.$title.'</h2>'; }else{}
                                        if(isset($description)){ echo '<p>'.nl2br($description).'</p>'; }else{}
                                    ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>



                    <?php
                    $paged = isset($_GET['page']) ? $_GET['page'] : 1;
                    $no = 3;
                    $args = array(
                        'post_type' => 'school', 
                        'posts_per_page' => 3, 
                        'paged' => $paged,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy->taxonomy,
                                'field'    => 'slug',
                                'terms'    =>  $taxonomy->slug, 
                            ),
                        ),
                    );
                    $query = new WP_Query($args);
                        if ($query->have_posts()) { ?>
                        <section class="last_section section_bg school_section_wrapp">
                            <div class="container">

                                <?php 
                                    $current_term = get_queried_object();
                                    $term_id = $current_term->term_id;
                                    $title = get_field('language_schools_title', 'term_' . $term_id);
                                    $description = get_field('language_schools_description', 'term_' . $term_id);
                                    if(isset($title) && !empty($title) || isset($description) && !empty($description)){
                                ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="main_heading">
                                                    <?php 
                                                        if(isset($title)){ echo '<h2>'.$title.'</h2>'; }else{}
                                                        if(isset($description)){ echo '<p>'.nl2br($description).'</p>'; }else{}
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                <?php } ?>
        
                                <div class="row">
                            <?php
                            $counter = 0;
                            while ($query->have_posts()) : $query->the_post();
                                $counter++;
                                $is_even = $counter % 2 === 0;
                                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                ?>
                                <div class="school_card_main <?php echo $is_even ? 'even' : 'odd'; ?>">
                                    <div class="row justify-content-between align-items-center">
                                        <?php if ($is_even) : ?>
                                            <div class="col-lg-5 col-xl-5">
                                                <div class="school_imgs">
                                                    <?php if ($featured_img_url): ?>
                                                        <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php the_title(); ?>">
                                                    <?php else: ?>
                                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default_image/no_Image_banner.png" alt="<?php the_title(); ?>">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-xl-7">
                                                <div class="school_card school_card_left">
                                                    <h3>
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h3>
                                                    <p><?php echo get_the_excerpt(); ?></p>
                                                    <a href="<?php the_permalink(); ?>" class="button_main">Read more</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-lg-7 col-xl-7">
                                                <div class="school_card school_card_left">
                                                    <h3>
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h3>
                                                    <p><?php echo get_the_excerpt(); ?></p>
                                                    <a href="<?php the_permalink(); ?>" class="button_main">Read more</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-xl-5">
                                                <div class="school_imgs">
                                                    <?php if ($featured_img_url): ?>
                                                        <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php the_title(); ?>">
                                                    <?php else: ?>
                                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default_image/no_Image_banner.png" alt="<?php the_title(); ?>">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            // Pagination
                            $pagination = paginate_links(array(
                                'total' => $query->max_num_pages,
                                'current' => $paged,
                                'format' => '?page=%#%',
                                'prev_text' => '<span class="pagination_icon fa-solid fa-arrow-left-long"></span>',
                                'next_text' => '<span class="pagination_icon fa-solid fa-arrow-right-long"></span>',
                                'type' => 'array',
                            ));

                            if ($pagination) {
                                echo '<div class="pagination_wrapp">';
                                echo '<div class="pagination_content">Showing '.(($paged - 1) * $no + 1) . ' - ' . min($paged * $no, $query->found_posts) . ' of ' . $query->found_posts . ' results</div>';
                                echo '<div class="pagination_menu"><ul class="pagination_list">';
                                
                                foreach ($pagination as $page_link) {
                                    if (strpos($page_link, 'prev') !== false) {
                                        echo '<li class="pagination_button">' . $page_link . '</li>';
                                    } elseif (strpos($page_link, 'next') !== false) {
                                        echo '<li class="pagination_button">' . $page_link . '</li>';
                                    } else {
                                        $class = strpos($page_link, 'current') !== false ? 'pagination_number pagination_active' : 'pagination_number';
                                        echo '<li class="' . $class . '">' . $page_link . '</li>';
                                    }
                                }
                                
                                echo '</ul></div></div>';
                            }

                            wp_reset_postdata();
                       
                    ?>
            </div>
        </div>
    </section>
    <?php 
     } else {
        // echo '<p style="text-align: center;">No school found.</p>';
     }
     ?>

    <section class="last_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2>Related Cities</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme relatedCities">
                        <?php 
                            $cat = get_queried_object();
                            // $cats = get_terms( [
                            //     'taxonomy' => $cat->taxonomy,
                            //     'child_of' => $cat->parent,
                            // ] );
                            $cats = get_terms( [
                                'taxonomy' => $cat->taxonomy,
                                'child_of' => $cat->parent,
                                'exclude' => array($cat->term_id), 
                                'hide_empty' => false,
                            ] );
                            if ( ! empty( $cats ) ) {
                                foreach ( $cats as $cat ) {
                                    $url = esc_url( get_category_link( $cat ) );
                                    $listing_and_single_image = get_field('listing_and_single_image', 'term_' . $cat->term_id);
                                    $default_img = get_template_directory_uri().'/images/default_image/no_Image_banner.png';
                                    ?>
                                    <div class="item">
                                        <div class="card_box courses_card">
                                            <div class="courses_imgs">
                                            <?php if ($listing_and_single_image) { ?>
                                                <img src="<?php echo esc_url($listing_and_single_image['url']); ?>" alt="<?php echo esc_attr($listing_and_single_image['alt']); ?>" />
                                            <?php }else{  ?>
                                                <img src="<?php echo $default_img; ?>" alt="<?php echo esc_attr($listing_and_single_image['alt']); ?>">
                                            <?php } ?>
                                            </div>
                                            <div class="courses_content">
                                                <h4>
                                                    <a href="<?php echo $url; ?>"><?php echo $cat->name; ?></a>
                                                </h4>
                                                <?php echo esc_html(wp_trim_words($cat->description, 15)); ?>
                                                <div class="courses_footer">
                                                    <div class="courses_price">
                                                        <?php
                                                            $taxonomy_category = get_term( $cat->parent, $cat->taxonomy );
                                                        ?>
                                                        <span class="locations_tags"><?php echo $taxonomy_category->name; ?></span>
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
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>