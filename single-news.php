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
                
                <div class="entry-meta">
                  <?php the_time(get_option('date_format')); ?>
                </div>
                
                <?php if (has_post_thumbnail()) :  ?>
                <div class="entry-thumbnail">
                  <?php the_post_thumbnail(); ?>
                </div>
                <?php endif; ?>
                
                <div class="entry-content">
                  <?php the_content(); ?>
                </div>
                
                
                
            <div class="share">
  
  
      



      <!-- AddThis Button BEGIN -->



                                <div class="addthis_toolbox addthis_default_style f-l" style=" float:right;">



                                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>



                                <a class="addthis_button_tweet"></a>



                                <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>



                                <a class="addthis_counter addthis_pill_style"></a>



                                </div>



                      <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f396d28698557a4"></script>



                                <!-- AddThis Button END -->
  
  
  </div>    
                
                
                <?php endwhile; ?>
            <?php if(comments_open()) comments_template(); ?>
            </div><!--/#post-* -->
        
        
        </div>

<?php get_footer(); ?>
     