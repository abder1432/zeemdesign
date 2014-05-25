<?php 

function alquwa_enqueue_scripts(){
	
	
// grid 960



if (is_rtl()){
	wp_enqueue_style('reset' , get_template_directory_uri() . '/css/reset_rtl.css');
	wp_enqueue_style('text' , get_template_directory_uri() . '/css/text_rtl.css');
}

else {
	wp_enqueue_style('reset' , get_template_directory_uri() . '/css/reset.css');
	wp_enqueue_style('text' , get_template_directory_uri() . '/css/text.css');
}

// style


wp_enqueue_style('style' , get_template_directory_uri() . '/style.css');

wp_deregister_script('jquery'); 
wp_register_script('jquery' , 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');


// Superfish //

wp_enqueue_style('superfish' , get_template_directory_uri() . '/css/superfish.css');
wp_enqueue_script('jquery-superfish' , get_template_directory_uri() . '/js/superfish.js' , array('jquery') ,false, true);
wp_enqueue_script('jquery-hoverIntent' , get_template_directory_uri() . '/js/hoverIntent.js' , array('jquery') ,false, true);




// jscroller
wp_enqueue_style('jscroller' , get_template_directory_uri() . '/css/jscroller.css');
wp_enqueue_script('jquery-jscroller' , get_template_directory_uri() . '/js/jscroller-0.4.js' , array('jquery') ,false, true);



if (is_home()){
// nivoslider

	wp_enqueue_style('nivoslider' , get_template_directory_uri() . '/css/nivo-slider.css');
	wp_enqueue_script('nivoslider' , get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js' , array('jquery') ,false, true);
	
	
	// jcarousel
	
	wp_enqueue_style('jcarousel' , get_template_directory_uri() . '/css/skin.css');
	wp_enqueue_style('ads' , get_template_directory_uri() . '/css/ads.css');
	wp_enqueue_script('jquery-jcarousel' , get_template_directory_uri() . '/js/jquery.jcarousel.min.js' , array('jquery') ,false, true);
 
}


 
 


	
}

add_action('wp_enqueue_scripts', 'alquwa_enqueue_scripts');


function alquwa_head(){
?>

<?php if (is_home()) { ?>

<script type="text/javascript">
jQuery(window).load(function() {
	
/* NivoSlider
***********************************************/	
   jQuery('#slider').nivoSlider({ effect: "random" ,});
	   
	
});
</script>

<?php } ?>


<script type="text/javascript">

jQuery(document).ready(function(){
	
/* Superfish
***********************************************/	
	
	jQuery('ul.sf-menu').superfish();	
	
<?php if (is_home()){ ?>	
	
/* Jcarousel
***********************************************/			
    jQuery('#mycarousel').jcarousel({
    	wrap: 'circular',
		rtl: <?php echo (is_rtl()) ?  "true" : "false";  ?>,
		auto:2,
		scroll:1,
    });
	
    jQuery('#adscarousel').jcarousel({
    	wrap: 'last',
		rtl: <?php echo (is_rtl()) ?  "true" : "false";  ?>,
		auto:4,
		scroll:1,
        buttonNextHTML: '',
        buttonPrevHTML: '',		
    });

	
 <?php } ?>
 
 
 
  });	
  
  

 
  		
</script>



<script type="text/javascript">

// this must be after jcarousel scripts
 jQuery(document).ready(function(){

  // Add Scroller Object
  $jScroller.add("#scroller_container","#scroller","<?php echo (is_rtl()) ?  "right" : "left";  ?>", 5,true);

  // Start Autoscroller
  $jScroller.start();
 });
</script>

<?php if (is_page_template('page-templates/contact.php')) { ?>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
// This example displays a marker at the center of Australia.
// When the user clicks the marker, an info window opens.

function initialize() {
  var myLatlng = new google.maps.LatLng(25.100449,55.169492);
  var mapOptions = {
	scaleControl: true,  
    zoom: 16,
    center: myLatlng
  };

  var map = new google.maps.Map(document.getElementById('map'), mapOptions);

  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">القوة المتطورة المحدودة</h1>'+
      '<div id="bodyContent">'+
      '<p>9497 شارع العليا العام <br> الرياض, 11413</p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString,
	  maxWidth: 400
  });

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Uluru (Ayers Rock)'
  });
    infowindow.open(map,marker);
 
}

google.maps.event.addDomListener(window, 'load', initialize);

  
  
    </script>


  

<?php	
 }
}

add_action('wp_footer' , 'alquwa_head' , 100);

?>