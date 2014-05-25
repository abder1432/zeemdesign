<?php 

// Register Custom Post Type
function alquwa_project() {

	$labels = array(
		'name'                => 'المشاريع',
		'singular_name'       => 'مشروع',
		'menu_name'           => 'المشاريع',
		'parent_item_colon'   => '',
		'all_items'           => 'كافة المشاريع',
		'view_item'           => 'عرض المشروع',
		'add_new_item'        => 'أضف مشروع جديد',
		'add_new'             => 'أضف جديد',
		'edit_item'           => 'تحرير مشروع',
		'update_item'         => 'تحديث مشروع',
		'search_items'        => 'بحث في المشاريع',
		'not_found'           => 'لا يوجد مشاريع.',
		'not_found_in_trash'  => 'لا يوجد مشاريع في سلة المهملات.',
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' , 'thumbnail'  ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_projectmin_bar'   => true,
		'menu_position'       => 5,
		// 'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post', //post
	);
	register_post_type( 'project', $args );

}

add_action( 'init', 'alquwa_project', 0 );






// Branche details



// Customizing the messages: 


//add filter to ensure the text News, or News, is displayed when user updates a News

function project_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['project'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf('تم تحديث المشروع. <a href="%s">مشاهدة المشروع</a>', esc_url( get_permalink($post_ID) ) ),
    4 => 'تم تحديث المشروع',
    /* translators: %s: date and time of the revision */
    6 => sprintf( 'تم نشر المشروع. <a href="%s">مشاهدة المشروع</a>', esc_url( get_permalink($post_ID) ) ),
    7 => 'تم حفظ المشروع.',
    9 => sprintf('المشروع مجدول ليوم: <strong>%1$s</strong>. <a target="_blank" href="%2$s">معاينة المشروع</a>',
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( 'تم تحديث مسودة المشروع. <a target="_blank" href="%s">معاينة المشروع</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_filter( 'post_updated_messages', 'project_updated_messages' );





add_filter( 'manage_edit-project_columns', 'set_custom_edit_project_columns' );
add_action( 'manage_project_posts_custom_column' , 'custom_project_column', 10, 2 );

function set_custom_edit_project_columns($columns) {
    $columns['featured'] = __( 'Featured Image' );
 

    return $columns;
}

function custom_project_column( $column, $post_id ) {
	global $post;
    switch ( $column ) {

        case 'featured' :
            if ( has_post_thumbnail() ) the_post_thumbnail('thumbnail');
        break;

    }
}


?>