<?php get_header(); ?>
    	<div id="content">
        
        <?php if (function_exists('get_breadcrumb')) get_breadcrumb(); ?>
        
        
               <div class="page-header">
                  <div class="entry-title">
                    <h1>أخبارنا</h1>
                  </div>
                </div>
        
        
        <div class="news_archive">

                <?php while(have_posts()) : the_post(); ?>
                     <div class="article">       
              <div class="thumbnail">
                <a href="<?php the_permalink(); ?>">
                
                <?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('large', array( 'alt' => '')); ?>
                <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/thumbnail.jpg" width="148" height="148" alt="" />
                <?php endif; ?>
              
                </a>
               </div>
               
               <div class="body"> 
             
               <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="date">
                  <?php the_time(get_option('date_format')); ?>
                </div>
                <div class="excerpt">
                  <?php the_excerpt_max_charlength(100) ;?>
                </div>
               
               <div class="more"><a href="<?php the_permalink(); ?>">المزيد</a> 
               
				</div>
               
               </div>
                
                            <div class="clear"></div>
					  </div>
                <?php endwhile; ?>
            
          
       </div> 
       
               <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>

       
        
        </div>

<?php get_footer(); ?>
     