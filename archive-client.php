<?php get_header(); ?>
    	<div id="content">
        
        <?php if (function_exists('get_breadcrumb')) get_breadcrumb(); ?>
        
        
               <div class="page-header">
                  <div class="entry-title">
                    <h1>عملائنا</h1>
                  </div>
                </div>
        
        
        <div class="clients_archive">
            <ul>
                <?php while(have_posts()) : the_post(); ?>
                
						<?php $url = get_post_meta( $post->ID, 'url', true ); ?>
                <li><a target="_blank" href="<?php echo $url; ?>"><?php the_post_thumbnail('thumbnail'); ?></a></li>
                
                
                <?php endwhile; ?>
            
            </ul>
            <div class="clear"></div>
       </div> 
        
        </div>

<?php get_footer(); ?>
     