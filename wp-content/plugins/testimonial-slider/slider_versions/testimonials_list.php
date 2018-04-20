<?php 
if(!function_exists('get_global_testimonial_list')){
	function get_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data=array()){
		global $testimonial_slider,$default_testimonial_slider_settings; 
		$testimonial_sldr_j = $r_array[0];
		$testimonial_slider_css = testimonial_get_inline_css($set); 
		$slider_html='';
	
		foreach($default_testimonial_slider_settings as $key=>$value){
			if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
		}
	
		$testimonial_media_queries='';
		$responsive_max_width=($testimonial_slider_curr['width']>0)?( $testimonial_slider_curr['width'].'px'  ) : ( '100%' );
	    
			$testimonial_media_queries='.testimonial_slider_set'.$set.'.testimonial_slider{width:100% !important;max-width:'.$responsive_max_width.';display:block;}.testimonial_slider_set'.$set.' .testimonial_slideri{max-width:90% !important;}.testimonial_slider_set'.$set.' img{max-width:90% !important;}';
			//filter hook
			$testimonial_media_queries=apply_filters('testimonial_media_queries',$testimonial_media_queries,$testimonial_slider_curr,$set);
	
	
		$script='<script type="text/javascript"> ';
		if(!empty($testimonial_media_queries)){
				$script.='jQuery(document).ready(function() {jQuery("head").append("<style type=\"text/css\">'. $testimonial_media_queries .'</style>");});';
		}
		//action hook
		do_action('testimonial_global_list_script',$slider_handle,$testimonial_slider_curr);
		$script.='</script>';
	
		//Added for skins $stylesheet=$testimonial_slider['stylesheet'];
		$stylesheet=$testimonial_slider_curr['stylesheet'];
		if(empty($stylesheet)) $stylesheet = 'default';
	
		// Added For skin specific Stylesheets
		if(isset($testimonial_slider_curr['stylesheet'])) $skin=$testimonial_slider_curr['stylesheet'];
		if(empty($skin))$skin='default';
		wp_enqueue_style( 'testimonial_'.$skin, testimonial_slider_plugin_url( 'css/skins/'.$skin.'/style.css' ),false,TESTIMONIAL_SLIDER_VER, 'all');
		wp_enqueue_style( 'dashicons' );
		$slider_html.='<div id="'.$slider_handle.'_wrap" class="testimonial_slider testimonial_slider_set'. $set .' testimonial_slider__'.$stylesheet.'" '.$testimonial_slider_css['testimonial_slider'].'>
			<div id="'.$slider_handle.'" class="testimonial_slider_instance">
				'. $r_array[1] .'
			</div>
		</div>'.$script;
	
		$line_breaks = array("\r\n", "\n", "\r");
		$slider_html = str_replace($line_breaks, "", $slider_html);
	
		if($echo == '1')  {echo $slider_html; }
		else { return $slider_html; }	
	}
}
if(!function_exists('get_testimonial_list_custom')){
	function get_testimonial_list_custom($slider_id='',$set='',$offset=0, $data=array() ) {
	    global $testimonial_slider,$default_testimonial_slider_settings; 
	 	$testimonial_slider_options='testimonial_slider_options'.$set;
	    $testimonial_slider_curr=get_option($testimonial_slider_options);
		if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
		foreach($default_testimonial_slider_settings as $key=>$value){
			if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
		}
	
		if( !$offset or empty($offset) or !is_numeric($offset)  ) {
			$offset=0;
		}
		 
		if($testimonial_slider['multiple_sliders'] == '1' and is_singular() and (empty($slider_id) or !isset($slider_id))){
			global $post;
			$post_id = $post->ID;
			$slider_id = get_testimonial_slider_for_the_post($post_id);
		}
		if(empty($slider_id) or !isset($slider_id)){
			$slider_id = '1';
		}
		if(!empty($slider_id)){
			$slider_handle='testimonial_list_'.$slider_id;
			$data['slider_handle']=$slider_handle;
			$r_array = testimonial_carousel_posts_on_slider($testimonial_slider_curr['no_posts'], $offset, $slider_id, '0', $set, $data); 
			get_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data);
		} //end of not empty slider_id condition
	}
}
if(!function_exists('get_testimonial_list_category')){
	function get_testimonial_list_category($catg_slug='', $set='', $offset=0, $data=array() ) {
	    global $testimonial_slider,$default_testimonial_slider_settings; 
	 	$testimonial_slider_options='testimonial_slider_options'.$set;
	    $testimonial_slider_curr=get_option($testimonial_slider_options);
		if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
		foreach($default_testimonial_slider_settings as $key=>$value){
			if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
		}
	
		if( !$offset or empty($offset) or !is_numeric($offset)  ) {
			$offset=0;
		}
	
		$slider_handle='testimonial_list_'.$catg_slug;
		$data['slider_handle']=$slider_handle;
	    $r_array = testimonial_carousel_posts_on_slider_category($testimonial_slider_curr['no_posts'], $catg_slug, $offset, '0', $set, $data); 
		get_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data);
	} 
}
//Fetch all Testimonials
if(!function_exists('svilla_testimonial_list_processor')){
	function svilla_testimonial_list_processor($max_posts='10', $offset=0, $out_echo = '1', $set='', $data=array() ) {
	    global $testimonial_slider,$default_testimonial_slider_settings;
		$testimonial_slider_options='testimonial_slider_options'.$set;
	    $testimonial_slider_curr=get_option($testimonial_slider_options);
		if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
		foreach($default_testimonial_slider_settings as $key=>$value){
			if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
		}
	
		$posts = get_posts( array(
		'numberposts'     => $max_posts,
	    'offset'          => $offset,
	    'post_type'       => 'testimonial',
	    'post_status'     => 'publish'	)
		);
	
		$rand = $testimonial_slider_curr['rand'];
		if(isset($rand) and $rand=='1'){
		  shuffle($posts);
		}
	
		$r_array=testimonial_global_posts_processor( $posts, $testimonial_slider_curr, $out_echo,$set,$data );
		return $r_array;
	}
}
if(!function_exists('get_testimonial_list')){
	function get_testimonial_list( $max_posts='10', $set='', $offset=0, $data=array() ) {
		global $testimonial_slider,$default_testimonial_slider_settings; 
	 	$testimonial_slider_options='testimonial_slider_options'.$set;
	    $testimonial_slider_curr=get_option($testimonial_slider_options);
		if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
		foreach($default_testimonial_slider_settings as $key=>$value){
			if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
		}
	
		if( !$offset or empty($offset) or !is_numeric($offset)  ) {
			$offset=0;
		}
		$slider_handle='testimonial_list';
		$r_array = svilla_testimonial_list_processor($max_posts, $offset, '0', $set, $data);
		get_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data);
	} 
}
//Shortcodes
function return_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0'){
	$slider_html='';
	$slider_html=get_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo);
	return $slider_html;
}

