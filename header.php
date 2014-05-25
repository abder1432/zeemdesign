<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes();?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php bloginfo('name');wp_title('|'); ?></title>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>



<div id="page">
	<div id="header">
    
    	<div id="logo">
        	<a href="<?php echo home_url('/'); ?>">
            	<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" width="165" height="159" alt="" />
            </a>
      </div><!--/#logo -->
         
    	<div id="nav"><?php wp_nav_menu(array('theme_location' => 'primary' ,'container_class' => 'menu_container', 'menu_class' => 'sf-menu')); ?></div> <!--/#nav -->

    	<div id="social">
        	<ul>
            
                
                <li>
                <a target="_blank" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" width="32" height="32" alt="" /></a>
                </li>             
                
                <li>
                <a target="_blank" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" width="32" height="32" alt="" /></a>
                </li> 
 
                <li>
                <a target="_blank" href="<?php echo site_url('/?feed=rss2'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/rss.png" width="32" height="32" alt="" /></a>
                </li>
                

                               
            </ul>
        
        </div><!--#social --> 
        
                       
    </div><!--#header -->
    
    
    <div id="latestnews"><?php get_template_part('newsticker'); ?></div>
    
	<div id="main">
   		 <?php if (is_home()) :?>
  
    	<?php get_template_part('nivoslider'); ?>
		<?php endif; ?>