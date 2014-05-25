<div id="news-ticker">
  
<div class="ticker-title">آخر الاخبار</div>


<div class="ticker-content">

<div id="scroller_container">
 <div id="scroller">
        <?php $news = new WP_Query(array('post_type' => 'news', 'posts_per_page' => '10')); ?>
          <?php while($news->have_posts()) : $news->the_post(); ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php endwhile; ?>
        
 </div>
</div>
     
 </div>                 
</div>


