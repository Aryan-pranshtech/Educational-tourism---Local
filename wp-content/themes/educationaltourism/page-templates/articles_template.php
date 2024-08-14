<?php
/**
* Template Name: Articles Page
*/

get_header(); ?>

<?php
$default_img = get_template_directory_uri().'/images/default_image/no_Image_banner.png';
if(function_exists('get_custom_field_value')){

    $article_heading = get_custom_field_value('article_heading') ?: 'Empty heading';
    $article_desc = nl2br(get_custom_field_value('article_desc')) ?: 'Empty description';

}
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
    <section class="banner_section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/about_banner.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner_title">
                        <h1><?php the_title(); ?></h1>
                        <div class="breadcrumb_box">
                            <ul class="breadcrumb_list">
                                <li> <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> </li>
                                <li> <span></span> </li>
                                <li><?php the_title(); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section_bg blog_section last_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_heading main_heading_center">
                        <h2><?php echo $article_heading; ?></h2>
                        <p><?php echo $article_desc; ?></p>
                    </div>
                </div>
                <?php
                    // Query the latest posts
                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 9,
                        'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
                    );
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            $post_title = get_the_title();
                            $post_excerpt = get_the_excerpt();
                            $post_permalink = get_the_permalink();
                            $post_img = get_the_post_thumbnail_url( get_the_ID(), 'article-thumb') ?: $default_img;
                            $post_date = get_the_date('M j Y');
                            $post_author = get_the_author();
                            $post_tag = get_field('article_top_tag', get_the_ID());
                    ?>
                            <div class="col-md-4">
                                <div class="card_box blog_card blog_margin">
                                    <?php if($post_tag){ ?>
                                    <div class="blog_tags"><?php echo $post_tag; ?></div>
                                    <?php } ?>
                                    <div class="blog_imgs">
                                        <img src="<?php echo $post_img; ?>">
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
                                            <a href="<?php echo $post_permalink; ?>"><?php echo wp_trim_words($post_title, 10, '...'); ?></a>
                                        </h6>
                                        <p><?php echo wp_trim_words($post_excerpt, 15, '...'); ?></p>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endwhile;
                        // Pagination
                        $pagination_args = array(
                            'total'        => $query->max_num_pages,
                            'current'      => max(1, get_query_var('paged')),
                            'prev_text'    => '&laquo;',
                            'next_text'    => '&raquo;',
                            'type'         => 'list',
                        );

                        $pagination = paginate_links($pagination_args);

                        if ($pagination) {
                            echo '<div class="custom-pagination">' . $pagination . '</div>';
                        }
                        
                        wp_reset_postdata();
                    else :
                        echo '<p>No posts found.</p>';
                    endif;
                ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
