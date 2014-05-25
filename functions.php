<?php 


require_once('inc/custom_admin.php');
require_once('inc/head.php');
require_once('inc/nav_menus.php');
require_once('inc/functions.php');
require_once('inc/slider.php');
require_once('inc/ads.php');
require_once('inc/clients.php');
require_once('inc/projects.php');
require_once('inc/news.php');
require_once('inc/videos.php');
require_once('inc/term_image.php');

// Register Theme Features
function alquwa_theme_features()  {



	// Add theme support for Featured Images
	add_theme_support( 'post-thumbnails' );	
	add_image_size( 'slider', 940, 265, true ); //(cropped)	
	add_image_size( 'ad', 345, 115, true ); //(cropped)	

	
}

// Hook into the 'after_setup_theme' action
add_action( 'after_setup_theme', 'alquwa_theme_features' );




// Register Navigation Menus
function alquwa_navigation_menus() {

	$locations = array(
		'primary' => 'القائمة الرئيسية',
		'secondary' => 'القائمة السفلى',		
	);
	register_nav_menus( $locations );

}

// Hook into the 'init' action
add_action( 'init', 'alquwa_navigation_menus' );






// Changing the number of posts per page, by post type

function alquwa_posts_per_page( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;


    if ( is_post_type_archive( 'client' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'posts_per_page', -1 );
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
		

        return;
    }
	
	
	if ( is_tax( 'ad_category' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'posts_per_page', 9 );
		

        return;
    }
	
	
	
	if ( is_post_type_archive( 'video' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'posts_per_page', 9 );
		

        return;
    }	
	
	
	if ( is_post_type_archive( 'news' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'posts_per_page', 5 );
		

        return;
    }	
	

	
}
add_action( 'pre_get_posts', 'alquwa_posts_per_page', 1 );



?>