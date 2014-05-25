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
                
   
                
                <div class="entry-content" style="text-align:center;">
                   <?php $video_id = get_post_meta($post->ID, 'url', true); ?>
                   
                   <iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowfullscreen></iframe>
                   
                   
                </div>
                
                
                <?php endwhile; ?>
            
            </div><!--/#post-* -->
        
        
        </div>

<?php get_footer(); ?>
     