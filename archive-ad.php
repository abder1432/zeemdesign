<?php get_header(); ?>
    	<div id="content">
        
        <?php if (function_exists('get_breadcrumb')) get_breadcrumb(); ?>
        
        
               <div class="page-header">
                  <div class="entry-title">
                    <h1>إعلاناتنا</h1>
                  </div>
                </div>
        
        
        <div class="ads_archive">
        
        <?php 
		
		$args = array( 'taxonomy' => 'ad_category' , 'hide_empty' => 0 , 'orderby' => 'menu_order' , 'order' => 'ASC');
		$terms = get_terms('ad_category' ,$args);?>
        
            <ul>
.
  <?php
foreach ($terms as $term){

    $attachment_id = get_option( 'term_image_' . $term->term_id );
	$image =  wp_get_attachment_image( $attachment_id );
	
	?>



<li>
                        <a href="<?php echo get_term_link($term); ?>">
                        <?php echo $image; ?><br>
                        <span class="title">
                                       <?php echo $term->name . '<span class="count"> (' . $term->count . ')</span>' ; ?>
                                        
                                        </span>
                                        </a>
                           
                        </li>


	<?php
	}

  ?>

            
            </ul>
            <div class="clear"></div>
       </div> 
       

       
        
        </div>

<?php get_footer(); ?>
     