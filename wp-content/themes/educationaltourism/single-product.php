<?php
    get_header();
    if (has_post_thumbnail()) {
        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }else{
        $featured_image_url = '';
    }
?>


<?php if (isset($_GET['cart']) && $_GET['cart'] == 1 && !isset($_GET['acco'])) { ?>
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
        <section class="last_section single_product_cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
                                <?php
                                    do_action( 'woocommerce_single_product_summary' ); // This will include the add to cart button
                                ?>
                            </div>
                        <?php endwhile; endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php } elseif (isset($_GET['cart']) && $_GET['cart'] == 1 && isset($_GET['acco']) && $_GET['acco'] == 1) { ?> 
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
        <section class="last_section single_accommodation">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <?php
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
                            <?php
                            echo '<h3>Accommodation</h3>';
                            global $product;
                            $accommodation_list = get_post_meta($product->get_id(), 'accommodation_list', true);
                            if (!empty($accommodation_list) && is_array($accommodation_list)) {
                                $acco_args = array(
                                    'post_type'      => 'product',
                                    'posts_per_page' => 10, 
                                    'post_status'    => 'publish',
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'product_types', 
                                            'field'    => 'slug', 
                                            'terms'    => 'accommodation',
                                        ),
                                    ),
                                );

                                $acco_query = new WP_Query($acco_args);
                                echo '<div class="col-md-12">';
                                if ($acco_query->have_posts()) {
                                    while ($acco_query->have_posts()) : $acco_query->the_post();
                                        $current_product = wc_get_product(get_the_ID()); 
                                        $schools_ids = get_post_meta(get_the_ID(), 'accommodation_list', true);
                                        $remains = array_intersect($schools_ids, $accommodation_list);
                                        if (!empty($remains)) {
                                            echo '<div class="col-md-4" style="float: left; padding: 10px; text-align: center;">';
                                            echo '<b>' . get_the_title() . '</b>';
                                            if (has_post_thumbnail()) : ?>
                                                <div class="blog-img">
                                                    <?php the_post_thumbnail('article-thumb', array('alt' => get_the_title(), 'class' => 'img-responsive')); ?>
                                                </div>
                                            <?php
                                            endif;

                                            if ($current_product->is_type('variable')) {
                                                woocommerce_template_single_add_to_cart();
                                            } else {
                                                woocommerce_template_single_add_to_cart();
                                            }
                                            echo '<div class="product-price">';
                                            echo $current_product->get_price_html(); // Display the price
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    endwhile;
                                    wp_reset_postdata();
                                } else {
                                    echo 'No products found matching the criteria.';
                                }
                                echo '</div>';
                            }else{
                                echo '<a href="https://education.sweet-johnson.137-184-185-215.plesk.page/cart/">Cart page</a>';
                            }
                            ?>
                        </div>

                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                $('.variation-dropdown').change(function() {
                                    var selectedOptions = {};
                                    $('.variation-dropdown').each(function() {
                                        var attributeName = $(this).attr('name');
                                        var attributeValue = $(this).val();
                                        if (attributeValue) {
                                            selectedOptions[attributeName] = attributeValue;
                                        }
                                    });

                                    if (Object.keys(selectedOptions).length === $('.variation-dropdown').length) {
                                        $.ajax({
                                            url: wc_add_to_cart_params.ajax_url,
                                            type: 'POST',
                                            data: {
                                                action: 'woocommerce_get_variation_price',
                                                attributes: selectedOptions,
                                                product_id: <?php echo $product->get_id(); ?>
                                            },
                                            success: function(response) {
                                                $('.product-price').html(response.price_html);
                                                $('.single_add_to_cart_button').html(response.add_to_cart_button);
                                            }
                                        });
                                    }
                                });
                            });
                        </script>
                    <?php endwhile; endif; ?>

                    <?php
                    // // Add this to your functions.php
                    // function woocommerce_get_variation_price() {
                    //     $attributes = $_POST['attributes'];
                    //     $product_id = intval($_POST['product_id']);
                        
                    //     $product = wc_get_product($product_id);
                    //     $variation = wc_get_product($product->get_matching_variation($attributes));

                    //     if ($variation) {
                    //         $response = array(
                    //             'price_html' => $variation->get_price_html(),
                    //             'add_to_cart_button' => woocommerce_template_single_add_to_cart()
                    //         );
                    //         echo json_encode($response);
                    //     }
                    //     wp_die();
                    // }
                    // add_action('wp_ajax_woocommerce_get_variation_price', 'woocommerce_get_variation_price');
                    // add_action('wp_ajax_nopriv_woocommerce_get_variation_price', 'woocommerce_get_variation_price');
                    ?>


                    </div>
                </div>
            </div>
        </section>
    </main>
