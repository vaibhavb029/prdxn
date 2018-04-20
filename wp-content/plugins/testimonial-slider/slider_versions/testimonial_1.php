<?php 
function testimonial_global_posts_processor( $posts, $testimonial_slider_curr,$out_echo,$set,$data=array() ){
	//If no Skin specified, consider Default
	$skin='default';
	if(isset($testimonial_slider_curr['stylesheet'])) $skin=$testimonial_slider_curr['stylesheet'];
	if(empty($skin))$skin='default';
	
	require_once ( dirname( dirname(__FILE__) ) . '/css/skins/'.$skin.'/functions.php');
	
	//Skin specific post processor and html generation
	$post_processor_fn='testimonial_post_processor_'.$skin;
	if(!function_exists($post_processor_fn))$post_processor_fn='testimonial_post_processor_default';
	$r_array=$post_processor_fn($posts, $testimonial_slider_curr,$out_echo,$set,$data);
	return $r_array;
}

function get_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data=array()){
	//If no Skin specified, consider Default
	$skin='default';
	if(isset($testimonial_slider_curr['stylesheet'])) $skin=$testimonial_slider_curr['stylesheet'];
	if(empty($skin))$skin='default';
	
	//Include CSS
	wp_enqueue_style( 'testimonial_'.$skin, testimonial_slider_plugin_url( 'css/skins/'.$skin.'/style.css' ),false,TESTIMONIAL_SLIDER_VER, 'all');
	wp_enqueue_style( 'dashicons' );
	require_once ( dirname( dirname(__FILE__) ) . '/css/skins/'.$skin.'/functions.php');
	
	//Skin specific post processor and html generation
	$get_processor_fn='testimonial_slider_get_'.$skin;
	if(!function_exists($get_processor_fn))$get_processor_fn='testimonial_slider_get_default';
	$r_array=$get_processor_fn($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo,$data);
	return $r_array;	
}

function testimonial_carousel_posts_on_slider($max_posts, $offset=0, $slider_id = '1',$out_echo = '1',$set='', $data=array() ) {
    global $testimonial_slider,$default_testimonial_slider_settings;
	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
	
	global $wpdb, $table_prefix;
	$table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
	$post_table = $table_prefix."posts";
	$rand = $testimonial_slider_curr['rand'];
	if(isset($rand) and $rand=='1'){
	  $orderby = 'RAND()';
	}
	else {
	  $orderby = 'a.slide_order ASC, a.date DESC';
	}
	
	$posts = $wpdb->get_results("SELECT * FROM 
	                             $table_name a LEFT OUTER JOIN $post_table b 
								 ON a.post_id = b.ID 
								 WHERE ( b.post_status = 'publish' AND b.post_type='testimonial' ) AND a.slider_id = '$slider_id' 
	                             ORDER BY ".$orderby." LIMIT $offset, $max_posts", OBJECT);

	$r_array=testimonial_global_posts_processor( $posts, $testimonial_slider_curr, $out_echo,$set , $data );
	return $r_array;
}
if(!function_exists('get_testimonial_slider')){
	function get_testimonial_slider($slider_id='',$set='',$offset=0, $data=array() ) { 
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
			$data['slider_id']=$slider_id; // Added for title
			$slider_handle='testimonial_slider_'.$slider_id;
			$data['slider_handle']=$slider_handle;
			$r_array = testimonial_carousel_posts_on_slider($testimonial_slider_curr['no_posts'], $offset, $slider_id, '0', $set, $data); 
			get_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data);
		} //end of not empty slider_id condition
	}
}

