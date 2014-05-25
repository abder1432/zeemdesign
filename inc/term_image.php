<?php 


$taxonomies = array('ad_category', 'category' , 'post_tag');

foreach($taxonomies as $taxonomy){
	add_action($taxonomy.'_add_form_fields' , 'taxonomies_form_custom_field_add' , 10);
	add_action($taxonomy.'_edit_form_fields', 'taxonomies_form_custom_field_edit', 10, 2 );
	add_action( 'created_'.$taxonomy, 'taxonomies_form_custom_field_save', 10, 2 );	
	add_action( 'edited_'.$taxonomy, 'taxonomies_form_custom_field_save', 10, 2 );
	add_filter("manage_". $taxonomy . "_custom_column", 'manage_theme_columns', 10, 3);
	add_filter("manage_edit-" . $taxonomy . "_columns", 'theme_columns');		
}


function taxonomies_form_custom_field_add(){

	
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
        $("#"+id).val(attachment.id);
		 $("#preview").attr( 'src' , attachment.url);
		 $("#_unique_name_button").val( 'تغيير الصورة' );
		 $("#remove").show();

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
  
  $("#submit").click(function(e) {
	  
	  var tagname = $('#tag-name').val();
	  
	 if ( len(tagname) > 0 ){ 
    	$("#preview").attr( 'src' , '');
	 }
	 
 });
 
 
  
  $("#remove").click(function(e) {
	  	e.preventDefault();
        $("#_unique_name").val('');
		$("#preview").attr( 'src' , '');
		$("#_unique_name_button").val( 'إضافة صورة' );
		$(this).hide();
	 
 });

});
    
    
    
    </script>


<div style="margin-bottom:20px;">
<label><?php _e('Image'); ?></label>
    <div class="uploader">
    <img id="preview" src="" width="80" height="80" alt="" />
     <div class="form-field"> 
  <input type="hidden"  name="attachment_id" id="_unique_name" value="" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="إضافة صورة" />
  <a style="display:none;" class="link" href="#" id="remove" >إزالة الصورة</a>
</div>
</div>
<?php	
	
	}




function taxonomies_form_custom_field_edit( $tag, $taxonomy ) {

 wp_enqueue_media();


    $attachment_id = get_option( 'term_image_' . $tag->term_id );
	$image =  wp_get_attachment_image_src( $attachment_id );
	

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
        $("#"+id).val(attachment.id);
		 $("#preview").attr( 'src' , attachment.url);
		 $("#_unique_name_button").val( 'تغيير الصورة' );
		 $("#remove").show();

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
  
  $("#submit").click(function(e) {
	  
	  var tagname = $('#tag-name').val();
	  
	 if ( len(tagname) > 0 ){ 
    	$("#preview").attr( 'src' , '');
	 }
	 
 });
 
 
  
  $("#remove").click(function(e) {
	  	e.preventDefault();
        $("#_unique_name").val('');
		$("#preview").attr( 'src' , '');
		$("#_unique_name_button").val( 'إضافة صورة' );
		$(this).hide();
	 
 });

});
    
    
    
    </script>


<tr class="">
  <th scope="row" valign="top"><label for="term_image"><?php _e('Image'); ?></label></th>
  <td>

    

    <div class="uploader">
    <img id="preview" src="<?php echo esc_attr($image[0]); ?>" width="80" height="80" alt="" />
     <div class="form-field"> 
  <input type="hidden"  name="attachment_id" id="_unique_name" value="" />
  </div>
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="<?php echo ($image?'تغيير الصورة':'إضافة صورة') ?>" />
  <a <?php echo ($image?'':'style="display:none;"') ?> class="link" href="#" id="remove" >إزالة الصورة</a>
</div>
    
 
    
    
  </td>
</tr>
<?php
}	
	
	
/** Save Custom Field Of Category Form */


function taxonomies_form_custom_field_save( $term_id, $tt_id ) {

	if ( isset( $_POST['attachment_id'] ) ) {			
		$option_name = 'term_image_' . $term_id;
		update_option( $option_name, $_POST['attachment_id'] );
	}
}	
	


// Add to admin_init function


function theme_columns($theme_columns) {
	$new_columns = array(
		'cb' => '<input type="checkbox" />',
		'name' => __('Name'),
		'image' => __('Image'),		
		'description' => __('Description'),
		'slug' => __('Slug'),
		'posts' => __('Posts')
		);
	return $new_columns;
}



// Add to admin_init function  

 
function manage_theme_columns($out, $column_name, $theme_id) {
    switch ($column_name) {
        case 'image':
            $attachment_id = get_option( 'term_image_' . $theme_id, $_POST['attachment_id'] );
			$out .=  wp_get_attachment_image( $attachment_id );
            break;
 
        default:
            break;
    }
    return $out;   
}




?>