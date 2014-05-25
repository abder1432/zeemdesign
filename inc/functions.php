<?php 


// Excerpt 


function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '...';
	} else {
		echo $excerpt;
	}
}


function get_breadcrumb(){
	
	
	$items = array();
	$sep = "\\";
	
	$items[] = '<a href="'. home_url('/') .'">الرئيسية</a>';


	
	if (is_404()){

		$items[] = $sep;		
		$items[] = 'لم يتم العثور على الصفحة';
	
		}
	
	if (is_page()){
		
		
		global $wp_query;
		$post_id = $wp_query->post->ID;
        /* Get an array of Ancestors and Parents if they exist */
	$parents = get_post_ancestors( $post_id );
	$id = ($parents) ? $parents[count($parents)-1]:false;
	
	if ($id){
     $parent = get_page( $id );
	 $items[] = $sep;		
	 $items[] = '<a href="' . get_permalink($id) .'">' . $parent->post_title . '</a>';
	}


		$items[] = $sep;		
		$items[] = single_post_title('', false);
	
		}
		
	
	if (is_post_type_archive('client')){

		$items[] = $sep;		
		$items[] = 'عملائنا';
	
		}	
		
	
	if (is_post_type_archive('ad')){

		$items[] = $sep;		
		$items[] = 'إعلاناتنا';
	
		}	
		
		
		
	
	if (is_tax('ad_category')){


		$items[] = $sep;		
		$items[] = '<a href="' . get_post_type_archive_link('ad') .'">إعلاناتنا</a>';

		$items[] = $sep;		
		$items[] = single_cat_title('', false);
	
		}		
	
	if (is_singular('ad')){
		
		global $wp_query;
		$post_id = $wp_query->post->ID;
		$terms = wp_get_post_terms( $post_id, 'ad_category');
		
		
		$items[] = $sep;		
		$items[] = '<a href="' . get_post_type_archive_link('ad') .'">إعلاناتنا</a>';
		$items[] = $sep;
		
		if ( !empty( $terms ) && !is_wp_error( $terms ) ){
		
			 foreach ( $terms as $term ) {
			  		$items[] = '<a href="' . get_term_link($term) .'">' . $term->name . '</a>';
					$items[] = $sep;
			 }
	
		 }		
      

				
		$items[] = single_post_title('', false);		
	
		}	
		
		
		
	
	if (is_post_type_archive('project')){

		$items[] = $sep;		
		$items[] = 'مشاريعنا';
	
		}								

	if (is_singular('project')){

		$items[] = $sep;		
		$items[] = '<a href="' . get_post_type_archive_link('project') .'">مشاريعنا</a>';

		$items[] = $sep;		
		$items[] = single_post_title('', false);		
	
		}
		
			
		
		
		
	
	if (is_post_type_archive('news')){

		$items[] = $sep;		
		$items[] = 'أخبارنا';
	
		}								

	if (is_singular('news')){

		$items[] = $sep;		
		$items[] = '<a href="' . get_post_type_archive_link('news') .'">أخبارنا</a>';

		$items[] = $sep;		
		$items[] = single_post_title('', false);		
	
		}
		
	
	if (is_post_type_archive('video')){

		$items[] = $sep;		
		$items[] = 'مكتبة الفيديو';
	
		}								

	if (is_singular('video')){

		$items[] = $sep;		
		$items[] = '<a href="' . get_post_type_archive_link('video') .'">مكتبة الفيديو</a>';

		$items[] = $sep;		
		$items[] = single_post_title('', false);		
	
		}		


	   echo '<div class="breadcrumb">';	
	   echo '<ul>';
	   
	foreach ($items as $item){
		
		
		echo '<li>' . $item . '</li>';
		
		
		}
	
	   echo '</ul>';
	   echo '</div>';	   	
	
	}

?>