//For displaying category specific posts in chronologically reverse order
// added Date array , => $data=array()
function testimonial_carousel_posts_on_slider_category($max_posts='5', $catg_slug='', $offset=0, $out_echo = '1', $set='', $data=array()) {
    global $testimonial_slider,$default_testimonial_slider_settings;
	$testimonial_slider_options='testimonial_slider_options'.$set;
    $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
	
	global $wpdb, $table_prefix;
	
	$rand = $testimonial_slider_curr['rand'];
	if(isset($rand) and $rand=='1'){
	  $orderby = 'rand';
	}
	else {
	  $orderby = 'post_date';
	}
	
	$posts = get_posts( array(
	'numberposts'     => $max_posts,
    'offset'          => $offset,
	'orderby'		  => $orderby,
    'post_type'       => 'testimonial',
    'post_status'     => 'publish',
	'tax_query' => array(
			array(
				'taxonomy' => 'testimonial_category',
				'field' => 'slug',
				'terms' => $catg_slug
			)
		)
	)
	);
	
	$r_array=testimonial_global_posts_processor( $posts, $testimonial_slider_curr, $out_echo,$set,$data );
	return $r_array;
}
if(!function_exists('get_testimonial_slider_category')){
	function get_testimonial_slider_category($catg_slug='', $set='', $offset=0, $data=array() ) {
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
		if(empty($slider_id) or !isset($slider_id)){
			$slider_id = '1';
		}
		if(!empty($slider_id)){
			$data['slider_id']=$slider_id; // Added for title
		}
		$slider_handle='testimonial_slider_'.$catg_slug;
		$data['slider_handle']=$slider_handle;
	    	$r_array = testimonial_carousel_posts_on_slider_category($testimonial_slider_curr['no_posts'], $catg_slug, $offset, '0', $set, $data); 
		get_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data);
	} 
}

//For displaying recent posts in chronologically reverse order
function testimonial_carousel_posts_on_slider_recent($max_posts='5', $offset=0, $out_echo = '1', $set='', $data=array() ) {
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
if(!function_exists('get_testimonial_slider_recent')){
	function get_testimonial_slider_recent($set='', $offset=0, $data=array() ) { 
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
	
		$slider_handle='testimonial_slider_recent';
		$r_array = testimonial_carousel_posts_on_slider_recent($testimonial_slider_curr['no_posts'], $offset, '0', $set, $data);
		get_global_testimonial_slider($slider_handle,$r_array,$testimonial_slider_curr,$set,$echo='1',$data);
	} 
}

require_once (dirname (__FILE__) . '/shortcodes_1.php');
require_once (dirname (__FILE__) . '/widgets_1.php');

function testimonial_slider_enqueue_scripts() {
	wp_enqueue_script( 'jquery');
}

add_action( 'init', 'testimonial_slider_enqueue_scripts' );

//admin settings
function testimonial_slider_admin_scripts() {
global $testimonial_slider;
  if ( is_admin() ){ // admin actions
  // Settings page only
	if ( isset($_GET['page']) && ('testimonial-slider-admin' == $_GET['page'] or 'testimonial-slider-settings' == $_GET['page'] )  ) {
	wp_register_script('jquery', false, false, false, false);
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'testimonial_slider_admin_js', testimonial_slider_plugin_url( 'js/admin.js' ),
		array('jquery'), TESTIMONIAL_SLIDER_VER, false);
	wp_enqueue_style( 'testimonial_slider_admin_css', testimonial_slider_plugin_url( 'css/admin.css' ),
		false, TESTIMONIAL_SLIDER_VER, 'all');
	wp_enqueue_script( 'testimonial', testimonial_slider_plugin_url( 'js/testimonial.js' ),
		array('jquery'), TESTIMONIAL_SLIDER_VER, false);
	wp_enqueue_script( 'easing', testimonial_slider_plugin_url( 'js/jquery.easing.js' ),
		false, TESTIMONIAL_SLIDER_VER, false);  
	wp_enqueue_script( 'jquery.bpopup.min', testimonial_slider_plugin_url( 'js/jquery.bpopup.min.js' ),'', TESTIMONIAL_SLIDER_VER, false);
	}
  }
}

add_action( 'admin_init', 'testimonial_slider_admin_scripts' );

