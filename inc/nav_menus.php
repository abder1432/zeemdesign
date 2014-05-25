<?php 


function wpb_first_and_last_menu_class($items) {
    $items[1]->classes[] = 'first';
    $items[count($items)]->classes[] = 'last';
    return $items;
}
add_filter('wp_nav_menu_objects', 'wpb_first_and_last_menu_class');





function base_current_menu_item_class( $classes, $item ) {
	
	global $wp_query;
	
  if (is_post_type_archive()){	
	$post_type = $wp_query->query['post_type'];
	$query_var = get_post_type_object($post_type)->query_var;
	
	
		if (strpos( $item->url , $query_var) !== false){
    $classes[] = 'current-menu-item';
		}
	
  }
    return $classes;
	
}
add_filter('nav_menu_css_class', 'base_current_menu_item_class' , 10, 2);




?>