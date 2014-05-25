<?php get_header(); ?>
    	<div id="content">
        
        <?php if (function_exists('get_breadcrumb')) get_breadcrumb(); ?>
        
            <div id="post-<?php the_ID();?>" <?php post_class();?>>
                <?php while(have_posts()) : the_post(); ?>
                
                <div class="page-header">
                  <div class="entry-title">
                    <h1><?php the_title(); ?></h1>
                  </div>
                </div>
                
                <?php if (has_post_thumbnail()) :  ?>
                <div class="entry-thumbnail">
                  <?php the_post_thumbnail(); ?>
                </div>
                <?php endif; ?>
                
                <div class="entry-content">
                  <?php the_content(); ?>
                </div>
                
                
                <?php endwhile; ?>
            
            </div><!--/#post-* -->
        
        
        </div>

<?php get_footer(); ?>
     