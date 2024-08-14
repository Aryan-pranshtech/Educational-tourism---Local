<?php
/*
 * Educational  Breadcrumbs
*/
global $educational_options;
if(get_theme_mod('educational-remove-breadcrumbs',true)) {
	function educational_custom_breadcrumbs() {
	  $educational_showonhome = 0; 
	  $educational_showcurrent = 1;
	 
	  global $post;
	  
	  if (is_home() || is_front_page()) {
	    if ($educational_showonhome == 1) echo '<ol class="breadcrumb"><li class="active"><a href="' . esc_url(home_url()) . '">' . esc_html__('Home','educational') . '</a></li></ol>';
	  } else {
	    echo '<ol class="breadcrumb"><li class="active"><a href="' . esc_url(home_url()) . '">' . esc_html__('Home','educational') . '</a> ';
	    if ( is_category() ) {
	      $educational_thisCat = get_category(get_query_var('cat'), false);
	      if ($educational_thisCat->parent != 0) echo get_category_parents($educational_thisCat->parent, TRUE, ' ');
	      esc_html_e('Archive by category' , 'educational');  echo esc_html(single_cat_title('', false)) ;
	    } elseif ( is_search() ) {
	      esc_html_e('Search results for','educational'); echo esc_html(get_search_query());
	    } elseif ( is_day() ) {
	      echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
	      echo '<a href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a> ';
	      echo esc_html(get_the_time('d')) ;
	    } elseif ( is_month() ) {
	      echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
	      echo  esc_html(get_the_time('F')) ;
	    } elseif ( is_year() ) {
	      echo  esc_html(get_the_time('Y')) ;
	    } elseif ( is_single() && !is_attachment() ) {
	      if ( get_post_type() != 'post' ) {
		$educational_post_type = get_post_type_object(get_post_type());
		$educational_slug = $educational_post_type->rewrite;
		echo '<a href="' . esc_url(home_url('/' . $educational_slug['slug'] . '/')). '">' . esc_html($educational_post_type->labels->singular_name) . '</a>';
		if ($educational_showcurrent == 1) echo  esc_html(get_the_title()) ;
	      } else {
		$educational_cat = get_the_category(); $educational_cat = $educational_cat[0];
		$educational_cats = get_category_parents($educational_cat, TRUE, ' ');
		if ($educational_showcurrent == 0) $educational_cats = 
		preg_replace("#^(.+)\s\s$#", "$1",$educational_cats);
		echo $educational_cats;
		if ($educational_showcurrent == 1) echo  esc_html(get_the_title()) ;
	      }
	    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
	      $educational_post_type = get_post_type_object(get_post_type());
	      echo  $educational_post_type->labels->singular_name ;
	    } elseif ( is_attachment() ) {
	      $educational_parent = get_post($post->post_parent);
	      $educational_cat = get_the_category($educational_parent->ID); $educational_cat = $educational_cat[0];
	      echo get_category_parents($educational_cat, TRUE, ' ');
	      echo '<a href="' . esc_url(get_permalink($educational_parent)) . '">' . esc_html($educational_parent->post_title) . '</a>';
	      if ($educational_showcurrent == 1) echo esc_html(get_the_title()) ;
	    } elseif ( is_page() && !$post->post_parent ) {
	      if ($educational_showcurrent == 1) echo esc_html(get_the_title()) ;
	    } elseif ( is_page() && $post->post_parent ) {
	      $educational_parent_id  = $post->post_parent;
	      $educational_breadcrumbs = array();
	      while ($educational_parent_id) {
		$educational_page = get_page($educational_parent_id);
		$educational_breadcrumbs[] = '<a href="' . esc_url(get_permalink($educational_page->ID)) . '">' . esc_html(get_the_title($educational_page->ID)) . '</a>';
		$educational_parent_id  = $educational_page->post_parent;
	      }
	      $educational_breadcrumbs = array_reverse($educational_breadcrumbs);
	      for ($educational_i = 0; $educational_i < count($educational_breadcrumbs); $educational_i++) {
		echo $educational_breadcrumbs[$educational_i];
		if ($educational_i != count($educational_breadcrumbs)-1) echo ' ';
	      }
	      if ($educational_showcurrent == 1) echo esc_html(get_the_title()) ;
	    } elseif ( is_tag() ) {
	      echo  esc_html__('Posts tagged','educational'); echo esc_html(single_tag_title('', false)) . '"';
	    } elseif ( is_author() ) {
	       global $author;
	      $educational_userdata = get_userdata($author);
	      echo esc_html__('Articles posted by','educational'); echo esc_html($educational_userdata->display_name) ;
	    } elseif ( is_404() ) {
	      echo esc_html__('Error 404','educational'); 
	    }
	    if ( get_query_var('paged') ) {
	      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
	      echo esc_html__('Page','educational') . ' ' . esc_html(get_query_var('paged'));
	      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
	    }
	    echo '</li></ol>';
	  }
	} 
}