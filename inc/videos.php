<?php 

// Register Custom Post Type
function alquwa_video() {

	$labels = array(
		'name'                => 'الفيديوهات',
		'singular_name'       => 'فيديو',
		'menu_name'           => 'الفيديوهات',
		'parent_item_colon'   => '',
		'all_items'           => 'كافة الفيديوهات',
		'view_item'           => NULL,
		'add_new_item'        => 'أضف فيديو جديد',
		'add_new'             => 'أضف جديد',
		'edit_item'           => 'تحرير فيديو',
		'update_item'         => 'تحديث فيديو',
		'search_items'        => 'بحث في الفيديوهات',
		'not_found'           => 'لا يوجد فيديوهات.',
		'not_found_in_trash'  => 'لا يوجد فيديوهات في سلة المهملات.',
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title' ),
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
	register_post_type( 'video', $args );

}

add_action( 'init', 'alquwa_video', 0 );




/**************************************************************************************************************/

function video_add_custom_box() {

        add_meta_box(
            'urldiv',
            'الرابط',
            'video_inner_custom_box',
            'video'
        );
}
add_action( 'add_meta_boxes', 'video_add_custom_box' );


function video_inner_custom_box( $post ) {

  wp_nonce_field( 'video_inner_custom_box', 'video_inner_custom_box_nonce' );



  $url = get_post_meta( $post->ID, 'url', true );



?>


<table class="form-table" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="direction:ltr; text-align:left;">https://www.youtube.com/watch?v= <input name="url" type="text" value="<?php echo esc_attr( $url ) ?>" /></td>
  </tr>

</table>




<?php

}


function alquwa_save_video_postdata( $post_id ) {


  if ( ! isset( $_POST['video_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['video_inner_custom_box_nonce'];

  if ( ! wp_verify_nonce( $nonce, 'video_inner_custom_box' ) )
      return $post_id;

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  if ( 'video' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }


  $url = sanitize_text_field( $_POST['url'] );


  update_post_meta( $post_id, 'url', $url );






}
add_action( 'save_post', 'alquwa_save_video_postdata' );




/**************************************************************************************************************/

// Customizing the messages: 


//add filter to ensure the text News, or News, is displayed when user updates a News

function video_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['video'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf('تم تحديث الفيديو. <a href="%s">مشاهدة الفيديو</a>', esc_url( get_permalink($post_ID) ) ),
    4 => 'تم تحديث الفيديو',
    /* translators: %s: date and time of the revision */
    6 => sprintf( 'تم نشر الفيديو. <a href="%s">مشاهدة الفيديو</a>', esc_url( get_permalink($post_ID) ) ),
    7 => 'تم حفظ الفيديو.',
    9 => sprintf('الفيديو مجدول ليوم: <strong>%1$s</strong>. <a target="_blank" href="%2$s">معاينة الفيديو</a>',
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( 'تم تحديث مسودة الفيديو. <a target="_blank" href="%s">معاينة الفيديو</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_filter( 'post_updated_messages', 'video_updated_messages' );





add_filter( 'manage_edit-video_columns', 'set_custom_edit_video_columns' );
add_action( 'manage_video_posts_custom_column' , 'custom_video_column', 10, 2 );

function set_custom_edit_video_columns($columns) {
    $columns['featured'] = __( 'Featured Image' );
    $columns['order'] = __( 'Order' );

    return $columns;
}

function custom_video_column( $column, $post_id ) {
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

/*********************************************************************************************************************************/



add_action('video_category_add_form_fields' , 'video_category_form_custom_field_add' , 10);
add_action( 'video_category_edit_form_fields', 'video_category_form_custom_field_edit', 10, 2 );

function video_category_form_custom_field_add(){
	
 wp_enqueue_media();	
?>

 <script type="text/javascript">
    
    jQuery(document).ready(function($){
  var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  $('.uploader .button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url);
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });

  $('.add_media').on('click', function(){
    _custom_media = false;
  });
});
    
    
    
    </script>


<div>
<label><?php _e('Image'); ?></label>
    <div class="uploader">
     <div class="form-field"> 
  <input type="text"  name="video_category_image" id="_unique_name" value="" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="إضافة صورة" />
</div>
</div>
<?php	
	
	}




function video_category_form_custom_field_edit( $tag, $taxonomy ) {

 wp_enqueue_media();


	$option_name = 'video_category_image_' . $tag->term_id;
	$video_category_image = get_option( $option_name );


	

?>

 <script type="text/javascript">
    
    jQuery(document).ready(function($){
  var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  $('.uploader .button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url);
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });

  $('.add_media').on('click', function(){
    _custom_media = false;
  });
});
    
    
    
    </script>

<tr class="">
  <th scope="row" valign="top"><label for="video_category_image"><?php _e('Image'); ?></label></th>
  <td>

    

  
      <div class="uploader">
     <div class="form-field"> 
  <input type="text" class="regular-text" name="video_category_image" id="_unique_name" value="<?php echo esc_attr( $video_category_image ) ? esc_attr( $video_category_image ) : ''; ?>" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="إضافة/تغيير صورة" />
</div>
    
 
    
    
  </td>
</tr>
<?php
}	
	
	
/** Save Custom Field Of Category Form */
add_action( 'created_video_category', 'video_category_form_custom_field_save', 10, 2 );	
add_action( 'edited_video_category', 'video_category_form_custom_field_save', 10, 2 );

function video_category_form_custom_field_save( $term_id, $tt_id ) {

	if ( isset( $_POST['video_category_image'] ) ) {			
		$option_name = 'video_category_image_' . $term_id;
		update_option( $option_name, $_POST['video_category_image'] );
	}
}	
	





?>