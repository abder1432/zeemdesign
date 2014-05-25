<?php 

// Register Custom Post Type
function elfaleh_slider() {

	$labels = array(
		'name'                => 'السلايدر',
		'singular_name'       => 'عنصر',
		'menu_name'           => 'السلايدر',
		'parent_item_colon'   => '',
		'all_items'           => 'كافة العناصر',
		'view_item'           => 'عرض العنصر',
		'add_new_item'        => 'أضف عنصر جديد',
		'add_new'             => 'أضف جديد',
		'edit_item'           => 'تحرير عنصر',
		'update_item'         => 'تحديث عنصر',
		'search_items'        => 'بحث في العناصر',
		'not_found'           => 'لا يوجد عناصر.',
		'not_found_in_trash'  => 'لا يوجد عناصر في سلة المهملات.',
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'page-attributes', 'thumbnail'  ),
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
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post', //post
	);
	register_post_type( 'slide', $args );

}

add_action( 'init', 'elfaleh_slider', 0 );


// Branche details



function slide_add_custom_box() {

        add_meta_box(
            'urldiv',
            'الرابط',
            'slide_inner_custom_box',
            'slide'
        );
}
add_action( 'add_meta_boxes', 'slide_add_custom_box' );


function slide_inner_custom_box( $post ) {

  wp_nonce_field( 'slide_inner_custom_box', 'slide_inner_custom_box_nonce' );



  $url = get_post_meta( $post->ID, 'slide_url', true );



?>


<table class="form-table" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="form-field">
    <td><input name="url" type="text" value="<?php echo esc_attr( $url ) ?>" /></td>
  </tr>

</table>




<?php

}


function slide_save_postdata( $post_id ) {


  if ( ! isset( $_POST['slide_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['slide_inner_custom_box_nonce'];

  if ( ! wp_verify_nonce( $nonce, 'slide_inner_custom_box' ) )
      return $post_id;

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  if ( 'slide' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }


  $url = sanitize_url( $_POST['url'] );


  update_post_meta( $post_id, 'slide_url', $url );





}
add_action( 'save_post', 'slide_save_postdata' );




// Customizing the messages: 


//add filter to ensure the text News, or News, is displayed when user updates a News

function slide_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['slide'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf('تم تحديث العنصر. <a href="%s">مشاهدة العنصر</a>', esc_url( get_permalink($post_ID) ) ),
    4 => 'تم تحديث العنصر',
    /* translators: %s: date and time of the revision */
    6 => sprintf( 'تم نشر العنصر. <a href="%s">مشاهدة العنصر</a>', esc_url( get_permalink($post_ID) ) ),
    7 => 'تم حفظ العنصر.',
    9 => sprintf('العنصر مجدول ليوم: <strong>%1$s</strong>. <a target="_blank" href="%2$s">معاينة العنصر</a>',
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( 'تم تحديث مسودة العنصر. <a target="_blank" href="%s">معاينة العنصر</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_filter( 'post_updated_messages', 'slide_updated_messages' );





add_filter( 'manage_edit-slide_columns', 'set_custom_edit_slide_columns' );
add_action( 'manage_slide_posts_custom_column' , 'custom_slide_column', 10, 2 );

function set_custom_edit_slide_columns($columns) {
    $columns['featured'] = __( 'Featured Image' );
    $columns['order'] = __( 'Order' );

    return $columns;
}

function custom_slide_column( $column, $post_id ) {
	global $post;
    switch ( $column ) {

        case 'featured' :
            if ( has_post_thumbnail() ) the_post_thumbnail('thumbnail');
        break;
		
        case 'order' :
			echo $post->menu_order;
        break;		

    }
}



?>