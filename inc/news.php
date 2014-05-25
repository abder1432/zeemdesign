<?php 

// Register Custom Post Type
function alquwa_news() {

	$labels = array(
		'name'                => 'الاخبار',
		'singular_name'       => 'خبر',
		'menu_name'           => 'الاخبار',
		'parent_item_colon'   => '',
		'all_items'           => 'كافة الاخبار',
		'view_item'           => 'عرض الخبر',
		'add_new_item'        => 'أضف خبر جديد',
		'add_new'             => 'أضف جديد',
		'edit_item'           => 'تحرير خبر',
		'update_item'         => 'تحديث خبر',
		'search_items'        => 'بحث في الاخبار',
		'not_found'           => 'لا يوجد اخبار.',
		'not_found_in_trash'  => 'لا يوجد اخبار في سلة المهملات.',
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' , 'thumbnail'  , 'comments'  ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_newsmin_bar'   => true,
		'menu_position'       => 5,
		// 'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post', //post
	);
	register_post_type( 'news', $args );

}

add_action( 'init', 'alquwa_news', 0 );






// Branche details



// Customizing the messages: 


//add filter to ensure the text News, or News, is displayed when user updates a News

function news_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['news'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf('تم تحديث الخبر. <a href="%s">مشاهدة الخبر</a>', esc_url( get_permalink($post_ID) ) ),
    4 => 'تم تحديث الخبر',
    /* translators: %s: date and time of the revision */
    6 => sprintf( 'تم نشر الخبر. <a href="%s">مشاهدة الخبر</a>', esc_url( get_permalink($post_ID) ) ),
    7 => 'تم حفظ الخبر.',
    9 => sprintf('الخبر مجدول ليوم: <strong>%1$s</strong>. <a target="_blank" href="%2$s">معاينة الخبر</a>',
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( 'تم تحديث مسودة الخبر. <a target="_blank" href="%s">معاينة الخبر</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_filter( 'post_updated_messages', 'news_updated_messages' );





add_filter( 'manage_edit-news_columns', 'set_custom_edit_news_columns' );
add_action( 'manage_news_posts_custom_column' , 'custom_news_column', 10, 2 );

function set_custom_edit_news_columns($columns) {
    $columns['featured'] = __( 'Featured Image' );
 

    return $columns;
}

function custom_news_column( $column, $post_id ) {
	global $post;
    switch ( $column ) {

        case 'featured' :
            if ( has_post_thumbnail() ) the_post_thumbnail('thumbnail');
        break;

    }
}


?>