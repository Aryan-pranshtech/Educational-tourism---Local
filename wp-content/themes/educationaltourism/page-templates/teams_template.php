<?php
/**
* Template Name: Teams Page
*/

get_header(); ?>

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

    <section class="section_bg last_section blog_section">
        <div class="container">
            <?php /*
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2><?php the_title(); ?></h2>
                        <p>With our co-creative philosophy, we work with you to customize your itinerary according to your interests and goals. <br> We are committed to providing exceptional travel experiences that leave a lasting impression.</p>
                    </div>
                </div>
            </div>
            */ ?>
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
                            $team_image = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
                            $team_position = get_field('team_position'); 
                            $facebook = get_field('facebook_url');
                            $instagram = get_field('instagram_url');
                            $twitter = get_field('twitter_url');
                            $linkedin = get_field('linkedin_url');
                            $youtube = get_field('youtube_url');
                            ?>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                <div class="card_box team_card">
                                    <div class="team_box">
                                        <?php if ($team_image) : ?>
                                            <img src="<?php echo esc_url($team_image); ?>" alt="<?php the_title_attribute(); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/default_image/no_image_team.png">
                                        <?php endif; ?>
                                        <div class="team_content">
                                            <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                                            <p><?php echo esc_html($team_position); ?></p>
                                            <div class="footer_socail">
                                                <ul>
                                                    <li>
                                                        <?php if($facebook){ ?>
                                                            <a href="<?php echo $facebook; ?>">
                                                                <span class="fa-brands fa-facebook-f"></span>
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($instagram){ ?>
                                                            <a href="<?php echo $instagram; ?>">
                                                                <span class="fa-brands fa-instagram"></span>
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($twitter){ ?>
                                                            <a href="<?php echo $twitter; ?>">
                                                                <span class="fa-brands fa-x-twitter"></span>
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($linkedin){ ?>
                                                            <a href="<?php echo $linkedin; ?>">
                                                                <span class="fa-brands fa-linkedin-in"></span>
                                                            </a>
                                                        <?php } ?>
                                                        <?php if($youtube){ ?>
                                                            <a href="<?php echo $youtube; ?>">
                                                                <span class="fa-brands fa-youtube"></span>
                                                            </a>
                                                        <?php } ?>
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
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
