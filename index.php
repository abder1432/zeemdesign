<?php get_header(); ?>
    	<div id="content">
        
            <div id="about-us">
                <?php 
                
                $about = new WP_Query(array('page_id' => 9)); 
                while($about->have_posts()) : $about->the_post();
                $link = '<div class="more"><a href="' . get_permalink() . '">المزيد</a></div>';
                ?>
                
                <h2>شركة القوى المتطورة المحدودة</h2>
                
                <?php the_content($link); ?>
                
                
                <?php endwhile; ?>
            
            </div><!--/#about-us -->
        
        
        </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
     