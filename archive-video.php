<?php get_header(); ?>
    	<div id="content">
        
        <?php if (function_exists('get_breadcrumb')) get_breadcrumb(); ?>
        
        
               <div class="page-header">
                  <div class="entry-title">
                    <h1>مكتبة الفيديو</h1>
                  </div>
                </div>
        
        
        <div class="ads_archive">
            <ul>
                <?php while(have_posts()) : the_post(); ?>
                <?php $video_id = get_post_meta($post->ID, 'url', true); ?>
                <li>
                <a href="<?php the_permalink(); ?>">
                
        
                <img src="http://img.youtube.com/vi/<?php echo $video_id; ?>/hqdefault.jpg" width="270" height="270" alt="" />
            
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
     