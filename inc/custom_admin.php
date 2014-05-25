<?php

function favicon4admin() {
echo '<link rel="Shortcut Icon" type="image/png" href="' . get_bloginfo('temlate_url') . '/favicon.png" />';
}
add_action( 'admin_head', 'favicon4admin' );

/* Hide admin color scheme options from user profile */


function admin_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'admin_color_scheme');

/* How to remove menu items from admin bar (on top) */

function wps_admin_bar() {

    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('wp-logo');

    $wp_admin_bar->remove_menu('about');

    $wp_admin_bar->remove_menu('wporg');

    $wp_admin_bar->remove_menu('documentation');

    $wp_admin_bar->remove_menu('support-forums');

    $wp_admin_bar->remove_menu('feedback');

    $wp_admin_bar->remove_menu('view-site');
	$wp_admin_bar->remove_menu('new-post');
	$wp_admin_bar->remove_menu('comments');	

}

add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );


// This example removes support for comments in pages and attachments: 

add_action( 'init', 'no_comments' );

function no_comments() {
	remove_post_type_support( 'page', 'comments' );
	remove_post_type_support( 'attachment', 'comments' );

}

/* Hide ‘help’ Tab from admin panel */


function hide_help() {
    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
          </style>';
}
add_action('admin_head', 'hide_help');






/* Change WordPress version in admin footer */


function change_footer_version() {
  return '';
}
add_filter( 'update_footer', 'change_footer_version', 9999 );


/* Change footer text in WordPress admin panel */

function remove_footer_admin () {
  echo 'جـمـيـع الـحـقـوق مـحـفـوظـة ©  2014  |  تـصـمـيـم وتـطـويـر  <a target="_blank" href="http://zeemdesign.net/">زيم دزاين</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

/* How to display dashboard in a single column only */

function single_screen_columns( $columns ) {
    $columns['dashboard'] = 1;
    return $columns;
}
add_filter( 'screen_layout_columns', 'single_screen_columns' );
function single_screen_dashboard(){return 1;}
add_filter( 'get_user_option_screen_layout_dashboard', 'single_screen_dashboard' );


/* How to remove menu items from WordPress admin panel/dashboard */


add_action( 'admin_menu', 'remove_links_menu' );
function remove_links_menu() {

	 
     remove_menu_page('edit-comments.php'); // comments
	 	
     remove_menu_page('themes.php'); // Appearance
     remove_menu_page('plugins.php'); // Plugins
     remove_menu_page('tools.php'); // Tools
	 remove_menu_page('edit.php'); // Posts
	 remove_submenu_page('index.php' ,'update-core.php'); // Updates
     remove_submenu_page('options-general.php' ,'options-reading.php'); // Settings
	 remove_submenu_page('options-general.php' ,'options-writing.php'); // Settings
	 remove_submenu_page('options-general.php' ,'options-media.php'); // Settings
	 remove_submenu_page('options-general.php' ,'options-permalink.php'); // Settings
	 remove_submenu_page('options-general.php' ,'options-discussion.php'); // Settings	
	 remove_submenu_page('options-general.php' ,'pagenavi'); // Settings	
	 remove_submenu_page('options-general.php' ,'wpba-settings'); // Settings		 
	 remove_submenu_page('options-general.php' ,'wpba-settings'); 	 	 
	 remove_submenu_page('options-general.php' ,'wp-postviews/postviews-options.php'); 	 
	 
	 add_menu_page( __('Menus'), __('Menus'),  'manage_options' , 'nav-menus.php' ); 		 	 
}


/* How to disable browser upgrade notification/warning */

function disable_browser_upgrade_warning() {
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'disable_browser_upgrade_warning' );




/* 
How to change WordPress admin and login page logo */


function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { 
		background-image:url('.get_bloginfo('template_url').'/images/logo.png) !important;
		height:99px !important;
		width:320px !important;
		background-size:auto !important;
		 }
    </style>';
}

add_action('login_head', 'my_custom_login_logo');




function custom_logo() {
  echo '<style type="text/css">
    #header-logo { background-image: url('.get_bloginfo('template_directory').'/images/admin_page_logo.png) !important; }
    </style>';
}

add_action('admin_head', 'custom_logo');


/* Change WordPress default FROM email address */


add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {
 return get_option('admin_email');
}
function new_mail_from_name($old) {
 return get_bloginfo('name');
}







/* Remove Dashboard Widgets */

function remove_dashboard_widgets() {

	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	
	
	
	
	if ( current_user_can( 'edit_theme_options' ) )
	update_user_meta( get_current_user_id(), 'show_welcome_panel', false );
	
}




add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );



function rc_my_welcome_panel() {

	?>
<script type="text/javascript">
/* Hide default welcome message */
jQuery(document).ready( function($) 
{
	$('div.welcome-panel-content').hide();
});
</script>

<style type="text/css">
div.welcome-panel-content { display:none !important; visibility: hidden !important;}
</style>	

<?php
}

add_action( 'admin_head', 'rc_my_welcome_panel' );

/* 
How can I disable the update notice for non-administrators? */



add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );




?>