function testimonial_slider_admin_head() {
global $testimonial_slider;
if ( is_admin() ){ // admin actions
   
// Sliders & Settings page only
    if ( isset($_GET['page']) && ('testimonial-slider-admin' == $_GET['page'] or 'testimonial-slider-settings' == $_GET['page']) ) {
	  $sliders = testimonial_ss_get_sliders(); 
		global $testimonial_slider;
		$cntr='';
		if(isset($_GET['scounter'])) $cntr = $_GET['scounter'];
		$testimonial_slider_options='testimonial_slider_options'.$cntr;
		$testimonial_slider_curr=get_option($testimonial_slider_options);
		$active_tab=(isset($testimonial_slider_curr['active_tab']))?$testimonial_slider_curr['active_tab']:0;
		if ( isset($_GET['page']) && ('testimonial-slider-admin' == $_GET['page']) && isset($_POST['active_tab']) ) $active_tab=$_POST['active_tab'];
	?>
		<script type="text/javascript">
            // <![CDATA[
        jQuery(document).ready(function() {
                jQuery(function() {
					jQuery("#slider_tabs").tabs({fx: { opacity: "toggle", duration: 300}, active: <?php echo $active_tab;?> }).addClass( "ui-tabs-vertical-left ui-helper-clearfix" );jQuery( "#slider_tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
				<?php 	if ( isset($_GET['page']) && (( 'testimonial-slider-settings' == $_GET['page']) or ('testimonial-slider-admin' == $_GET['page']) ) ) { ?>
					jQuery( "#slider_tabs" ).on( "tabsactivate", function( event, ui ) { jQuery( "#testimonial_activetab, .testimonial_activetab" ).val( jQuery( "#slider_tabs" ).tabs( "option", "active" ) ); });
				<?php 	}
				foreach($sliders as $slider){ ?>
                    jQuery("#sslider_sortable_<?php echo $slider['slider_id'];?>").sortable();
                    jQuery("#sslider_sortable_<?php echo $slider['slider_id'];?>").disableSelection();
			    <?php } ?>
                });
        });
		
        function confirmRemove()
        {
            var agree=confirm("This will remove selected Posts/Pages from Slider.");
            if (agree)
            return true ;
            else
            return false ;
        }
        function confirmRemoveAll()
        {
            var agree=confirm("Remove all Posts/Pages from Testimonial Slider??");
            if (agree)
            return true ;
            else
            return false ;
        }
        function confirmSliderDelete()
        {
            var agree=confirm("Delete this Slider??");
            if (agree)
            return true ;
            else
            return false ;
        }
        function slider_checkform ( form )
        {
          if (form.new_slider_name.value == "") {
            alert( "Please enter the New Slider name." );
            form.new_slider_name.focus();
            return false ;
          }
          return true ;
        }
        </script>
<?php
   } //Sliders page only
   
   // Settings page only
  if ( isset($_GET['page']) && 'testimonial-slider-settings' == $_GET['page']  ) {
		wp_enqueue_style( 'wp-color-picker' );
   		wp_enqueue_script( 'wp-color-picker' );
?>
<script type="text/javascript">
	// <![CDATA[
jQuery(document).ready(function() {
	jQuery('.wp-color-picker-field').wpColorPicker();
});
function confirmSettingsCreate()
        {
            var agree=confirm("Create New Settings Set??");
            if (agree)
            return true ;
            else
            return false ;
}
function confirmSettingsDelete()
        {
            var agree=confirm("Delete this Settings Set??");
            if (agree)
            return true ;
            else
            return false ;
}
</script>
<style type="text/css">
.color-picker-wrap {
		position: absolute;
 		display: none; 
		background: #fff;
		border: 3px solid #ccc;
		padding: 3px;
		z-index: 1000;
	}
</style>
<?php
   } //for testimonial slider option page
 }//only for admin
//Below css will add the menu icon for Dbox Slider admin menu
?>
<style type="text/css">#adminmenu #toplevel_page_testimonial-slider-admin div.wp-menu-image:before { content: "\f233"; }</style>
<?php
}
add_action('admin_head', 'testimonial_slider_admin_head');

//get inline css with style attribute attached
function testimonial_get_inline_css($set='',$echo='0'){
   	global $testimonial_slider,$default_testimonial_slider_settings;
	$testimonial_slider_options='testimonial_slider_options'.$set;
   	 $testimonial_slider_curr=get_option($testimonial_slider_options);
	if(!isset($testimonial_slider_curr) or !is_array($testimonial_slider_curr) or empty($testimonial_slider_curr)){$testimonial_slider_curr=$testimonial_slider;$set='';}
	
	foreach($default_testimonial_slider_settings as $key=>$value){
		if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
	}
	
	$testimonial_slider_css=array();
	
	$style_start= ($echo=='0') ? 'style="':'';
	$style_end= ($echo=='0') ? '"':'';
	//testimonial_slider
	$total_width='';
	if(isset($testimonial_slider_curr['width']) and $testimonial_slider_curr['width']!=0) {
		$total_width='width:'. $testimonial_slider_curr['width'].'px;';
		$testimonial_slider_css['testimonial_slider']=$style_start.$total_width.$style_end;
	}
	else{
		$testimonial_slider_css['testimonial_slider']='';
	}
	//Added For Title sldr_title
	$title_fontg=isset($testimonial_slider_curr['title_fontg'])?trim($testimonial_slider_curr['title_fontg']):''; // 'Squada+One'
	if(!empty($title_fontg)) 	{
		wp_enqueue_style( 'testimonial_title', '//fonts.googleapis.com/css?family='.$title_fontg,array(),TESTIMONIAL_SLIDER_VER);
		$title_fontg=testimonial_get_google_font($title_fontg);
		$title_fontg=$title_fontg.',';
	}
	if ($testimonial_slider_curr['title_fstyle'] == "bold" or $testimonial_slider_curr['title_fstyle'] == "bold italic" ){$slider_title_font = "bold";} else { $slider_title_font = "normal"; }
	if ($testimonial_slider_curr['title_fstyle'] == "italic" or $testimonial_slider_curr['title_fstyle'] == "bold italic" ){$slider_title_style = "italic";} else {$slider_title_style = "normal";}
	$sldr_title = $testimonial_slider_curr['title_text']; if(!empty($sldr_title)) { $slider_title_margin = "5px 0 10px 0"; } else {$slider_title_margin = "0";} 	
	$testimonial_slider_css['sldr_title']=$style_start.'font-family:'. $title_fontg . ' '.$testimonial_slider_curr['title_font'].';font-size:'.$testimonial_slider_curr['title_fsize'].'px;font-weight:'.$slider_title_font.';font-style:'.$slider_title_style.';color:'.$testimonial_slider_curr['title_fcolor'].';margin:'.$slider_title_margin.''.$style_end;
	//testimonial_slideri
	if ($testimonial_slider_curr['bg'] == '1') { $testimonial_slideri_bg = "transparent";} else { $testimonial_slideri_bg = $testimonial_slider_curr['bg_color']; }
	$nav_color=$testimonial_slider_curr['nav_color'];
	// for Round Skin 	
	if($testimonial_slider_curr['stylesheet'] == 'round')
	{
		// For outer div css
		if($testimonial_slider_curr['img_width'] !='' && $testimonial_slider_curr['img_width'] > 0 ) {
			$margin = $testimonial_slider_curr['img_width']/2;
			$outer_wrap_margin = 'margin-left:'.$margin.'px;';
		} else $outer_wrap_margin= '';
		if($testimonial_slider_curr["border"]!='' && $testimonial_slider_curr["border"] > 0) {
			$outer_wrap_border = 'border:'.$testimonial_slider_curr["border"].'px solid '.$testimonial_slider_curr["brcolor"].';';
		} else $outer_wrap_border ='border:0;';
		$testimonial_slider_css['testimonial_outer_wrap'] = $style_start.'background-color:'.$testimonial_slideri_bg.';'.$outer_wrap_border.$outer_wrap_margin.$style_end;
		 
		// For slideri
		$testimonial_slider_css['testimonial_slideri'] = $style_start.'width:'. $testimonial_slider_curr['iwidth'].'px;height:'. $testimonial_slider_curr['height'].'px;'.$style_end;
		
	}
	//For Oval Skin
	else if($testimonial_slider_curr['stylesheet'] == 'oval')
	{
		// For outer div css
		$testimonial_slider_css['testimonial_content_wrap'] = $style_start.'background-color:'.$testimonial_slideri_bg.';border:'.$testimonial_slider_curr['border'].'px dashed '.$testimonial_slider_curr['brcolor'].';'.$style_end;
		 
		// For slideri
		$testimonial_slider_css['testimonial_slideri'] = $style_start.'width:'. $testimonial_slider_curr['iwidth'].'px;height:'. $testimonial_slider_curr['height'].'px;'.$style_end;
		
	}
	//For textonly Skin
	else if($testimonial_slider_curr['stylesheet'] == 'textonly')
	{
		// For outer div css
		$testimonial_slider_css['testimonial_content_wrap'] = $style_start.'background-color:'.$testimonial_slideri_bg.';border:'.$testimonial_slider_curr['border'].'px solid '.$testimonial_slider_curr['brcolor'].';'.$style_end;
		 
		// For slideri
		$testimonial_slider_css['testimonial_slideri'] = $style_start.'width:'. $testimonial_slider_curr['iwidth'].'px;height:'. $testimonial_slider_curr['height'].'px;'.$style_end;
		
	}
	else
	{
	$testimonial_slider_css['testimonial_slideri']=$style_start.'background-color:'.$testimonial_slideri_bg.';border:'.$testimonial_slider_curr['border'].'px solid '.$testimonial_slider_curr['brcolor'].';width:'. $testimonial_slider_curr['iwidth'].'px;height:'. $testimonial_slider_curr['height'].'px;'.$style_end;
	}
	
	// Star Rating
	$testimonial_slider_css['dashicons-star-filled']=$style_start.'color:'.$testimonial_slider_curr['star_color'].';font-size:'. $testimonial_slider_curr['star_size'].'px;width:'. $testimonial_slider_curr['star_size'].'px;'.$style_end;
	// Image Radius
	if($testimonial_slider_curr['avatar_radius'] != 0 && $testimonial_slider_curr['avatar_shape'] == "circle")
	$testimonial_slider_css['testimonial_avatar_img']=$style_start.'max-height:'.$testimonial_slider_curr['img_height'].'px;width:'.$testimonial_slider_curr['img_width'].'px;border:'.$testimonial_slider_curr['img_border'].'px solid '.$testimonial_slider_curr['img_brcolor'].';border-radius:'.$testimonial_slider_curr['avatar_radius'].'%;'.$style_end;
	else
	$testimonial_slider_css['testimonial_avatar_img']=$style_start.'max-height:'.$testimonial_slider_curr['img_height'].'px;width:'.$testimonial_slider_curr['img_width'].'px;border:'.$testimonial_slider_curr['img_border'].'px solid '.$testimonial_slider_curr['img_brcolor'].';'.$style_end;
	// Image testimonial_avatar_wrap css
	$outerImgWidth = $testimonial_slider_curr['img_width'] + 10;	
	$testimonial_slider_css['testimonial_avatar_wrap']=$style_start.'width:'. $outerImgWidth.'px;'.$style_end;
	// For Image of round and minimal
	if($testimonial_slider_curr['stylesheet'] == 'round') {
		$mLeft = $testimonial_slider_curr['img_width'] - ($testimonial_slider_curr['img_width'] / 2);
		if($testimonial_slider_curr['avatar_shape'] == "square")
	$testimonial_slider_css['testimonial_avatar_img']=$style_start.'max-height:'.$testimonial_slider_curr['img_height'].'px;width:'.$testimonial_slider_curr['img_width'].'px;border:'.$testimonial_slider_curr['img_border'].'px solid '.$testimonial_slider_curr['img_brcolor'].';border-radius: 0%;margin-left:'.$mLeft.$style_end;
		else 
			$testimonial_slider_css['testimonial_avatar_img']=$style_start.'height:'.$testimonial_slider_curr['img_height'].'px;width:'.$testimonial_slider_curr['img_width'].'px;border:'.$testimonial_slider_curr['img_border'].'px solid '.$testimonial_slider_curr['img_brcolor'].';border-radius: '.$testimonial_slider_curr['avatar_radius'].'%;margin-left: -'.$mLeft.'px;'.$style_end;
	}
	if($testimonial_slider_curr['stylesheet'] == 'minimal') {
		if($testimonial_slider_curr['avatar_shape'] == "square")
	$testimonial_slider_css['testimonial_avatar_img']=$style_start.'max-height:'.$testimonial_slider_curr['img_height'].'px;width:'.$testimonial_slider_curr['img_width'].'px;border:'.$testimonial_slider_curr['img_border'].'px solid '.$testimonial_slider_curr['img_brcolor'].';border-radius: 0%;'.$style_end;
	}
	if ($testimonial_slider_curr['ptitle_fstyle'] == "bold" or $testimonial_slider_curr['ptitle_fstyle'] == "bold italic" ){$ptitle_fweight = "bold";} else {$ptitle_fweight = "normal";}
	if ($testimonial_slider_curr['ptitle_fstyle'] == "italic" or $testimonial_slider_curr['ptitle_fstyle'] == "bold italic"){$ptitle_fstyle = "italic";} else {$ptitle_fstyle = "normal";}
	$testimonial_slider_css['testimonial_by']=$style_start.'line-height:'. ($testimonial_slider_curr['ptitle_fsize'] + 3) .'px;font-family:'. $testimonial_slider_curr['ptitle_font'].';font-size:'.$testimonial_slider_curr['ptitle_fsize'].'px;font-weight:'.$ptitle_fweight.';font-style:'.$ptitle_fstyle.';color:'.$testimonial_slider_curr['ptitle_fcolor'].';'.$style_end;
	
	if ($testimonial_slider_curr['psite_fstyle'] == "bold" or $testimonial_slider_curr['psite_fstyle'] == "bold italic" ){$psite_fweight = "bold";} else {$psite_fweight = "normal";}
	if ($testimonial_slider_curr['psite_fstyle'] == "italic" or $testimonial_slider_curr['psite_fstyle'] == "bold italic"){$psite_fstyle = "italic";} else {$psite_fstyle = "normal";}
	$testimonial_slider_css['testimonial_site_a']=$style_start.'line-height:'. ($testimonial_slider_curr['psite_fsize'] + 3) .'px;font-family:'. $testimonial_slider_curr['psite_font'].';font-size:'.$testimonial_slider_curr['psite_fsize'].'px;font-weight:'.$psite_fweight.';font-style:'.$psite_fstyle.';color:'.$testimonial_slider_curr['psite_fcolor'].';'.$style_end;
	if($testimonial_slider_curr['stylesheet'] == 'default' || $testimonial_slider_curr['stylesheet'] == 'minimal')
	{
	$quote_bg_url='css/skins/'.$testimonial_slider_curr['stylesheet'].'/buttons/'.$testimonial_slider_curr['buttons'].'/quote.png';
	$background = 'background:url('.testimonial_slider_plugin_url( $quote_bg_url ) .') left top no-repeat;';
	} else { $quote_bg_url=''; $background='';}
	if ($testimonial_slider_curr['content_fstyle'] == "bold" or $testimonial_slider_curr['content_fstyle'] == "bold italic" ){$content_fweight= "bold";} else {$content_fweight= "normal";}
	if ($testimonial_slider_curr['content_fstyle']=="italic" or $testimonial_slider_curr['content_fstyle'] == "bold italic"){$content_fstyle= "italic";} else {$content_fstyle= "normal";}
	$testimonial_slider_css['testimonial_quote']=$style_start.$background.'font-family:'.$testimonial_slider_curr['content_font'].';font-size:'.$testimonial_slider_curr['content_fsize'].'px;font-weight:'.$content_fweight.';font-style:'.$content_fstyle.';color:'. $testimonial_slider_curr['content_fcolor'].';'.$style_end;
	if($testimonial_slider_curr['show_avatar'] == '0') {
		$testimonial_slider_css['testimonial_avatar']=$style_start.'display: none;'.$style_end;
	}
	else {
		$testimonial_slider_css['testimonial_avatar']='';
	}
	//testimonial_nav_a
	if($testimonial_slider_curr['stylesheet'] != 'default')
	{
		$nav_bg = '';	
	}
	else {
		$button_url='css/skins/'.$testimonial_slider_curr['stylesheet'].'/buttons/'.$testimonial_slider_curr['buttons'].'/nav.png';
		$nav_bg = 'background: transparent url('.testimonial_slider_plugin_url( $button_url ) .') no-repeat;';
	}
	$testimonial_slider_css['testimonial_nav_a']=$style_start.$nav_bg.'width:'.$testimonial_slider_curr['navimg_w'].'px;height:'.$testimonial_slider_curr['navimg_h'].'px;'.$style_end;
	// More Text
	$testimonial_slider_css['testimonial_slider_p_more']='';
	
	if($testimonial_slider_curr['prev_next'] == 0 ) {
	if($testimonial_slider_curr['navnum']=='2'){
			$top_arrow='top:10%;';
		}		
		else{
			$top_arrow='';
		}
	//testimonial_next
	$nexturl='css/skins/'.$testimonial_slider['stylesheet'].'/buttons/'.$testimonial_slider_curr['buttons'].'/next.png';
	$testimonial_slider_css['testimonial_next']=$style_start.'background: transparent url('.testimonial_slider_plugin_url( $nexturl ) .') no-repeat 0 0;'.$top_arrow.$style_end;
	}
	else $testimonial_slider_css['testimonial_next']= "";
	if($testimonial_slider_curr['prev_next'] == 0 ) {
	//testimonial_prev
	$prevurl='css/skins/'.$testimonial_slider['stylesheet'].'/buttons/'.$testimonial_slider_curr['buttons'].'/prev.png';
	$testimonial_slider_css['testimonial_prev']=$style_start.'background: transparent url('.testimonial_slider_plugin_url( $prevurl ) .') no-repeat 0 0;'.$top_arrow.$style_end;
	}
	/*
		Add This For Arrow Dynamic size 
		width: '.$testimonial_slider_curr['navimg_w'].'px;height: '.$testimonial_slider_curr['navimg_h'].'px;background-size: '.$testimonial_slider_curr['navimg_w'].'px;
	*/
	else $testimonial_slider_css['testimonial_prev']= "";
	//currently empty values
	$testimonial_slider_css['testimonial_by_wrap']='';
	
	$testimonial_slider_css['testimonial_slider_span']='';
	$testimonial_slider_css['testimonial_nav']='';

	return $testimonial_slider_css;
}

function testimonial_slider_css() {
global $testimonial_slider;
$css=$testimonial_slider['css'];
if($css and !empty($css)){?>
 <style type="text/css"><?php echo $css;?></style>
<?php }
}
add_action('wp_head', 'testimonial_slider_css');
add_action('admin_head', 'testimonial_slider_css');
?>
