<?php 

// Register Custom Post Type
function alquwa_client() {

	$labels = array(
		'name'                => 'العملاء',
		'singular_name'       => 'عميل',
		'menu_name'           => 'العملاء',
		'parent_item_colon'   => '',
		'all_items'           => 'كافة العملاء',
		'view_item'           => NULL,
		'add_new_item'        => 'أضف عميل جديد',
		'add_new'             => 'أضف جديد',
		'edit_item'           => 'تحرير عميل',
		'update_item'         => 'تحديث عميل',
		'search_items'        => 'بحث في العملاء',
		'not_found'           => 'لا يوجد عميلات.',
		'not_found_in_trash'  => 'لا يوجد عميلات في سلة المهملات.',
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
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post', //post
	);
	register_post_type( 'client', $args );

}

add_action( 'init', 'alquwa_client', 0 );




/**************************************************************************************************************/

function client_add_custom_box() {

        add_meta_box(
            'urldiv',
            'الرابط',
            'client_inner_custom_box',
            'client'
        );
}
add_action( 'add_meta_boxes', 'client_add_custom_box' );


function client_inner_custom_box( $post ) {

  wp_nonce_field( 'client_inner_custom_box', 'client_inner_custom_box_nonce' );



  $url = get_post_meta( $post->ID, 'url', true );



?>


<table class="form-table" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="form-field">
    <td><input name="url" type="text" value="<?php echo esc_attr( $url ) ?>" /></td>
  </tr>

</table>




<?php

}


function alquwa_save_postdata( $post_id ) {


  if ( ! isset( $_POST['client_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['client_inner_custom_box_nonce'];

  if ( ! wp_verify_nonce( $nonce, 'client_inner_custom_box' ) )
      return $post_id;

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  if ( 'client' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }


  $url = sanitize_url( $_POST['url'] );


  update_post_meta( $post_id, 'url', $url );






}
add_action( 'save_post', 'alquwa_save_postdata' );




/**************************************************************************************************************/

// Customizing the messages: 


//add filter to ensure the text News, or News, is displayed when user updates a News

function client_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['client'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf('تم تحديث العميل. <a href="%s">مشاهدة العميل</a>', esc_url( get_permalink($post_ID) ) ),
    4 => 'تم تحديث العميل',
    /* translators: %s: date and time of the revision */
    6 => sprintf( 'تم نشر العميل. <a href="%s">مشاهدة العميل</a>', esc_url( get_permalink($post_ID) ) ),
    7 => 'تم حفظ العميل.',
    9 => sprintf('العميل مجدول ليوم: <strong>%1$s</strong>. <a target="_blank" href="%2$s">معاينة العميل</a>',
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( 'تم تحديث مسودة العميل. <a target="_blank" href="%s">معاينة العميل</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_filter( 'post_updated_messages', 'client_updated_messages' );





add_filter( 'manage_edit-client_columns', 'set_custom_edit_client_columns' );
add_action( 'manage_client_posts_custom_column' , 'custom_client_column', 10, 2 );

function set_custom_edit_client_columns($columns) {
    $columns['featured'] = __( 'Featured Image' );
    $columns['order'] = __( 'Order' );

    return $columns;
}

function custom_client_column( $column, $post_id ) {
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



add_action('client_category_add_form_fields' , 'client_category_form_custom_field_add' , 10);
add_action( 'client_category_edit_form_fields', 'client_category_form_custom_field_edit', 10, 2 );

function client_category_form_custom_field_add(){
	
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
  <input type="text"  name="client_category_image" id="_unique_name" value="" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="إضافة صورة" />
</div>
</div>
<?php	
	
	}




function client_category_form_custom_field_edit( $tag, $taxonomy ) {

 wp_enqueue_media();


	$option_name = 'client_category_image_' . $tag->term_id;
	$client_category_image = get_option( $option_name );


	

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
  <th scope="row" valign="top"><label for="client_category_image"><?php _e('Image'); ?></label></th>
  <td>

    

  
      <div class="uploader">
     <div class="form-field"> 
  <input type="text" class="regular-text" name="client_category_image" id="_unique_name" value="<?php echo esc_attr( $client_category_image ) ? esc_attr( $client_category_image ) : ''; ?>" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="إضافة/تغيير صورة" />
</div>
    
 
    
    
  </td>
</tr>
<?php
}	
	
	
/** Save Custom Field Of Category Form */
add_action( 'created_client_category', 'client_category_form_custom_field_save', 10, 2 );	
add_action( 'edited_client_category', 'client_category_form_custom_field_save', 10, 2 );

function client_category_form_custom_field_save( $term_id, $tt_id ) {

	if ( isset( $_POST['client_category_image'] ) ) {			
		$option_name = 'client_category_image_' . $term_id;
		update_option( $option_name, $_POST['client_category_image'] );
	}
}	
	





?>