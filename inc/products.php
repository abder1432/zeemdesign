<?php 

// Register Custom Post Type
function alquwa_product() {

	$labels = array(
		'name'                => 'المنتجات',
		'singular_name'       => 'منتج',
		'menu_name'           => 'المنتجات',
		'parent_item_colon'   => '',
		'all_items'           => 'كافة المنتجات',
		'view_item'           => 'عرض المنتج',
		'add_new_item'        => 'أضف منتج جديد',
		'add_new'             => 'أضف جديد',
		'edit_item'           => 'تحرير منتج',
		'update_item'         => 'تحديث منتج',
		'search_items'        => 'بحث في المنتجات',
		'not_found'           => 'لا يوجد منتجات.',
		'not_found_in_trash'  => 'لا يوجد منتجات في سلة المهملات.',
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' , 'page-attributes', 'thumbnail'  ),
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
	register_post_type( 'product', $args );

}

add_action( 'init', 'alquwa_product', 0 );



// product_category Taxonomy
add_action( 'init', 'create_product_taxonomies', 0 );

function create_product_taxonomies() {
	

	

	$args = array(
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'region' ),
	);

	register_taxonomy( 'product_category', 'product', $args );
}



// Branche details


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function product_add_custom_box() {

        add_meta_box(
            'pricediv',
            'سعر المنتج',
            'product_inner_custom_box',
            'product'
        );
}
add_action( 'add_meta_boxes', 'product_add_custom_box' );


function product_inner_custom_box( $post ) {

  wp_nonce_field( 'product_inner_custom_box', 'product_inner_custom_box_nonce' );



  $price = get_post_meta( $post->ID, 'price', true );
  $old_price = get_post_meta( $post->ID, 'old_price', true );



?>


<table class="form-table" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="form-field">
    <th scope="row"><label for="price">السعر</label></th>
    <td><input name="price" type="text" value="<?php echo esc_attr( $price ) ?>" /></td>
  </tr>
  <tr class="form-field">
    <th scope="row"><label for="old_price">السعر قبل التخفيض</label></th>
    <td><input name="old_price" type="text" value="<?php echo esc_attr( $old_price ) ?>" /></td>
  </tr>
</table>




<?php

}


function alquwa_save_postdata( $post_id ) {


  if ( ! isset( $_POST['product_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['product_inner_custom_box_nonce'];

  if ( ! wp_verify_nonce( $nonce, 'product_inner_custom_box' ) )
      return $post_id;

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  if ( 'product' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }


  $price = sanitize_text_field( $_POST['price'] );
  $old_price = sanitize_text_field( $_POST['old_price'] );


  update_post_meta( $post_id, 'price', $price );
  update_post_meta( $post_id, 'old_price', $old_price );





}
add_action( 'save_post', 'alquwa_save_postdata' );







// Customizing the messages: 


//add filter to ensure the text News, or News, is displayed when user updates a News

function product_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['product'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf('تم تحديث المنتج. <a href="%s">مشاهدة المنتج</a>', esc_url( get_permalink($post_ID) ) ),
    4 => 'تم تحديث المنتج',
    /* translators: %s: date and time of the revision */
    6 => sprintf( 'تم نشر المنتج. <a href="%s">مشاهدة المنتج</a>', esc_url( get_permalink($post_ID) ) ),
    7 => 'تم حفظ المنتج.',
    9 => sprintf('المنتج مجدول ليوم: <strong>%1$s</strong>. <a target="_blank" href="%2$s">معاينة المنتج</a>',
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( 'تم تحديث مسودة المنتج. <a target="_blank" href="%s">معاينة المنتج</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

add_filter( 'post_updated_messages', 'product_updated_messages' );





add_filter( 'manage_edit-product_columns', 'set_custom_edit_product_columns' );
add_action( 'manage_product_posts_custom_column' , 'custom_product_column', 10, 2 );

function set_custom_edit_product_columns($columns) {
    $columns['featured'] = __( 'Featured Image' );
    $columns['order'] = __( 'Order' );

    return $columns;
}

function custom_product_column( $column, $post_id ) {
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



add_action('product_category_add_form_fields' , 'product_category_form_custom_field_add' , 10);
add_action( 'product_category_edit_form_fields', 'product_category_form_custom_field_edit', 10, 2 );

function product_category_form_custom_field_add(){
	
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
  <input type="text"  name="product_category_image" id="_unique_name" value="" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="إضافة صورة" />
</div>
</div>
<?php	
	
	}




function product_category_form_custom_field_edit( $tag, $taxonomy ) {

 wp_enqueue_media();


	$option_name = 'product_category_image_' . $tag->term_id;
	$product_category_image = get_option( $option_name );


	

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
  <th scope="row" valign="top"><label for="product_category_image"><?php _e('Image'); ?></label></th>
  <td>

    

  
      <div class="uploader">
     <div class="form-field"> 
  <input type="text" class="regular-text" name="product_category_image" id="_unique_name" value="<?php echo esc_attr( $product_category_image ) ? esc_attr( $product_category_image ) : ''; ?>" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="إضافة/تغيير صورة" />
</div>
    
 
    
    
  </td>
</tr>
<?php
}	
	
	
/** Save Custom Field Of Category Form */
add_action( 'created_product_category', 'product_category_form_custom_field_save', 10, 2 );	
add_action( 'edited_product_category', 'product_category_form_custom_field_save', 10, 2 );

function product_category_form_custom_field_save( $term_id, $tt_id ) {

	if ( isset( $_POST['product_category_image'] ) ) {			
		$option_name = 'product_category_image_' . $term_id;
		update_option( $option_name, $_POST['product_category_image'] );
	}
}	
	





?>