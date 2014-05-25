    	<div id="sidebar">


        <div id="clients">
        <h2>عملائنا</h2>
       
        
          <ul id="mycarousel" class="jcarousel-skin-tango">
          
          <?php $clients = new WP_Query(array('post_type' => 'client', 'posts_per_page' => '6')); ?>
          <?php while($clients->have_posts()) : $clients->the_post(); ?>
            <li><?php the_post_thumbnail('thumbnail'); ?></li>
            <?php endwhile; ?>
    
  	     </ul>
        
        
        
        </div><!--#clients -->
        
        <div id="ads">
        <h2>اعلانات</h2>


          <ul id="adscarousel" class="jcarousel-skin-tango">
          
          <?php $clients = new WP_Query(array('post_type' => 'ad', 'posts_per_page' => '6')); ?>
          <?php while($clients->have_posts()) : $clients->the_post(); ?>
            <?php if (has_post_thumbnail()) : ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></li>
            <?php endif; ?>
            <?php endwhile; ?>
    
  	     </ul>



        
        </div><!--#ads -->
        
        
        
        
        
        </div><!--/#sidebar -->