function return_testimonial_list_custom($slider_id='',$set='',$offset=0) {
	global $testimonial_slider,$default_testimonial_slider_settings; 
 	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
 
	if($testimonial_slider['multiple_sliders'] == '1' and is_singular() and (empty($slider_id) or !isset($slider_id))){
		global $post;
		$post_id = $post->ID;
		$slider_id = get_testimonial_slider_for_the_post($post_id);
	}
	if(empty($slider_id) or !isset($slider_id))  $slider_id = '1';
	if( !$offset or empty($offset) or !is_numeric($offset)  ) $offset=0;
	$slider_handle='testimonial_list_'.$slider_id;
	$slider_html='';
	if(!empty($slider_id)){
		$r_array = testimonial_carousel_posts_on_slider($testimonial_slider_curr['no_posts'], $offset, $slider_id, $echo = '0', $set); 
		$slider_html=return_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0');
	} //end of not empty slider_id condition
	
	return $slider_html;
}

function testimonial_list_simple_shortcode($atts) {
	extract(shortcode_atts(array(
		'id' => '',
		'set' => '',
		'offset' => '',
	), $atts));

	return return_testimonial_list_custom($id,$set,$offset);
}
add_shortcode('testimonialCustomList', 'testimonial_list_simple_shortcode');

//Category shortcode
function return_testimonial_list_category($catg_slug='',$set='',$offset=0) {
	global $testimonial_slider,$default_testimonial_slider_settings; 
 	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
	
	if( !$offset or empty($offset) or !is_numeric($offset)  ) $offset=0;
    $r_array = testimonial_carousel_posts_on_slider_category($testimonial_slider_curr['no_posts'], $catg_slug, $offset, '0', $set); 
	$slider_handle='testimonial_list_'.$catg_slug;
	//get slider 
	$slider_html=return_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0');
	
	

	return $slider_html;
}

function testimonial_list_category_shortcode($atts) {
	extract(shortcode_atts(array(
		'catg_slug' => '',
		'set' => '',
		'offset' => '',
	), $atts));

	return return_testimonial_list_category($catg_slug,$set,$offset);
}
add_shortcode('testimonialListCategory', 'testimonial_list_category_shortcode');

//List all Testimonials Shortcode
function return_testimonial_list($max_posts='',$set='',$offset=0, $data=array()) {
	global $testimonial_slider,$default_testimonial_slider_settings; 
 	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
	
	if( !$offset or empty($offset) or !is_numeric($offset)  ) $offset=0;
	$r_array = svilla_testimonial_list_processor($max_posts, $offset, '0', $set, $data);
	$slider_handle='testimonial_list';
	
	//get slider 
	$slider_html=return_global_testimonial_list($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='0');
		
	return $slider_html;
}

function testimonial_list_shortcode($atts) {
	extract(shortcode_atts(array(
		'count' => '10',
		'set' => '',
		'offset' => '',
	), $atts));
	return return_testimonial_list($count,$set,$offset);
}

add_shortcode('testimonialList', 'testimonial_list_shortcode');
?>
