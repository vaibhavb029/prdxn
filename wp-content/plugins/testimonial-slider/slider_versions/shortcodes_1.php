<?php 
function return_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0'){
	$slider_html='';
	$slider_html=get_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo);
	return $slider_html;
}
function return_testimonial_slider($slider_id='',$set='',$offset=0) {
	global $testimonial_slider; 
 	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
 
	if($testimonial_slider['multiple_sliders'] == '1' and is_singular() and (empty($slider_id) or !isset($slider_id))){
		global $post;
		$post_id = $post->ID;
		$slider_id = get_testimonial_slider_for_the_post($post_id);
	}
	if(empty($slider_id) or !isset($slider_id))  $slider_id = '1';
	if( !$offset or empty($offset) or !is_numeric($offset)  ) $offset=0;
	$slider_handle='testimonial_slider_'.$slider_id;
	$slider_html='';
	if(!empty($slider_id)){
		$r_array = testimonial_carousel_posts_on_slider($testimonial_slider_curr['no_posts'], $offset, $slider_id, $echo = '0', $set); 
		$slider_html=return_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0');
	} //end of not empty slider_id condition
	
	return $slider_html;
}

function testimonial_slider_simple_shortcode($atts) {
	extract(shortcode_atts(array(
		'id' => '',
		'set' => '',
		'offset' => '',
	), $atts));

	return return_testimonial_slider($id,$set,$offset);
}
add_shortcode('testimonialslider', 'testimonial_slider_simple_shortcode');

//Category shortcode
function return_testimonial_slider_category($catg_slug='',$set='',$offset=0) {
	global $testimonial_slider; 
 	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	if( !$offset or empty($offset) or !is_numeric($offset)  ) $offset=0;
    $r_array = testimonial_carousel_posts_on_slider_category($testimonial_slider_curr['no_posts'], $catg_slug, $offset, '0', $set); 
	$slider_handle='testimonial_slider_'.$catg_slug;
	//get slider 
	$slider_html=return_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0');
	
	return $slider_html;
}

function testimonial_slider_category_shortcode($atts) {
	extract(shortcode_atts(array(
		'catg_slug' => '',
		'set' => '',
		'offset' => '',
	), $atts));

	return return_testimonial_slider_category($catg_slug,$set,$offset);
}
add_shortcode('testimonialcategory', 'testimonial_slider_category_shortcode');

//Recent Posts Shortcode
function return_testimonial_slider_recent($set='',$offset=0) {
	global $testimonial_slider; 
 	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	if( !$offset or empty($offset) or !is_numeric($offset)  ) $offset=0;
	$r_array = testimonial_carousel_posts_on_slider_recent($testimonial_slider_curr['no_posts'], $offset, '0', $set); 
	$slider_handle='testimonial_slider_recent';
	
	//get slider 
	$slider_html=return_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0');
	
	return $slider_html;
}

function testimonial_slider_recent_shortcode($atts) {
	extract(shortcode_atts(array(
		'set' => '',
		'offset' => '',
	), $atts));
	return return_testimonial_slider_recent($set,$offset);
}
add_shortcode('testimonialrecent', 'testimonial_slider_recent_shortcode');
?>
