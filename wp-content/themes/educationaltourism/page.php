<?php 
/*
 * Main Template File.
 */
get_header();
$featured_image_url =  get_template_directory_uri() .'/images/default_image/no_Image_banner.png';
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
    <section class="last_section ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                the_content();        
                            endwhile;
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>