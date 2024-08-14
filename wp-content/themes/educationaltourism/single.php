<?php 
/*
 * Main Template File.
 */
get_header();
$featured_image_url =  get_template_directory_uri() .'/images/default_image/no_Image_banner.png';
?>


<main class="main_wrapper">
    <section class="banner_section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/about_banner.jpg; ?>');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner_title">
                        <h1>Articles Details</h1>
                        <div class="breadcrumb_box">
                            <ul class="breadcrumb_list">
                                <li> <a href="<?php echo home_url(); ?>">Home</a> </li>
                                <li> <span></span> </li>
                                <li> <a href="<?php echo esc_url( home_url( '/articles' ) ); ?>">Articles</a> </li>
                                <li> <span></span> </li>
                                <li><?php echo $post->post_title; ?></li>
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
                    <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();

                        $post_title = get_the_title();
                        $post_content = get_the_content();
                        $post_img = get_the_post_thumbnail_url( get_the_ID(), 'article-thumb') ?? $default_img;
                        $post_date = get_the_date('M j Y');
                        $post_author = get_the_author();
                        $post_tag = get_field('article_top_tag', get_the_ID());


                    ?>
                    <div class="blog_left_sidebar">
                        <div class="blog_main_title">
                            <h1><?php the_title(); ?></h1>
                            <ul>
                                <li>
                                    <span class="fa-solid fa-user"></span> By <?php echo  $post_author; ?>
                                </li>
                                |
                                <li>
                                    <span class="fa-solid fa-calendar-days"></span> <?php echo $post_date; ?>
                                </li>
                            </ul>
                        </div>

                        <div class="blog_main_imgs">
                            <img src="<?php echo $post_img; ?>" alt="<?php echo $post_title; ?>" title="<?php echo $post_title; ?>">
                        </div>
                        <div class="blog_main_content">
                            <?php echo $post_content; ?>
                        </div>
                    </div> 
                    <?php
                     endwhile;
                    endif;
                ?>

                </div>
            </div>
        </div>
    </section>

    <!-- <section class="last_section section_bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2>Related Courses</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-theme owl-carousel relatedBlogs">
                        <div class="item">
                            <div class="card_box blog_card">
                                <div class="blog_tags">Free</div>
                                <div class="blog_imgs">
                                    <img src="assets/imgs/blog_imgs2.webp" alt="blog imgs">
                                </div>
                                <div class="blog_content">
                                    <div class="blog_tags_list">
                                        <ul>
                                            <li>
                                                <span class="fa-solid fa-calendar-days"></span> April 06 2024
                                            </li>
                                            <li>
                                                <span class="tags_blog_border"></span>
                                            </li>
                                            <li>
                                                <span class="fa-solid fa-user"></span> By Ali Tufan
                                            </li>
                                        </ul>
                                    </div>
                                    <h6>
                                        <a href="#">How to eat like a local in...</a>
                                    </h6>
                                    <p>We are ready to show you the best spots in town so you can start discovering an endless number of eateries...</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card_box blog_card">
                                <div class="blog_tags">Free</div>
                                <div class="blog_imgs">
                                    <img src="assets/imgs/blog_imgs3.webp" alt="blog imgs">
                                </div>
                                <div class="blog_content">
                                    <div class="blog_tags_list">
                                        <ul>
                                            <li>
                                                <span class="fa-solid fa-calendar-days"></span> April 06 2024
                                            </li>
                                            <li>
                                                <span class="tags_blog_border"></span>
                                            </li>
                                            <li>
                                                <span class="fa-solid fa-user"></span> By Ali Tufan
                                            </li>
                                        </ul>
                                    </div>
                                    <h6>
                                        <a href="#">How to eat like a local in...</a>
                                    </h6>
                                    <p>We are ready to show you the best spots in town so you can start discovering an endless number of eateries...</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card_box blog_card">
                                <div class="blog_tags">Free</div>
                                <div class="blog_imgs">
                                    <img src="assets/imgs/blog_imgs4.webp" alt="blog imgs">
                                </div>
                                <div class="blog_content">
                                    <div class="blog_tags_list">
                                        <ul>
                                            <li>
                                                <span class="fa-solid fa-calendar-days"></span> April 06 2024
                                            </li>
                                            <li>
                                                <span class="tags_blog_border"></span>
                                            </li>
                                            <li>
                                                <span class="fa-solid fa-user"></span> By Ali Tufan
                                            </li>
                                        </ul>
                                    </div>
                                    <h6>
                                        <a href="#">How to eat like a local in...</a>
                                    </h6>
                                    <p>We are ready to show you the best spots in town so you can start discovering an endless number of eateries...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
</main>




<?php get_footer(); ?>