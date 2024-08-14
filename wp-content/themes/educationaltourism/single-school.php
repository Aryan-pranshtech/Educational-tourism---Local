<?php
	get_header();
    if (has_post_thumbnail()) {
        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }else{
        $featured_image_url =  get_template_directory_uri() .'/images/default_image/no_Image_banner.png';
    }
?>
<main class="main_wrapper">
    <section class="banner_section" style="background-image: url('<?php echo esc_url($featured_image_url); ?>');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner_title">
                        <h1><?php echo $post->post_title; ?></h1>
                        <div class="breadcrumb_box">
                            <ul class="breadcrumb_list">
                                <li>
                                    <a href="<?php echo home_url(); ?>">Home</a>
                                </li>
                                <li>
                                    <span></span>
                                </li>
                                <li><?php echo $post->post_title; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php 
    $title1 = get_field( 'section_1_title');
    $description1 = get_field( 'section_1_description');
    if(isset($title1) && !empty($title1) || isset($description1) && !empty($description1)){
    ?>
        <section class="school_detail_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_heading">
                            <?php echo '<h2>'. $title1 .'</h2>'; ?>
                            <?php echo '<p>'. nl2br($description1). '</p>' ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>


    <section class="school_courses section_bg">
        <div class="container">
            <?php 
                $title2 = get_field( 'section_2_title');
                $description2 = get_field( 'section_2_description');
                if(isset($title2) && !empty($title2) || isset($description2) && !empty($description2)){
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_heading main_heading_center">
                            <?php echo '<h2>'. $title2 .'</h2>'; ?>
                            <?php echo '<p>'. nl2br($description2). '</p>' ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-md-12">
                <div class="courses_main">
                    <div class="row">
                    <?php
							global $post;
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Get the current page number
							$custom_item_id = $post->ID;

							if ($custom_item_id) {
								$args = array(
									'post_type' => 'product',
									'posts_per_page' => 8, // Number of posts per page
									'paged' => $paged,
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'product_types', 
                                            'field'    => 'slug', 
                                            'terms'    => 'course',
                                        ),
                                    ),
									'meta_query' => array(
										array(
											'key' => 'custom_item',
											'value' => $custom_item_id,
											'compare' => '='
										)
									)
								);
								$related_products = new WP_Query($args);

								if ($related_products->have_posts()) {
									while ($related_products->have_posts()) : $related_products->the_post();
                                    ?>
                                     <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3 d-flex">
                                        <div class="card_box courses_card courses_card_box">
                                            <div class="courses_imgs">
                                                <?php if ( has_post_thumbnail() ) { ?>
                                                    <?php the_post_thumbnail( 'full', array( 'alt' => get_the_title(), 'class' => 'img-responsive') ); ?>
                                                <?php }else{ ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/default_image/no_Image.png" alt="<?php the_title(); ?>">
                                                <?php } ?>
                                            </div>
                                            <div class="courses_content">
                                                <h4>
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h4>
                                                <p><?php echo get_custom_excerpt(120); ?></p>

                                                <div class="courses_footer">
                                                    <div class="courses_btns">
                                                        <a href="<?php the_permalink(); ?>" class="button_main">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?php
									endwhile;
									wp_reset_postdata();
								} else {
									echo '<h3 class="text-center">No related course found.</h3>';
								}
							}
							?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="about_wrapp">
        <div class="container">
            <?php 
                $title3 = get_field( 'section_3_title');
                $description3 = get_field( 'section_3_description');
                if(isset($title3) && !empty($title3) || isset($description3) && !empty($description3)){
            ?>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="about_imgs_wrapp">
                            <div class="about_imgs_shap">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/about-shape.png" alt="about-shape">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="about_imgs_box">
                                        <?php
                                            if(get_field( 'section_3_image')){
                                                $img_url = get_field('section_3_image')['url'];
                                            }else{
                                                $img_url = get_template_directory_uri() .'/images/default_image/no_Image_banner.png';
                                            }
                                        ?>
                                        <img src="<?php echo $img_url; ?>" alt="<?php echo $title3; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about_right_content">
                            <div class="main_heading">
                                <?php echo '<h2>'. $title3 .'</h2>'; ?>
                                <?php echo '<p>'. nl2br($description3). '</p>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php 
                $title4 = get_field( 'section_4_title');
                $section_4_mission = get_field( 'section_4_mission');
                $section_4_vision = get_field( 'section_4_vision');
                $section_4_values = get_field( 'section_4_values');
                $section_4_location = get_field( 'section_4_location');
                if(!empty($title4) || !empty($section_4_mission) || !empty($section_4_vision) || !empty($section_4_values) || !empty($section_4_location) ){
            ?>
                <div class="about_bottom_content">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 d-flex">
                            <div class="card_box">
                                <?php echo '<h5>'. $title4 .'</h5>'; ?>
                                <ul class="inner_listing">
                                    <?php
                                        $features = get_post_meta(get_the_ID(), '_school_features', true);
                                        if (!empty($features)) {
                                            foreach ($features as $feature) {
                                            echo '
                                                <li>
                                                    <h6>' . esc_html($feature['title']) . '</h6>
                                                    <p>' . esc_html($feature['description']) . '</p>
                                                </li>';
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex">
                            <div class="card_box">
                                <div class="about_bottom_text">
                                    <?php 
                                        if(get_field( 'section_4_mission')){
                                            echo '<h6>Mission:</h6>';
                                            echo '<p>'. nl2br(get_field( 'section_4_mission')). '</p>' ;
                                        }
                                        if(get_field( 'section_4_vision')){
                                            echo '<h6>Vision:</h6>';
                                            echo '<p>'. nl2br(get_field( 'section_4_vision')). '</p>' ;
                                        }
                                        if(get_field( 'section_4_values')){
                                            echo '<h6>Values:</h6>';
                                            echo '<p>'. nl2br(get_field( 'section_4_values')). '</p>' ;
                                        }
                                        if(get_field( 'section_4_location')){
                                            echo '<h6>Location:</h6>';
                                            echo '<p>'. nl2br(get_field( 'section_4_location')). '</p>' ;
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php 
                $title5 = get_field( 'section_5_title');
                $description5 = get_field( 'section_5_description');
                if(isset($title5) && !empty($title5) || isset($description5) && !empty($description5)){
            ?>
            <div class="accommodation_main">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_heading main_heading_center">
                            <?php echo '<h2>'. $title5 .'</h2>'; ?>
                            <?php echo '<p>'. nl2br($description5). '</p>' ?>
                        </div>
                    </div>
                </div>
                
                <div class="courses_main">
                    <div class="row">
                        <?php                 
                        $term_ids = get_field('accommodation_name'); // Replace with your term IDs
                        $taxonomy = 'accommodation_taxonomy'; // Replace with your custom taxonomy
                        function get_taxonomy_term_name_by_id($term_id, $taxonomy) {
                            $term = get_term($term_id, $taxonomy);
                            $image = get_field('image', $taxonomy . '_' . $term->term_id);
                            $breakfast_dinner = get_field('breakfast_dinner', $taxonomy . '_' . $term->term_id);
                            $internet_access = get_field('internet_access', $taxonomy . '_' . $term->term_id);
                            $study_space = get_field('study_space', $taxonomy . '_' . $term->term_id);
                            if (!is_wp_error($term)) {
                                $term_data = array(
                                    'ID' => $term->term_id,
                                    'Name' => $term->name,
                                    'Slug' => $term->slug,
                                    'Taxonomy' => $term->taxonomy,
                                    'Description' => $term->description,
                                    'Parent' => $term->parent,
                                    'Count' => $term->count,
                                    'Term Group' => $term->term_group,
                                    'Term Taxonomy ID' => $term->term_taxonomy_id,
                                    'Meta' => get_term_meta($term->term_id),
                                    'img' =>$image['url'],
                                    'breakfast_dinner' => $breakfast_dinner,
                                    'internet_access' => $internet_access,
                                    'study_space' => $study_space,
                                );
                                return $term_data;
                            } else {
                                return 'Error retrieving term.';
                            }
                        }
    
                        foreach ($term_ids as $term_id) {
                            $term_name = get_taxonomy_term_name_by_id($term_id, $taxonomy);
                        ?>
                            <div class="col-md-6 col-lg-4 d-flex">
                                <div class="card_box courses_card">
                                    <div class="courses_imgs">
                                    <?php
                                        if(isset($term_name['img'])){
                                            $display_url = $term_name['img'];
                                        }else{
                                            $display_url = get_template_directory_uri() .'/images/default_image/no_Image_banner.png';
                                        }
                                    ?>
                                        <img src="<?php echo $display_url ?>" alt="<?php echo $term_name['Name']; ?>">
                                    </div>
                                    <div class="courses_content accommodation_content">
                                        <h4><?php echo $term_name['Name']; ?></h4>
                                        <p><?php echo $term_name['Description']; ?></p>
                                        <div class="accommodation_text">
                                            <ul class="accommodation_list">
                                                <?php if(isset($term_name['breakfast_dinner'])) { ?>
                                                    <li>
                                                        <span><img width="30px" src="<?php echo get_template_directory_uri(); ?>/images/breakfast.png" alt="breakfast"></span> <?php echo $term_name['breakfast_dinner']; ?>
                                                    </li>
                                                <?php } ?>
                                                <?php if(isset($term_name['internet_access'])) { ?>
                                                <li>
                                                    <span><img width="30px" src="<?php echo get_template_directory_uri(); ?>/images/internet_access.png" alt="breakfast"></span> <?php echo $term_name['internet_access']; ?>
                                                </li>
                                                <?php } ?>
                                                <?php if(isset($term_name['study_space'])) { ?>
                                                <li>
                                                    <span><img width="30px" src="<?php echo get_template_directory_uri(); ?>/images/study_space.png" alt="breakfast"></span> <?php echo $term_name['study_space']; ?>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="excursions_main">
                <?php 
                    $excursions_title = get_field( 'excursions_title');
                    $excursions_description = get_field( 'excursions_description');
                    if(isset($excursions_title) && !empty($excursions_title) || isset($excursions_description) && !empty($excursions_description)){
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_heading main_heading_center">
                            <?php echo '<h2>'. $excursions_title .'</h2>'; ?>
                            <?php echo '<p>'. nl2br($excursions_description). '</p>' ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php
                    $term_ids = get_field('excursions_list');
                    if(!empty($term_ids)){
                    $post_ids = array();
                    foreach ($term_ids as $term_id) {
                        $post_ids[] = $term_id->ID;
                    }
                    $args = array(
                        'post_type' => 'excursions',
                        'posts_per_page' => 4,
                        'post__in' => $post_ids,
                    );
                    $excursions_query = new WP_Query($args);
                    $excursions = 0;

                    if ($excursions_query->have_posts()) :
                        while ($excursions_query->have_posts()) : $excursions_query->the_post(); 
                        $excursions++;
                        $order_class = $excursions%2 == 0 ?: 'order-lg-first';
                ?>
                    <div class="school_card_main">                    
                        <div class="row">
                            <div class="col-lg-7 col-xl-7">
                                <div class="school_card excursions_content">
                                    <h4><?php the_title(); ?></h4>
                                    <ul class="inner_listing">
                                    <?php
                                            $_excursions_features = get_post_meta(get_the_ID(), '_excursions_features', true);
                                            if (!empty($_excursions_features)) {
                                                foreach ($_excursions_features as $feature) {
                                                echo '
                                                <li>'.$feature['description'].'</li>';
                                                }
                                            } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 col-xl-5 <?php echo $order_class; ?>">
                                <div class="school_imgs">
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Excursions imgs">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p><?php _e('No excursions found'); ?></p>
                <?php endif; ?>
                <?php } ?>
            </div>

            <div class="excursions_main">
                <?php 
                    $activities_title = get_field( 'activities_title');
                    $activities_description = get_field( 'activities_description');
                    if(!empty($activities_description) || !empty($activities_title)){ 
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main_heading main_heading_center">
                                <?php echo '<h2>'. $activities_title .'</h2>'; ?>
                                <?php echo '<p>'. nl2br($activities_description). '</p>' ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php 
                    // if($has_activities){
                ?>
                <div class="school_card_main">                    
                    <div class="row">
                        <div class="col-lg-7 col-xl-7 order-lg-0">
                            <div class="school_card excursions_content">
                                <h4>Activities</h4>
                                <ul class="inner_listing">
                                    <?php
                                        for ($i = 0; $i < 10; $i++) {
                                            $activities_title = get_field( 'activities_title_'.$i);
                                            if ($activities_title && isset($activities_title)) {
                                                // echo $has_activities = true;
                                                echo '<li>' . $activities_title . '</li>';
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-5 order-lg-first">
                            <div class="school_imgs">
                                <?php
                                    if(get_field( 'activities_image')){
                                        $img_url = get_field('activities_image')['url'];
                                    }else{
                                        $img_url = get_template_directory_uri() .'/images/default_image/no_Image_banner.png';
                                    }
                                ?>
                                <img src="<?php echo $img_url; ?>" alt="Activities">
                            </div>
                        </div>
                    </div>
                </div>
                <?php  // } ?>
            </div>
            
        </div>
    </section>

    <section class="last_section section_bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2>Related Schools</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-theme owl-carousel relatedschool">
                        <?php
                        $terms = get_the_terms($post->ID, 'language_locations');
                        $sub_term_slugs = array();
                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                if ($term->parent != 0) {
                                    $sub_term_slugs[] = $term->slug;
                                }
                            }
                        }
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args = array(
                            'post_type' => 'school', // Replace 'post' with your custom post type if needed
                            'posts_per_page' => 8, // Number of posts per page
                            'paged' => $paged,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'language_locations',
                                    'field'    => 'slug',
                                    'terms'    => $sub_term_slugs, // Use the slugs from above
                                ),
                            ),
                        );
                        $query = new WP_Query($args);
                            if ($query->have_posts()) {
                                while ($query->have_posts()) : $query->the_post();
                                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Get the featured image URL
                        ?>
                            <div class="item">
                                <div class="card_box courses_card">
                                    <div class="courses_imgs">
                                        <?php if ($featured_img_url): ?>
                                            <img src="<?php echo esc_url($featured_img_url); ?>" alt="<?php the_title(); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/default_image/no_Image_banner.png" alt="<?php the_title(); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="courses_content">
                                        <h4>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <p><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
            
                                        <div class="courses_footer">
                                            <div class="courses_btns">
                                                <a href="<?php the_permalink(); ?>" class="button_main">Read more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                                endwhile;
                                wp_reset_postdata();
                            } else {
                            // echo '<p>No products found.</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
