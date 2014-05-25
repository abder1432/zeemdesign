<?php 
/*
* Template name: Contact
*/
get_header(); ?>

    	<div id="content">
        
        <?php if (function_exists('get_breadcrumb')) get_breadcrumb(); ?>
        

                
     
                
            
                  <div id="contact-form">
                  	<h3>نموذج الاتصال</h3>
				  <?php echo do_shortcode('[contact-form-7 id="114"]'); ?>
                  </div>
                  
                  <div id="contact-info">
                  
                  <h3>موقعنا</h3>
                  
                  	<div id="map"></div>
                    <div id="info">
                    
                    <h3>معلومات الاتصال</h3>
                    
                    <h6>9497 شارع العليا العام <br> الرياض, 11413</h6>
                        <ul>
                        <li>الهاتف: <span><a href="tel:+966 5 63659632">+966 5 63659632</a></span></li>
                        <li>فاكس: <span>+1 504 889 9898</span></li>
                        <li>البريد الالكتروني: <?php echo make_clickable('info@al-quwa.com'); ?></li>
                        </ul>
                    
                    
                    </div>
                  
                  
                  </div>
                  <div class="clear"></div>
                  
                  
                  
                
           
           
        
        
        </div>

<?php get_footer(); ?>
     