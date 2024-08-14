<?php
get_header(); 

$taxonomy = get_queried_object();
$image_url = get_term_meta($taxonomy->term_id, 'taxonomy_image', true);
?>


<main class="main_wrapper">
    <section class="banner_section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/about_banner.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner_title">
                        <h1>Courses Destinations</h1>
                        <div class="breadcrumb_box">
                            <ul class="breadcrumb_list">
                                <li>
                                    <a href="<?php echo home_url(); ?>">Home</a>
                                </li>
                                <li>
                                    <span></span>
                                </li>
                                <li>Destinations</li>
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
                        <h2>All Destinations</h2>
                        <p>Explore a Variety of Top Destinations to Learn Spanish in Spain</p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="swiper_country_wrappp">
                        <div class="swiper_country_menu">
                            <div class="swiper-wrapper">

                                <?php 
                                    // Get all terms for the custom taxonomy
                                    $terms = get_terms(array(
                                        'taxonomy' => 'language_locations', // Replace with your taxonomy name
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

                                <?php /*    
                                <div class="swiper-slide">
                                    <div class="country_menu country_menu_active">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/spain_flag.svg" alt="Spain flag"></span> Spain
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="country_menu">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/germany_flag.svg" alt="Germany flag"></span> Germany
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="country_menu">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/france_flag.svg" alt="France flag"></span> France
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="country_menu">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/sweden_flag.svg" alt="Sweden flag"></span> Sweden
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="country_menu">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/denmark_flag.svg" alt="Denmark flag"></span> Denmark
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="country_menu">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/mexico_flag.svg" alt="Mexico flag"></span> Mexico
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="country_menu">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/italy_flag.svg" alt="Italy flag"></span> Italy
                                        </a>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="country_menu">
                                        <a href="#">
                                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/colombia_flag.svg" alt="Colombia flag"></span> Colombia
                                        </a>
                                    </div>
                                </div>
                                */ ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="courses_wrapp">
                        <div class="sidebar">
                            <div class="filter_sidebar">
                                <div class="filter_search">
                                    <h4 class="filter_heading">Search</h4>
                                    <form action="#" method="#">
                                        <div class="form_group">
                                            <input type="text" name="search" id="search" placeholder="Search">
                                            <button class="searchbtns"><span class="fa-solid fa-magnifying-glass"></span></button>
                                        </div>
                                    </form>
                                </div>

                                <div class="filter_listing">
                                    <h4 class="filter_heading">Sort by</h4>
                                    <ul class="filter_list">
                                        <li>
                                            <div class="form_group_radio">
                                                <input type="radio" name="Radio" id="Latest" value="Latest" checked>
                                                <label for="Latest">Latest</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_radio">
                                                <input type="radio" name="Radio" id="Trending" value="Trending">
                                                <label for="Trending">Trending</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_radio">
                                                <input type="radio" name="Radio" id="Popularity" value="Popularity">
                                                <label for="Popularity">Popularity</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_radio">
                                                <input type="radio" name="Radio" id="LowtoHigh" value="LowtoHigh">
                                                <label for="LowtoHigh">Price: Low to High</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_radio">
                                                <input type="radio" name="Radio" id="HightoLow" value="HightoLow">
                                                <label for="HightoLow">Price: High to Low</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="filter_listing">
                                    <h4 class="filter_heading">Locations</h4>
                                    <ul class="filter_list filter_scroll">
                                        <?php
                                            $parent_term = $taxonomy->slug;
                                            $taxonomy = 'language_locations';
                                            $parent_term = get_term_by('slug', $parent_term, $taxonomy);
                                            $child_terms = get_terms(array(
                                                'taxonomy' => $taxonomy,
                                                'child_of' => $parent_term->term_id,
                                                'hide_empty' => false,
                                            ));
                                            foreach ($child_terms as $child_name) {  
                                                ?>
                                                <li>
                                                    <div class="form_group_checkbox">
                                                        <input type="checkbox" name="Checkbox" id="<?php echo $child_name->slug; ?>" value="<?php echo $child_name->term_taxonomy_id; ?>">
                                                        <label for="<?php echo $child_name->slug; ?>"><?php echo $child_name->name; ?></label>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                        <?php /*
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Seville" value="Seville" checked>
                                                <label for="Seville">Seville</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Granada" value="Granada">
                                                <label for="Granada">Granada</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Málaga" value="Málaga">
                                                <label for="Málaga">Málaga</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Cadiz" value="Cadiz">
                                                <label for="Cadiz">Cadiz</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Cordoba" value="Cordoba">
                                                <label for="Cordoba">Cordoba</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Marbella" value="Marbella">
                                                <label for="Marbella">Marbella</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Tarifa" value="Tarifa">
                                                <label for="Tarifa">Tarifa</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Almuñécar" value="Almuñécar">
                                                <label for="Almuñécar">Almuñécar</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Valencia" value="Valencia">
                                                <label for="Valencia">Valencia</label>
                                            </div>
                                        </li>
                                        */ ?>
                                    </ul>
                                </div>

                                <div class="filter_listing">
                                    <h4 class="filter_heading">All Course Type</h4>
                                    <ul class="filter_list filter_scroll"> 
                                        <?php 
                                            $CourseType = get_terms(array(
                                                'taxonomy' => 'course_type',
                                                'hide_empty' => false,
                                            ));
                                            if (!empty($CourseType) && !is_wp_error($CourseType)) {
                                                foreach ($CourseType as $course) {
                                                    ?>
                                                    <li>
                                                        <div class="form_group_checkbox">
                                                            <input type="checkbox" name="Checkbox" id="<?php echo esc_html($course->name); ?>">
                                                            <label for="<?php echo esc_html($course->name); ?>"><?php echo esc_html($course->name); ?></label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        <?php /*
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="StandardCourses" checked>
                                                <label for="StandardCourses">Standard Courses <span>{20}</span></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Intensive">
                                                <label for="Intensive">Intensive <span>{25}</span></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SuperIntensive">
                                                <label for="SuperIntensive">Super Intensive <span>{30}</span></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="CCSEPreparation">
                                                <label for="CCSEPreparation">CCSE Preparation</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="DELEPreparation">
                                                <label for="DELEPreparation">DELE Preparation Courses</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SIELEPreparation">
                                                <label for="SIELEPreparation">SIELE Preparation</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="PrivateLessons">
                                                <label for="PrivateLessons">Private Lessons</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Brush-upLessons">
                                                <label for="Brush-upLessons">Brush-up Lessons</label>
                                            </div>
                                        </li>
                                        */ ?>
                                    </ul>
                                </div>

                                <div class="filter_listing">
                                    <h4 class="filter_heading">Categories</h4>
                                    <ul class="filter_list filter_scroll">
                                        <?php 
                                            $age = get_terms(array(
                                                'taxonomy' => 'product_cat',
                                                'hide_empty' => false,
                                            ));
                                            if (!empty($age) && !is_wp_error($age)) {
                                                foreach ($age as $a) {
                                                    ?>
                                                    <li>
                                                        <div class="form_group_checkbox">
                                                            <input type="checkbox" name="Checkbox" id="<?php echo esc_html($a->name); ?>">
                                                            <label for="<?php echo esc_html($a->name); ?>"><?php echo esc_html($a->name); ?></label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        <?php /*
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishLanguageCulture" checked>
                                                <label for="SpanishLanguageCulture">Spanish Language & Culture</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishScubaDiving">
                                                <label for="SpanishScubaDiving">Spanish + Scuba Diving</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishWindSurf">
                                                <label for="SpanishWindSurf">Spanish + Wind Surf</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishKiteSurfing">
                                                <label for="SpanishKiteSurfing">Spanish + Kite Surfing</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishOutdoors">
                                                <label for="SpanishOutdoors">Spanish + Outdoors</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishHorseBackRidding">
                                                <label for="SpanishHorseBackRidding">Spanish + Horse Back Ridding</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishYoga">
                                                <label for="SpanishYoga">Spanish + Yoga</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishWhaleWatching">
                                                <label for="SpanishWhaleWatching">Spanish + Whale Watching</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SpanishExecutivesProfessionals">
                                                <label for="SpanishExecutivesProfessionals">Spanish for Executives and Professionals</label>
                                            </div>
                                        </li>
                                        */ ?>
                                    </ul>
                                </div>

                                <div class="filter_listing">
                                    <h4 class="filter_heading">Age</h4>
                                    <ul class="filter_list">
                                        <?php 
                                            $age = get_terms(array(
                                                'taxonomy' => 'age',
                                                'hide_empty' => false,
                                            ));
                                            if (!empty($age) && !is_wp_error($age)) {
                                                foreach ($age as $a) {
                                                    ?>
                                                    <li>
                                                        <div class="form_group_checkbox">
                                                            <input type="checkbox" name="Checkbox" id="<?php echo esc_html($a->name); ?>">
                                                            <label for="<?php echo esc_html($a->name); ?>"><?php echo esc_html($a->name); ?></label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        <?php /*
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="HighSchoolSummerCamp" checked>
                                                <label for="HighSchoolSummerCamp">High School Summer Camp</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="UniversitySummerCamp">
                                                <label for="UniversitySummerCamp">University Summer Camp</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="YoungAdultsProgram">
                                                <label for="YoungAdultsProgram">Young Adults Program</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="TeacherCourses">
                                                <label for="TeacherCourses">Teacher Courses</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="MasterClass">
                                                <label for="MasterClass">Master Class - Club 50+ Program</label>
                                            </div>
                                        </li>
                                        */ ?>
                                    </ul>
                                </div>

                                <div class="filter_listing">
                                    <h4 class="filter_heading">Duration</h4>
                                    <ul class="filter_list">
                                        <?php 
                                            $duration = get_terms(array(
                                                'taxonomy' => 'duration',
                                                'hide_empty' => false,
                                            ));
                                            if (!empty($duration) && !is_wp_error($duration)) {
                                                foreach ($duration as $dur) {
                                                    ?>
                                                    <li>
                                                        <div class="form_group_checkbox">
                                                            <input type="checkbox" name="Checkbox" id="<?php echo esc_html($dur->name); ?>">
                                                            <label for="<?php echo esc_html($dur->name); ?>"><?php echo esc_html($dur->name); ?></label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        <?php /*
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="Mini-stay" checked>
                                                <label for="Mini-stay">Week Mini-stay</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="University">
                                                <label for="University">University Gap-year</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="HighSchool">
                                                <label for="HighSchool">High School Gap-year</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_group_checkbox">
                                                <input type="checkbox" name="Checkbox" id="SummerCamps">
                                                <label for="SummerCamps">Spring & summer Camps (teens, high school & university)</label>
                                            </div>
                                        </li>
                                        */ ?>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>

                        <div class="courses_main">

                            <div class="row">

                                <?php
                                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                                $child_term_slugs = wp_list_pluck($child_terms, 'slug');
                                $args = array(
                                    'post_type' => 'school', // Replace 'post' with your custom post type if needed
                                    'posts_per_page' => 8, // Number of posts per page
                                    'paged' => $paged,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'language_locations', // Replace with your taxonomy
                                            'field'    => 'slug',
                                            'terms'    => $child_term_slugs, // Replace with the actual term slug
                                        ),
                                    ),
                                );

                                $query = new WP_Query($args);

                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) : $query->the_post(); ?>
                                            <div class="col-md-6 d-flex">
                                                <div class="card_box courses_card">
                                                    <div class="courses_imgs">
                                                        <?php
                                                            if (has_post_thumbnail()) {
                                                                the_post_thumbnail('full', array('class' => '', 'alt' => get_the_title()));
                                                            } else {
                                                                echo '<img src="https://via.placeholder.com/300x200" alt="' . get_the_title() . '" alt="'.the_title().'">';
                                                            }
                                                        ?>
                                                        <span class="courses_imgs_tags">Free</span>
                                                    </div>
                                                    <div class="courses_content">
                                                        <div class="courses_tags">
                                                            <ul>
                                                                <li>
                                                                    <span><img width="20" src="<?php echo get_template_directory_uri(); ?>/images/calender_icon.svg" alt="calender"></span> 10 hours/week
                                                                </li>
                                                                <li>|</li>
                                                                <li>
                                                                    <span><img width="20" src="<?php echo get_template_directory_uri(); ?>/images/students_group_icon.svg" alt="students"></span> 25 Student
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <h4>
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                        </h4>
                                                        <p><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>

                                                        <div class="courses_footer">
                                                            <div class="courses_price">
                                                                <h5>€15 - €25</h5>
                                                                <span class="locations_tags">Cadiz</span>
                                                            </div>
                                                            <div class="courses_btns">
                                                                <a href="<?php the_permalink(); ?>" class="button_main">Read More</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile;
                                    } else {
                                        echo '<p>No school found.</p>';
                                    }
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                         // Pagination
                                        $total_pages = $query->max_num_pages;
                                        if ($total_pages > 1) {
                                            $current_page = max(1, get_query_var('paged'));
                                            echo '<div class="courses_pagination">';
                                            echo '<div class="courses_showing">Showing ' . (($paged - 1) * 8 + 1) . ' – ' . min($paged * 8, $query->found_posts) . ' of ' . $query->found_posts . ' results</div>';
                                            echo '<div class="pagination_listng">';
                                            echo '<ul class="pagination_list">';
                                            if ($current_page > 1) {
                                                echo '<li class="pagination_item"><a href="' . get_pagenum_link($current_page - 1) . '"><span class="fa-solid fa-arrow-left-long"></span></a></li>';
                                            }
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i == $current_page) {
                                                    echo '<li class="pagination_item pagination_active">' . $i . '</li>';
                                                } else {
                                                    echo '<li class="pagination_item"><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
                                                }
                                            }
                                            if ($current_page < $total_pages) {
                                                echo '<li class="pagination_item"><a href="' . get_pagenum_link($current_page + 1) . '"><span class="fa-solid fa-arrow-right-long"></span></a></li>';
                                            }
                                            echo '</ul>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>