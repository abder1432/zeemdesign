<?php 

// Register Custom Post Type
function alquwa_ad() {

	$labels = array(
		'name'                => 'الاعلانات',
		'singular_name'       => 'اعلان',
		'menu_name'           => 'الاعلانات',
		'parent_item_colon'   => '',
		'all_items'           => 'كافة الاعلانات',
		'view_item'           => 'عرض الاعلان',
		'add_new_item'        => 'أضف اعلان جديد',
		'add_new'             => 'أضف جديد',
		'edit_item'           => 'تحرير اعلان',
		'update_item'         => 'تحديث اعلان',
		'search_items'        => 'بحث في الاعلانات',
		'not_found'           => 'لا يوجد اعلانات.',
		'not_found_in_trash'  => 'لا يوجد اعلانات في سلة المهملات.',
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' , 'thumbnail'  ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		// 'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post', //post
	);
	register_post_type( 'ad', $args );

}

add_action( 'init', 'alquwa_ad', 0 );



add_action( 'init', 'create_ads_taxonomies', 0 );

function create_ads_taxonomies() {
	

	

	$args = array(
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'ad_category' ),
	);

	register_taxonomy( 'ad_category', 'ad', $args );
}



// Branche details



// Customizing the messages: 


//add filter to ensure the text News, or News, is displayed when user updates a News

function ad_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['ad'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf('تم تحديث الاعلان. <a href="%s">مشاهدة الاعلان</a>', esc_url( get_permalink($post_ID) ) ),
    4 => 'تم تحديث الاعلان',
    /* translators: %s: date and time of the revision */
    6 => sprintf( 'تم نشر الاعلان. <a href="%s">مشاهدة الاعلان</a>', esc_url( get_permalink($post_ID) ) ),
    7 => 'تم حفظ الاعلان.',
    9 => sprintf('الاعلان مجدول ليوم: <strong>%1$s</strong>. <a target="_blank" href="%2$s">معاينة الاعلان</a>',
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( 'تم تحديث مسودة الاعلان. <a target="_blank" href="%s">معاينة الاعلان</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_filter( 'post_updated_messages', 'ad_updated_messages' );





add_filter( 'manage_edit-ad_columns', 'set_custom_edit_ad_columns' );
add_action( 'manage_ad_posts_custom_column' , 'custom_ad_column', 10, 2 );

function set_custom_edit_ad_columns($columns) {
    $columns['featured'] = __( 'Featured Image' );
 

    return $columns;
}

function custom_ad_column( $column, $post_id ) {
	global $post;
    switch ( $column ) {

        case 'featured' :
            if ( has_post_thumbnail() ) the_post_thumbnail('thumbnail');
        break;

    }
}




?>