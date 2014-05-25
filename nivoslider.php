<?php $slides = new WP_Query(array( 'post_type' => 'slide' , 'posts_per_page' => 4, 'orderby' => 'menu_order' , 'order' => 'ASC')); ?>
<?php if ($slides->have_posts()) : ?>

   
      	  <div id="slider-wrapper">
          	 <div id="slider" class="nivoSlider">
             
<?php 

while($slides->have_posts()) : $slides->the_post(); 


?>


<?php the_post_thumbnail('slider', array( 'title' => '' , 'alt' => '')); ?>
                
<?php endwhile; ?>                
                
                
            </div>
            
               
          
          
          
          </div>
  
        
        
<?php endif; ?>