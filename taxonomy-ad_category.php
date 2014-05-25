<?php get_header(); ?>
    	<div id="content">
        
        <?php if (function_exists('get_breadcrumb')) get_breadcrumb(); ?>
        
        
               <div class="page-header">
                  <div class="entry-title">
                    <h1><?php single_cat_title(); ?></h1>
                  </div>
                </div>
        
        
        <div class="ads_archive">
            <ul>
                <?php while(have_posts()) : the_post(); ?>
                
                <li>
                <a href="<?php the_permalink(); ?>">
                
                <?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('large', array( 'alt' => '')); ?>
                <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" width="270" height="270" alt="" />
                <?php endif; ?>
                <span class="title"><?php the_title(); ?></span>
                </a>
                
                </li>
                
                
                <?php endwhile; ?>
            
            </ul>
            <div class="clear"></div>
       </div> 
       
               <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>

       
        
        </div>

<?php get_footer(); ?>
     