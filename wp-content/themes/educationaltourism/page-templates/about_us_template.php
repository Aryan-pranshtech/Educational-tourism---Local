<?php
/**
* Template Name: About Us Page
*/

get_header(); ?>

<?php
$default_img = get_template_directory_uri().'/images/default_image/no_Image_banner.png';
if(function_exists('get_custom_field_value')){
    $about_main_heading = get_custom_field_value('about_main_heading') ?: 'Empty heading';
    $about_main_desc = nl2br(get_custom_field_value('about_main_desc')) ?: 'Empty description';
    $about_us_video_link = get_custom_field_value('about_us_video_link') ?: '';

    $about_main_img = get_custom_field_value('about_main_img') ?: $default_img;
    $about_main_left_img = get_custom_field_value('about_main_left_img') ?: $default_img;
    $about_main_right_img = get_custom_field_value('about_main_right_img') ?: $default_img;

    $about_mission_heading = get_custom_field_value('about_mission_heading') ?: 'Empty heading';
    $about_mission_desc = nl2br(get_custom_field_value('about_mission_desc')) ?: 'Empty description';
    $about_mission_slider = get_custom_field_value('about_mission_slider');

    if (!empty($about_mission_slider)) {
        $image_urls = explode(',', $about_mission_slider);
        
        if (count($image_urls) === 1) {
            $image_urls = array($image_urls[0]);
        }
    } else {
        $image_urls = array($default_img);
    }

    /* Post Types Heading */
    $discovery_gallerys_heading = get_custom_field_value('discovery_gallerys_heading') ?: 'Empty heading';

    $our_features_heading = get_custom_field_value('our_features_heading') ?: 'Empty heading';
    $our_features_desc = nl2br(get_custom_field_value('our_features_desc')) ?: 'Empty description';

    $our_teams_heading = get_custom_field_value('our_teams_heading') ?: 'Empty heading';
    $our_teams_desc = nl2br(get_custom_field_value('our_teams_desc')) ?: 'Empty description';
    $our_teams_btn_text = get_custom_field_value('our_teams_btn_text') ?: 'Empty text';
    $our_teams_btn_url = get_custom_field_value('our_teams_btn_url') ?: '#';

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

    <section class="about_wrapp">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="about_imgs_wrapp">
                        <div class="about_imgs_shap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-shape.png" alt="about-shape">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="about_imgs_box">
                                    <img src="<?php echo $about_main_img; ?>" alt="about imgs">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about_imgs_box">
                                    <img src="<?php echo $about_main_left_img; ?>" alt="about imgs">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about_imgs_box">
                                    <img src="<?php echo $about_main_right_img; ?>" alt="about imgs">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about_right_content">
                        <div class="main_heading">
                            <h2><?php echo $about_main_heading; ?></h2>
                            <p><?php echo nl2br($about_main_desc); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section_bg about_section_video">
        <div class="about_video1">
            <iframe width="100%" height="100%" src="<?php echo $about_us_video_link; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="main_heading">
                        <h2><?php echo $about_mission_heading; ?></h2>
                        <p><?php echo $about_mission_desc; ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about_slider">
                        <div class="aboutSlider owl-carousel owl-theme">
                        <?php
                            $slider = 0;
                            foreach ($image_urls as $image_url) {
                                echo '
                            <div class="item">
                                <img src="'.$image_url.'" alt="about imgs">
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
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

    <section class="feature_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2><?php echo $our_features_heading; ?></h2>
                        <p><?php echo $our_features_desc; ?></p>
                    </div>
                </div>

                <?php
                    $args = array(
                        'post_type' => 'our_features',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'order' => 'ASC'
                    );
                    $features_query = new WP_Query($args);
                    $features = 0;
                    
                    if ($features_query->have_posts()) :
                        while ($features_query->have_posts()) : $features_query->the_post();
                        $feature_image = get_the_post_thumbnail(get_the_ID(), 'our_features-full-width') ?? $default_img;
                        // $feature_image = get_field('feature_image');
                        $features++;
                        $order_class = $features %2 == 0 ?: 'order-md-first';
                        ?>
                        <div class="row justify-content-between align-items-center mb-5">
                            <div class="col-md-6">
                                <div class="features_content">
                                    <div class="feature_icon">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/money_savers.svg" alt="<?php the_title(); ?>">
                                    </div>
                                    <div class="features_text">
                                        <h3><?php the_title(); ?></h3>
                                        <p><?php the_content(); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 <?php echo $order_class; ?>">
                                <div class="features_img">
                                    <?php if ($feature_image) : ?>
                                        <?php /* <img src="<?php echo esc_url($feature_image); ?>" alt="<?php //the_title(); ?>"> */ ?>
                                         <?php echo $feature_image; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                ?>
            </div>
        </div>
    </section>

    <section class="section_bg last_section blog_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2><?php echo $our_teams_heading; ?></h2>
                        <p><?php echo $our_teams_desc; ?></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                    $args = array(
                        'post_type' => 'our_teams',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'order' => 'ASC'
                    );
                    $teams_query = new WP_Query($args);

                    if ($teams_query->have_posts()) :
                        while ($teams_query->have_posts()) : $teams_query->the_post();
                            $team_image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?? $default_img; 
                            $team_position = get_field('team_position') ?: 'Tour Guide'; 
                            $social_links = get_field('social_links'); //Assume custom field
                            ?>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="card_box team_card">
                                    <div class="team_box">
                                        <?php if ($team_image) : ?>
                                            <img src="<?php echo esc_url($team_image); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                        <div class="team_content">
                                            <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                                            <p><?php echo esc_html($team_position); ?></p>
                                            <div class="footer_socail">
                                                <ul>
                                                    <li>
                                                        <?php if ($social_links) : ?>
                                                            <?php foreach ($social_links as $social) : ?>
                                                                <a href="<?php echo esc_url($social['url']); ?>">
                                                                    <span class="<?php echo esc_attr($social['icon']); ?>"></span>
                                                                </a>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                ?>
                <div class="col-md-12 text-center mt-5">
                    <a href="<?php echo home_url('/').$our_teams_btn_url; ?>" class="button_main"><?php echo $our_teams_btn_text; ?></a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>