<?php }else { ?>
    <main class="main_wrapper">
        <section class="banner_section" style="background-image: url('<?php echo get_template_directory_uri() ?>/images/school_imgs.webp');">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="banner_title">
                            <h1><?php the_title(); ?></h1>
                            <div class="breadcrumb_box">
                                <ul class="breadcrumb_list">
                                    <li>
                                        <a href="<?php echo home_url(); ?>">Home</a>
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

        <?php if (have_posts()) :
            while (have_posts()) : the_post();
            global $product;
            if (!$product) {
                $product = wc_get_product(get_the_ID());
            }
            $attachment_ids = $product->get_gallery_image_ids();
        ?>
            <section class="courses_detail_section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-xl-7">
                            <div class="school_detail_content">
                            <?php echo '<h2>'. get_the_title() .'</h2>'; ?>
                                <?php the_content(); ?>
                                <div class="school_detail_included">
                                    <?php $course_highlights = get_post_meta($post->ID, 'course_highlights', true); ?>
                                    <?php if (is_array($course_highlights) && count($course_highlights) > 0) { ?>
                                    <h4>Course Highlights</h4>
                                        <ul class="inner_listing">
                                            <?php foreach($course_highlights as $highlights){ 
                                                $features = $highlights['titles'];
                                                echo '
                                                <li>
                                                    <h6>'.$highlights['title'].'</h6>
                                                    <ul class="includedlisting">'; 
                                                    foreach($features as $feature){
                                                        echo '<li>'.$feature.'</li>';
                                                    }
                                                    echo '</ul>
                                                </li>';
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-5">
                            <div class="slider schoolImgs">
                                <?php
                                    if ($attachment_ids && !empty($attachment_ids)) {
                                        foreach ($attachment_ids as $attachment_id) {
                                            $image_url = wp_get_attachment_url($attachment_id);
                                            $image_html = wp_get_attachment_image($attachment_id, 'full');
                                            echo '<div class="school_Imgs">';
                                            echo $image_html;
                                            echo '</div>';
                                        }
                                    } 
                                ?>
                            </div>
                            <div class="slider schoolNav">
                                <?php 
                                    if ($attachment_ids && !empty($attachment_ids)) {
                                        foreach ($attachment_ids as $attachment_id) {
                                            $image_url = wp_get_attachment_url($attachment_id);
                                            $image_html = wp_get_attachment_image($attachment_id, 'full');
                                            echo '<div><div class="school_Nav">';
                                            echo $image_html;
                                            echo '</div></div>';
                                        }
                                    } 
                                ?>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </section>

            <?php  if ($product->is_type('variable')) { ?>
                <section class="section_bg">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main_heading main_heading_center">
                                    <h2>Pricing</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <?php 
                            
                                    $available_variations = $product->get_available_variations();
                                    $new_array = [];
                                    foreach ($available_variations as $key => $item) {
                                        
                                        $attribute_name = key($item['attributes']);
                                        // echo $attribute_name; exit;
                                        $type = $item['attributes'][$attribute_name];
                                        $sub_type = $item['attributes']['attribute_sub-type'];
                                        if (!isset($new_array[$type])) {
                                            $new_array[$type] = [];
                                        }
                                        $new_array[$type][] = $sub_type;
                                    }
                                    foreach ($new_array as $key => $item) {
                                        $array_names = array_keys($new_array);
                                        ?>
                                            <div class="col-md-6 d-flex">
                                                <div class="card_box pricing_box">
                                                    <h5><?php echo $key ?></h5>
                                                    <ul class="includedlisting" style="display: none;">
                                                        <?php foreach ($item as $name) { ?>
                                                            <li><?php echo $name; ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                <?php }  ?>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center mt-5">
                                <a href="?cart=1" class="button_main">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>

            <section class="courses_bottom_content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 d-flex">
                            <div class="card_box">
                                <?php $whats_included = get_post_meta($post->ID, 'whats_included', true); ?>
                                <?php if (is_array($whats_included) && count($whats_included) > 0) { ?>
                                    <h5>What's Included</h5>
                                    <ul class="inner_listing">
                                        <?php foreach($whats_included as $includes){ 
                                            $features = $includes['titles'];
                                            echo '
                                            <li>
                                                <h6>'.$includes['title'].'</h6>
                                                <ul class="includedlisting">'; 
                                                foreach($features as $feature){
                                                    echo '<li>'.$feature.'</li>';
                                                }
                                                echo '</ul>
                                            </li>';
                                        }
                                        ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex">
                            <div class="card_box">
                                <?php $optional_addons = get_post_meta($post->ID, 'optional_addons', true); ?>
                                <?php if (is_array($optional_addons) && count($optional_addons) > 0) { ?>
                                    <h5>Optional Add-ons</h5>
                                <ul class="inner_listing">
                                    <?php foreach($optional_addons as $addons){ 
                                        $features = $addons['titles'];
                                        echo '
                                        <li>
                                            <h6>'.$addons['title'].'</h6>
                                            <ul class="includedlisting">'; 
                                            foreach($features as $feature){
                                                echo '<li>'.$feature.'</li>';
                                            }
                                            echo '</ul>
                                        </li>';
                                    }
                                    ?>
                                </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php 
            endwhile;
        endif; 
        ?>
        <section class="last_section section_bg">
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
                        <div class="owl-theme owl-carousel relatedCourses">
                            <?php
                            $current_post_id = get_the_ID(); 
                            $custom_item_value = get_post_meta($current_post_id, 'custom_item', true);
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'post__not_in' => array($current_post_id),
                                'meta_query' => array(
                                    array(
                                        'key' => 'custom_item',
                                        'value' => $custom_item_value,
                                        'compare' => '='
                                    )
                                ),
                            );

                            $related_posts = new WP_Query($args);

                            if ($related_posts->have_posts()) :
                                while ($related_posts->have_posts()) : $related_posts->the_post();
                                    ?>
                                    <div class="item">
                                        <div class="card_box courses_card">
                                            <div class="courses_imgs">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title_attribute(); ?>">
                                                <?php else : ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/default-image.jpg" alt="Default Image">
                                                <?php endif; ?>
                                            </div>
                                            <div class="courses_content">
                                                <h4>
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h4>
                                                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
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
                            else: 
                                echo esc_html( '<h3> No courses found </h3>' );
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
<?php } 
    get_footer(); 
?>
