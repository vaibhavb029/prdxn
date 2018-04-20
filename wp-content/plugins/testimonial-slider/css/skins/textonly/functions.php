<?php 
function testimonial_post_processor_textonly( $posts, $testimonial_slider_curr,$out_echo,$set,$data=array() ){
	$skin='textonly';
	global $testimonial_slider,$default_testimonial_slider_settings;
	$testimonial_slider_css = testimonial_get_inline_css($set);
	$html = '';
	$testimonial_sldr_j = 0;
	
	$slider_handle='';
	if ( is_array($data) and isset($data['slider_handle']) ) {
		$slider_handle=$data['slider_handle'];
	}
	
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
	
	foreach($posts as $post) {
		$id = $post->ID;	
		$post_id = $post->ID;
		$testimonial_by_wrap=$testimonial_quote='';
		
		$slider_content = $post->post_content;
		
		$testimonial_slide_redirect_url = get_post_meta($post_id, 'testimonial_slide_redirect_url', true);
		$_testimonial_sslider_nolink = get_post_meta($post_id,'_testimonial_sslider_nolink',true);
		trim($testimonial_slide_redirect_url);
		if(!empty($testimonial_slide_redirect_url) and isset($testimonial_slide_redirect_url)) {
		   $permalink = $testimonial_slide_redirect_url;
		}
		else{
		   $permalink = get_permalink($post_id);
		}
		if($_testimonial_sslider_nolink=='1'){
		  $permalink='';
		}
			
		$testimonial_sldr_j++;
		
		//Slide link anchor attributes
		$a_attr='';
		$a_attr=get_post_meta($post_id,'testimonial_link_attr',true);
		if( empty($a_attr) and isset( $testimonial_slider_curr['a_attr'] ) ) $a_attr=$testimonial_slider_curr['a_attr'];
		
		$html .= '<div class="testimonial_slideri" '.$testimonial_slider_css['testimonial_slideri'].'>
			<!-- testimonial_slideri -->';

		//Testimonial by
		$_testimonial_by=get_post_meta($post_id, '_testimonial_by', true);
		
		$_testimonial_avatar=get_post_meta($post_id, '_testimonial_avatar', true);
		if( empty($_testimonial_avatar) and isset( $testimonial_slider_curr['default_avatar'] ) ) $_testimonial_avatar=$testimonial_slider_curr['default_avatar'];
		
		$_testimonial_site=get_post_meta($post_id, '_testimonial_site', true);
		$_testimonial_siteurl=get_post_meta($post_id, '_testimonial_siteurl', true);
		if(empty($_testimonial_siteurl)) $testimonial_company=$_testimonial_site;
		else $testimonial_company='<a href="'.$_testimonial_siteurl.'" '.$a_attr.' '.$testimonial_slider_css['testimonial_site_a'].'>'.$_testimonial_site.'</a>';
		
		$testimonial_by_wrap='<div class="testimonial_by_wrap" '.$testimonial_slider_css['testimonial_by_wrap'].'><div class="testimonial_by_inner"><span class="testimonial_by" '.$testimonial_slider_css['testimonial_by'].'>'.$_testimonial_by.'</span><span class="testimonial_site" '.$testimonial_slider_css['testimonial_site_a'].'>'.$testimonial_company.'</span></div></div>';
		
		$content_limit=$testimonial_slider_curr['content_limit'];
		if(!empty($content_limit)){ 
			$slider_excerpt = testimonial_slider_word_limiter( $slider_content, $limit = $content_limit);
		}
		else { $slider_excerpt=$slider_content; }
		//filter hook
		$slider_excerpt=apply_filters('testimonial_slide_excerpt',$slider_excerpt,$post_id,$testimonial_slider_curr,$testimonial_slider_css,$skin);
		$slider_excerpt='<span '.$testimonial_slider_css['testimonial_slider_span'].'> '.$slider_excerpt.'</span>';

		//filter hook
		$slider_excerpt=apply_filters('testimonial_slide_excerpt_html',$slider_excerpt,$post_id,$testimonial_slider_curr,$testimonial_slider_css,$skin);
		
		$read_more='';
		if($testimonial_slider_curr['more'] and $testimonial_slider_curr['more']!='' and $permalink!=''){
			$read_more='<p class="more"><a href="'.$permalink.'" '.$testimonial_slider_css['testimonial_slider_p_more'].' '.$a_attr.'>'.$testimonial_slider_curr['more'].'</a></p>';
		}
	
		$testimonial_quote='<div class="testimonial_content_wrap" '.$testimonial_slider_css['testimonial_content_wrap'].'><div class="testimonial_content" '.$testimonial_slider_css['testimonial_quote'].'>'.$slider_excerpt.$read_more;
		// Star Rating
		$_testimonial_star=get_post_meta($post_id, '_testimonial_star', true);
		if(isset($testimonial_slider_curr['show_star']) && $testimonial_slider_curr['show_star'] == 1 && $_testimonial_star != '' && $_testimonial_star > 0 ) {
			$testimonial_quote.="<div class='testimonial-star-outer'>";
			for($i = 0; $i < $_testimonial_star; $i++ ) {
				$testimonial_quote.="<div class='dashicons dashicons-star-filled' ".$testimonial_slider_css['dashicons-star-filled']." ></div>";
			}
			$testimonial_quote.="</div>";
		}
		$testimonial_quote.="</div></div>";
		$html .= $testimonial_quote.$testimonial_by_wrap;
		$html .= '	<div class="sldr_clearlt"></div><div class="sldr_clearrt"></div><!-- /testimonial_slideri -->
		</div>'; 
	}
	
	$html=apply_filters('testimonial_extract_html',$html,$testimonial_sldr_j,$posts,$testimonial_slider_curr,$skin);
	
	if($out_echo == '1') {
	   echo $html;
	}
	$r_array = array( $testimonial_sldr_j, $html);
	$r_array=apply_filters('testimonial_r_array',$r_array,$posts, $testimonial_slider_curr,$set,$skin);
	return $r_array;
}
function testimonial_slider_get_textonly($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data=array()){
	$skin='textonly';
	global $testimonial_slider,$default_testimonial_slider_settings;
	$testimonial_sldr_j = $r_array[0];
	$testimonial_slider_css = testimonial_get_inline_css($set); 
	$slider_html='';
	$navwidth = ($testimonial_sldr_j*$testimonial_slider_curr['navimg_w']) + ($testimonial_sldr_j * 5) ;
	$testimonial_slider_css['testimonial_nav'] = 'style="width:'.$navwidth.'px;margin: 0 auto;"';
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
	/*  Added For Title  */
	$slider_id='';
	if (isset ($data['slider_id'])) {
		if( is_array($data)) $slider_id=$data['slider_id'];
	}
	if ( is_array($data) && isset($data['title'])){
		if($data['title']!='' )$sldr_title=$data['title'];
		else {
			if($testimonial_slider_curr['title_from']=='1' && !empty($slider_id) ) $sldr_title = get_testimonial_slider_name($slider_id);
			else $sldr_title = $testimonial_slider_curr['title_text'];
		}
	}
	else{
		if( $testimonial_slider_curr['title_from']=='1' && !empty($slider_id) ) $sldr_title = get_testimonial_slider_name($slider_id);
		else $sldr_title = $testimonial_slider_curr['title_text']; 
	} 
	if(!empty($sldr_title)) { 
	  $sldr_title = '<div class="sldr_title" '.$testimonial_slider_css['sldr_title'].'>'. $sldr_title .'</div>';
	}
	/*---- End Slider Title----*/
	// Scripts
	wp_enqueue_script( 'testimonial', testimonial_slider_plugin_url( 'js/testimonial.js' ),
		array('jquery'), TESTIMONIAL_SLIDER_VER, false);
	wp_enqueue_script( 'easing', testimonial_slider_plugin_url( 'js/jquery.easing.js' ),
		false, TESTIMONIAL_SLIDER_VER, false);
	wp_enqueue_script( 'jquery.touchwipe', testimonial_slider_plugin_url( 'js/jquery.touchwipe.js' ),
		array('jquery'), TESTIMONIAL_SLIDER_VER, false);
	
	$testimonial_media_queries='';
	$o_visible=$testimonial_slider_curr['visible'];$o_responsive='';$o_width='';
	$responsive_max_width=($testimonial_slider_curr['width']>0)?( $testimonial_slider_curr['width'].'px'  ) : ( '100%' );
    
		$testimonial_media_queries='.testimonial_slider_set'.$set.'.testimonial_slider{width:100% !important;max-width:'.$responsive_max_width.';display:block;}.testimonial_slider_set'.$set.' img{max-width:90% !important;}.testimonial_side{width:100% !important;}';
		//filter hook
		$testimonial_media_queries=apply_filters('testimonial_media_queries',$testimonial_media_queries,$testimonial_slider_curr,$set,$skin);
		$o_visible='{	min: 1,	max: '.$testimonial_slider_curr['visible'] .'}';
		$o_responsive='responsive: true,';
		$o_width='width: '.$testimonial_slider_curr['iwidth'].',';
	
	
	if(!isset($testimonial_slider_curr['fouc']) or $testimonial_slider_curr['fouc']=='' or $testimonial_slider_curr['fouc']=='0' ){
		$fouc_dom='jQuery("html").addClass("testimonial_slider_fouc");jQuery(".testimonial_slider_fouc .testimonial_slider_set'.$set.'").hide();';
		$fouc_ready='jQuery(document).ready(function() {
		   jQuery(".testimonial_slider_fouc .testimonial_slider_set'.$set.'").show();
		});';
    }	
	else{
	    $fouc_dom='';$fouc_ready='';
	}		
	if ($testimonial_slider_curr['disable_autostep'] == '1'){ $autostep = "false"; } else { $autostep = $testimonial_slider_curr['time'] * 100; }
	$prevnext='';
	if ($testimonial_slider_curr['prev_next'] != 1){ 
	  $prevnext='next:   "#'.$slider_handle.'_next", 
				 prev:   "#'.$slider_handle.'_prev",';
	}
	$type='';
	if ($testimonial_slider_curr['type'] == "1"){
		$type='circular:false,
					infinite:false,';
	}
	
	$pagination=$nav_top=$nav_bottom='';
	if ($testimonial_slider_curr['navnum'] == "1"){ 
		$nav_top='';
		$nav_bottom='<div id="'.$slider_handle.'_nav" class="testimonial_nav  testimonial_nav-fillup" '.$testimonial_slider_css['testimonial_nav'].'></div>';
		$pagination='pagination  : { container: "#'.$slider_handle.'_nav",
			anchorBuilder: function( nr ) {
				return \'<div class="inner_nav" '.$testimonial_slider_css['testimonial_nav_a'].'><a href="#" ></a></div>\';
			} },';
    } 
	if ($testimonial_slider_curr['navnum'] == "2"){ 
		$nav_top='<div id="'.$slider_handle.'_nav" class="testimonial_nav testimonial_nav-fillup" '.$testimonial_slider_css['testimonial_nav'].'></div>';
		$nav_bottom='';
		$pagination='pagination  : { container: "#'.$slider_handle.'_nav",
			anchorBuilder: function( nr ) {
				return \'<div class="inner_nav" '.$testimonial_slider_css['testimonial_nav_a'].'><a href="#" ></a></div>\';
			} },';
    } 
	if ($testimonial_slider_curr['bg'] == '1') { $testimonial_slideri_bg = "transparent";} else { $testimonial_slideri_bg = $testimonial_slider_curr['bg_color']; }
	$nav_color=$testimonial_slider_curr['nav_color'];
	$script='<script type="text/javascript"> '.$fouc_ready;
	if(!empty($testimonial_media_queries)){
			$script.='jQuery(document).ready(function() {jQuery("head").append("<style type=\"text/css\">'. $testimonial_media_queries .'</style>");});';
	}
	$script.='jQuery(document).ready(function() {
			jQuery("#'.$slider_handle.'").testiMonial({
				'.$o_responsive.'
				items: 	{
					'.$o_width.'
					visible     : '.$o_visible.'
				},
				'.$pagination.'
				auto: '.$autostep.','.$type.' '.$prevnext.'
				scroll: {
						items:'.$testimonial_slider_curr['scroll'].',
						fx: "'.$testimonial_slider_curr['transition'].'",
						easing: "'. $testimonial_slider_curr['easing'].'",
						duration: '.$testimonial_slider_curr['speed'] * 100 .',
						pauseOnHover: true
					}
			});
			jQuery("head").append("<style type=\"text/css\">#'.$slider_handle.'_nav a.selected{background-position:-'.$testimonial_slider_curr['navimg_w'].'px 0 !important;}.testimonial_slider__textonly .testimonial_content_wrap:after {border-top-color: '.$testimonial_slideri_bg.'!important;} .testimonial_slider__textonly .testimonial_nav-fillup .inner_nav a { border: 2px solid '.$nav_color.' !important;}.testimonial_slider__textonly .testimonial_nav-fillup .inner_nav.selected a:after { background-color: '.$nav_color.' !important; }</style>");
			jQuery("#'.$slider_handle.'_wrap").hover( 
				function() { jQuery(this).find(".testimonial_nav_arrow_wrap").show();}, 
				function() { jQuery(this).find(".testimonial_nav_arrow_wrap").hide();} );
			jQuery("#'.$slider_handle.'").touchwipe({
					wipeLeft: function() {
						jQuery("#'.$slider_handle.'").trigger("next", 1);
					},
					wipeRight: function() {
						jQuery("#'.$slider_handle.'").trigger("prev", 1);
					},
					preventDefaultEvents: false
			});				
		});';
	//action hook
	do_action('testimonial_global_script',$slider_handle,$testimonial_slider_curr);
	$script.='</script>';
	
	$stylesheet=$testimonial_slider_curr['stylesheet'];
	if(empty($stylesheet)) $stylesheet = 'default';
	
	$slider_html.=$script.' 
	<noscript><p><strong>'. $testimonial_slider['noscript'] .'</strong></p></noscript>
	<div id="'.$slider_handle.'_wrap" class="testimonial_slider testimonial_slider_set'. $set .' testimonial_slider__'.$stylesheet.'" '.$testimonial_slider_css['testimonial_slider'].'>
		'.$sldr_title.$nav_top.'
		<div id="'.$slider_handle.'" class="testimonial_slider_instance">
			'. $r_array[1] .'
		</div>
		'.$nav_bottom.'
		<div class="testimonial_nav_arrow_wrap">
			<a class="testimonial_prev" id="'.$slider_handle.'_prev" href="#" '.$testimonial_slider_css['testimonial_prev'].'><span>prev</span></a>
			<a class="testimonial_next" id="'.$slider_handle.'_next" href="#" '.$testimonial_slider_css['testimonial_next'].'><span>next</span></a>
		</div>
	</div>';
	$slider_html.='<script type="text/javascript">'.$fouc_dom.'</script>';
	$line_breaks = array("\r\n", "\n", "\r");
	$slider_html = str_replace($line_breaks, "", $slider_html);
	if($echo == '1')  {echo $slider_html; }
	else { return $slider_html; }	
}
?>
