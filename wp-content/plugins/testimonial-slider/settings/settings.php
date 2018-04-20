<?php // Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'testimonial_slider_settings');
  add_action( 'admin_init', 'register_testimonial_settings' ); 
} 

//Create Set & Export Settings
function testimonial_process_set_requests(){
	global $default_testimonial_slider_settings;
	$scounter=get_option('testimonial_slider_scounter');
	
	$cntr='';
	if(isset($_GET['scounter'])) $cntr = $_GET['scounter'];
	
	if(isset($_POST['create_set'])){
		if ($_POST['create_set']=='Create New Settings Set') {
		  $scounter++;
		  update_option('testimonial_slider_scounter',$scounter);
		  $options='testimonial_slider_options'.$scounter;
		  update_option($options,$default_testimonial_slider_settings);
		  $current_url = admin_url('admin.php?page=testimonial-slider-settings');
		  $current_url = add_query_arg('scounter',$scounter,$current_url);
		  wp_redirect( $current_url );
		  exit;
		}
	}

	//Export Settings
	if(isset($_POST['export'])){
		if ($_POST['export']=='Export') {
			@ob_end_clean();
			
			// required for IE, otherwise Content-Disposition may be ignored
			if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');
			
			header('Content-Type: ' . "text/x-csv");
			header('Content-Disposition: attachment; filename="testimonial-settings-set-'.$cntr.'.csv"');
			header("Content-Transfer-Encoding: binary");
			header('Accept-Ranges: bytes');

			/* The three lines below basically make the
			download non-cacheable */
			header("Cache-control: private");
			header('Pragma: private');
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

			$exportTXT='';$i=0;
			$slider_options='testimonial_slider_options'.$cntr;
			$slider_curr=get_option($slider_options);
			foreach($slider_curr as $key=>$value){
				if($i>0) $exportTXT.="\n";
				if(!is_array($value)){
					$exportTXT.=$key.",".$value;
				}
				else {
					$exportTXT.=$key.',';
					$j=0;
					if($value) {
						foreach($value as $v){
							if($j>0) $exportTXT.="|";
							$exportTXT.=$v;
							$j++;
						}
					}
				}
				$i++;
			}
			$exportTXT.="\n";
			$exportTXT.="slider_name,testimonial";
			print($exportTXT); 
			exit();
		}
	}	
}
add_action('load-testimonial-slider_page_testimonial-slider-settings','testimonial_process_set_requests');

// function for adding settings page to wp-admin
function testimonial_slider_settings() {
    // Add a new submenu under Options:
	add_menu_page( 'Testimonial Slider', 'Testimonial Slider', 'manage_options','testimonial-slider-admin', 'testimonial_slider_create_multiple_sliders' );
	add_submenu_page('testimonial-slider-admin', 'Testimonial Sliders', 'Sliders', 'manage_options', 'testimonial-slider-admin', 'testimonial_slider_create_multiple_sliders');
	add_submenu_page('testimonial-slider-admin', 'Testimonial Slider Settings', 'Settings', 'manage_options', 'testimonial-slider-settings', 'testimonial_slider_settings_page');
}
require_once (dirname (__FILE__) . '/sliders.php');
 
// This function displays the page content for the Testimonial Slider Options submenu
function testimonial_slider_settings_page() {
global $testimonial_slider,$default_testimonial_slider_settings;
$scounter=get_option('testimonial_slider_scounter');
if (isset($_GET['scounter']))$cntr = $_GET['scounter'];
else $cntr = '';

if(!empty($cntr))$cntr=intval($cntr);

$new_settings_msg=$imported_settings_message='';

$directory = TESTIMONIAL_SLIDER_CSS_DIR;
if ($handle = opendir($directory)) {
    while (false !== ($file = readdir($handle))) { 
     if($file != '.' and $file != '..') { 
     require_once ( dirname( dirname(__FILE__) ) . '/css/skins/'.$file.'/settings.php'); 
  
	} }
    closedir($handle);
}
//Reset Settings
if (isset ($_POST['testimonial_reset_settings_submit'])) {
	if ( $_POST['testimonial_reset_settings']!='n' ) {
	  $testimonial_reset_settings=$_POST['testimonial_reset_settings'];
	  $options='testimonial_slider_options'.$cntr;
	  $optionsvalue=get_option($options);
	  if( $testimonial_reset_settings == 'g' ){
		$new_settings_value=$default_testimonial_slider_settings;
		$new_settings_value['setname']=isset($optionsvalue['setname'])?$optionsvalue['setname']:'Set';
		update_option($options,$new_settings_value);
	  }
	  elseif(!is_numeric($testimonial_reset_settings)){
		$skin=$testimonial_reset_settings;
		$new_settings_value=$default_testimonial_slider_settings;
		$skin_defaults_str='default_settings_'.$skin;
		global ${$skin_defaults_str};
		if(count(${$skin_defaults_str})>0){
			foreach(${$skin_defaults_str} as $key=>$value){
				$new_settings_value[$key]=$value;	
			}
			$new_settings_value['stylesheet']=$skin;
			if(!isset($optionsvalue['setname']) or $optionsvalue['setname'] == '')
				$optionsvalue['setname']=$default_testimonial_slider_settings['setname'];
			$new_settings_value['setname']=$optionsvalue['setname'];
		}	
		update_option($options,$new_settings_value);
	  }
	  else{
		if( $testimonial_reset_settings == '1' ){
			$new_settings_value=get_option('testimonial_slider_options');
			$new_settings_value['setname']=$optionsvalue['setname'];
			update_option($options,	$new_settings_value );
		}
		else{
			$new_option_name='testimonial_slider_options'.$testimonial_reset_settings;
			$new_settings_value=get_option($new_option_name);
			$new_settings_value['setname']=$optionsvalue['setname'];
			update_option($options,	$new_settings_value );
		}
	  }
	}
}
//Import Settings
if (isset ($_POST['import'])) {
	if ($_POST['import']=='Import') {
		global $wpdb;
		$imported_settings_message='';
		$csv_mimetypes = array('text/csv','text/plain','application/csv','text/comma-separated-values','application/excel',
	'application/vnd.ms-excel','application/vnd.msexcel','text/anytext','application/octet-stream','application/txt');
		if ($_FILES['settings_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['settings_file']['tmp_name']) && in_array($_FILES['settings_file']['type'], $csv_mimetypes) ) { 
			$imported_settings=file_get_contents($_FILES['settings_file']['tmp_name']); 
			$settings_arr=explode("\n",$imported_settings);
			$slider_settings=array();
			foreach($settings_arr as $settings_field){
				$s=explode(',',$settings_field);
				$inner=explode('|',$s[1]);
				if(count($inner)>1) $slider_settings[$s[0]]=$inner;
				else $slider_settings[$s[0]]=$s[1];
			}
			$slider_settings['active_tab']=array('active_tabidx'=>'0','closed_sections'=>'');
			$options='testimonial_slider_options'.$cntr;
			
			if( $slider_settings['slider_name'] == 'testimonial' )	{
				update_option($options,$slider_settings);
				/*$new_settings_msg='<div id="message" class="updated fade" style="clear:left;"><h3>'.__('Settings imported successfully ','testimonial-slider').'</h3></div>';*/
				$imported_settings_message='<div style="clear:left;color:#006E2E;"><h3>'.__('Settings imported successfully ','testimonial-slider').'</h3></div>';
			}
			else {
				$new_settings_msg=$imported_settings_message='<div id="message" class="error fade" style="clear:left;"><h3>'.__('Settings imported do not match to Testimonial Slider Settings. Please check the file.','testimonial-slider').'</h3></div>';
				$imported_settings_message='<div style="clear:left;color:#ff0000;"><h3>'.__('Settings imported do not match to Testimonial Slider Settings. Please check the file.','testimonial-slider').'</h3></div>';
			}
		}
		else{
			$new_settings_msg=$imported_settings_message='<div id="message" class="error fade" style="clear:left;"><h3>'.__('Error in File, Settings not imported. Please check the file being imported. ','testimonial-slider').'</h3></div>';
			$imported_settings_message='<div style="clear:left;color:#ff0000;"><h3>'.__('Error in File, Settings not imported. Please check the file being imported. ','testimonial-slider').'</h3></div>';
		}
	}
}

//Delete Set
if (isset ($_POST['delete_set'])) {
	if ($_POST['delete_set']=='Delete this Set' and isset($cntr) and !empty($cntr)) {
	  $options='testimonial_slider_options'.$cntr;
	  delete_option($options);
	  $cntr='';
	}
}

$group='testimonial-slider-group'.$cntr;
$testimonial_slider_options='testimonial_slider_options'.$cntr;
$testimonial_slider_curr=get_option($testimonial_slider_options);
if(!isset($cntr) or empty($cntr)){$curr = 'Default';}
else{$curr = $cntr;}
foreach($default_testimonial_slider_settings as $key=>$value){
	if(!isset($testimonial_slider_curr[$key])) $testimonial_slider_curr[$key]='';
}
?>

<div class="wrap" style="clear:both;">
<h2 class="top_heading"><?php _e('Testimonial Slider Settings ','testimonial-slider');?> <span><?php echo $curr; ?> </span></h2>
<form style="float:left;margin:10px 20px" action="" method="post">
<?php if(isset($cntr) and !empty($cntr)){ ?>
<input type="submit" class="button-primary" value="Delete this Set" name="delete_set"  onclick="return confirmSettingsDelete()" />
<?php } ?>
</form>
<div class="svilla_cl"></div>
<?php echo $new_settings_msg;?>
<?php 
if ($testimonial_slider_curr['disable_preview'] != '1'){
?>
<div id="settings_preview"><h2 ><?php _e('Preview','testimonial-slider'); ?></h2> 
<?php 
if ($testimonial_slider_curr['preview'] == "0")
	get_testimonial_slider($testimonial_slider_curr['slider_id'],$cntr);
elseif($testimonial_slider_curr['preview'] == "1")
	get_testimonial_slider_category($testimonial_slider_curr['catg_slug'],$cntr);
else
	get_testimonial_slider_recent($cntr);
?></div>
<?php } ?>

<?php echo $new_settings_msg;?>

<div id="testimonial_settings" >
<form method="post" action="options.php" id="testimonial_slider_form">
<?php settings_fields($group); ?>

<?php
if(!isset($cntr) or empty($cntr)){}
else{?>
	<table class="form-table">
		<tr valign="top">
		<th scope="row"><h3><?php _e('Setting Set Name','testimonial-slider'); ?></h3></th>
		<td><h3><input type="text" name="<?php echo $testimonial_slider_options;?>[setname]" id="testimonial_slider_setname" class="regular-text" value="<?php echo $testimonial_slider_curr['setname']; ?>" /></h3></td>
		</tr>
	</table>
<?php }

?>
<div id="slider_tabs">
        <ul class="ui-tabs">
            <li class="green" ><a href="#basic"><?php _e('Basic Settings','testimonial-slider');?></a></li>
            <li class="blue"><a href="#slider_content"><?php _e('Slider Content','testimonial-slider');?></a></li>
	    <li class="pink" ><a href="#slider_nav"><?php _e('Navigation Settings','testimonial-slider');?></a></li>
	    <li class="orange"><a href="#preview"><?php _e('Preview Settings','testimonial-slider');?></a></li>
	</ul>

<div id="basic">
<div class="sub_settings toggle_settings" id="basic_exmin_tab_1">
<h2 class="sub-heading" id="basic_exmin_1"><?php _e('Basic Settings','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<p><?php _e('Customize the looks of the Slider box wrapping the content slides from here','testimonial-slider'); ?></p> 

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Testimonial Slider Skin','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[stylesheet]" id="testimonial_slider_stylesheet" onchange="return checkskin(this.value);">
<?php 
$directory = TESTIMONIAL_SLIDER_CSS_DIR;
if ($handle = opendir($directory)) {
    while (false !== ($file = readdir($handle))) { 
     if($file != '.' and $file != '..') { ?>
      <option value="<?php echo $file;?>" <?php if ($testimonial_slider_curr['stylesheet'] == $file){ echo "selected";}?> ><?php echo $file;?></option>
 <?php 
	} }
    closedir($handle);
}
?>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Type of Slider','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[type]" >
<option value="0" <?php if ($testimonial_slider_curr['type'] == "0"){ echo "selected";}?> ><?php _e('Slides Infinitely','testimonial-slider'); ?></option>
<option value="1" <?php if ($testimonial_slider_curr['type'] == "1"){ echo "selected";}?> ><?php _e('Stops when either end is reached','testimonial-slider'); ?></option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Slide Transition Effect','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[transition]" >
<option value="scroll" <?php if ($testimonial_slider_curr['transition'] == "scroll"){ echo "selected";}?> ><?php _e('Scroll Horizontally','testimonial-slider'); ?></option>
<option value="fade" <?php if ($testimonial_slider_curr['transition'] == "fade"){ echo "selected";}?> ><?php _e('Fade','testimonial-slider'); ?></option>
<option value="crossfade" <?php if ($testimonial_slider_curr['transition'] == "crossfade"){ echo "selected";}?> ><?php _e('Cross Fade','testimonial-slider'); ?></option>
<option value="cover" <?php if ($testimonial_slider_curr['transition'] == "cover"){ echo "selected";}?> ><?php _e('Cover','testimonial-slider'); ?></option>
<option value="uncover" <?php if ($testimonial_slider_curr['transition'] == "uncover"){ echo "selected";}?> ><?php _e('Uncover','testimonial-slider'); ?></option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Slide Easing Effect','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[easing]" >
<option value="swing" <?php if ($testimonial_slider_curr['easing'] == "swing"){ echo "selected";}?> ><?php _e('swing','testimonial-slider'); ?></option>
<option value="easeInQuad" <?php if ($testimonial_slider_curr['easing'] == "easeInQuad"){ echo "selected";}?> ><?php _e('easeInQuad','testimonial-slider'); ?></option>
<option value="easeOutQuad" <?php if ($testimonial_slider_curr['easing'] == "easeOutQuad"){ echo "selected";}?> ><?php _e('easeOutQuad','testimonial-slider'); ?></option>
<option value="easeInOutQuad" <?php if ($testimonial_slider_curr['easing'] == "easeInOutQuad"){ echo "selected";}?> ><?php _e('easeInOutQuad','testimonial-slider'); ?></option>
<option value="easeInCubic" <?php if ($testimonial_slider_curr['easing'] == "easeInCubic"){ echo "selected";}?> ><?php _e('easeInCubic','testimonial-slider'); ?></option>
<option value="easeOutCubic" <?php if ($testimonial_slider_curr['easing'] == "easeOutCubic"){ echo "selected";}?> ><?php _e('easeOutCubic','testimonial-slider'); ?></option>
<option value="easeInOutCubic" <?php if ($testimonial_slider_curr['easing'] == "easeInOutCubic"){ echo "selected";}?> ><?php _e('easeInOutCubic','testimonial-slider'); ?></option>
<option value="easeInQuart" <?php if ($testimonial_slider_curr['easing'] == "easeInQuart"){ echo "selected";}?> ><?php _e('easeInQuart','testimonial-slider'); ?></option>
<option value="easeOutQuart" <?php if ($testimonial_slider_curr['easing'] == "easeOutQuart"){ echo "selected";}?> ><?php _e('easeOutQuart','testimonial-slider'); ?></option>
<option value="easeInOutQuart" <?php if ($testimonial_slider_curr['easing'] == "easeInOutQuart"){ echo "selected";}?> ><?php _e('easeInOutQuart','testimonial-slider'); ?></option>
<option value="easeInQuint" <?php if ($testimonial_slider_curr['easing'] == "easeInQuint"){ echo "selected";}?> ><?php _e('easeInQuint','testimonial-slider'); ?></option>
<option value="easeOutQuint" <?php if ($testimonial_slider_curr['easing'] == "easeOutQuint"){ echo "selected";}?> ><?php _e('easeOutQuint','testimonial-slider'); ?></option>
<option value="easeInOutQuint" <?php if ($testimonial_slider_curr['easing'] == "easeInOutQuint"){ echo "selected";}?> ><?php _e('easeInOutQuint','testimonial-slider'); ?></option>
<option value="easeInSine" <?php if ($testimonial_slider_curr['easing'] == "easeInSine"){ echo "selected";}?> ><?php _e('easeInSine','testimonial-slider'); ?></option>
<option value="easeOutSine" <?php if ($testimonial_slider_curr['easing'] == "easeOutSine"){ echo "selected";}?> ><?php _e('easeOutSine','testimonial-slider'); ?></option>
<option value="easeInOutSine" <?php if ($testimonial_slider_curr['easing'] == "easeInOutSine"){ echo "selected";}?> ><?php _e('easeInOutSine','testimonial-slider'); ?></option>
<option value="easeInExpo" <?php if ($testimonial_slider_curr['easing'] == "easeInExpo"){ echo "selected";}?> ><?php _e('easeInExpo','testimonial-slider'); ?></option>
<option value="easeOutExpo" <?php if ($testimonial_slider_curr['easing'] == "easeOutExpo"){ echo "selected";}?> ><?php _e('easeOutExpo','testimonial-slider'); ?></option>
<option value="easeInOutExpo" <?php if ($testimonial_slider_curr['easing'] == "easeInOutExpo"){ echo "selected";}?> ><?php _e('easeInOutExpo','testimonial-slider'); ?></option>
<option value="easeInCirc" <?php if ($testimonial_slider_curr['easing'] == "easeInCirc"){ echo "selected";}?> ><?php _e('easeInCirc','testimonial-slider'); ?></option>
<option value="easeOutCirc" <?php if ($testimonial_slider_curr['easing'] == "easeOutCirc"){ echo "selected";}?> ><?php _e('easeOutCirc','testimonial-slider'); ?></option>
<option value="easeInOutCirc" <?php if ($testimonial_slider_curr['easing'] == "easeInOutCirc"){ echo "selected";}?> ><?php _e('easeInOutCirc','testimonial-slider'); ?></option>
<option value="easeInElastic" <?php if ($testimonial_slider_curr['easing'] == "easeInElastic"){ echo "selected";}?> ><?php _e('easeInElastic','testimonial-slider'); ?></option>
<option value="easeOutElastic" <?php if ($testimonial_slider_curr['easing'] == "easeOutElastic"){ echo "selected";}?> ><?php _e('easeOutElastic','testimonial-slider'); ?></option>
<option value="easeInOutElastic" <?php if ($testimonial_slider_curr['easing'] == "easeInOutElastic"){ echo "selected";}?> ><?php _e('easeInOutElastic','testimonial-slider'); ?></option>
<option value="easeInBack" <?php if ($testimonial_slider_curr['easing'] == "easeInBack"){ echo "selected";}?> ><?php _e('easeInBack','testimonial-slider'); ?></option>
<option value="easeOutBack" <?php if ($testimonial_slider_curr['easing'] == "easeOutBack"){ echo "selected";}?> ><?php _e('easeOutBack','testimonial-slider'); ?></option>
<option value="easeInOutBack" <?php if ($testimonial_slider_curr['easing'] == "easeInOutBack"){ echo "selected";}?> ><?php _e('easeInOutBack','testimonial-slider'); ?></option>
<option value="easeInBounce" <?php if ($testimonial_slider_curr['easing'] == "easeInBounce"){ echo "selected";}?> ><?php _e('easeInBounce','testimonial-slider'); ?></option>
<option value="easeOutBounce" <?php if ($testimonial_slider_curr['easing'] == "easeOutBounce"){ echo "selected";}?> ><?php _e('easeOutBounce','testimonial-slider'); ?></option>
<option value="easeInOutBounce" <?php if ($testimonial_slider_curr['easing'] == "easeInOutBounce"){ echo "selected";}?> ><?php _e('easeInOutBounce','testimonial-slider'); ?></option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Speed of Transition','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[speed]" id="testimonial_slider_speed" class="small-text" value="<?php echo $testimonial_slider_curr['speed']; ?>" />
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('The duration of Slide Animation in milliseconds. Lower value indicates fast animation. Enter numeric values like 5 or 7.','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Disable Autosliding','testimonial-slider'); ?></th>
<td><input name="<?php echo $testimonial_slider_options;?>[disable_autostep]" type="checkbox" value="1" <?php checked('1', $testimonial_slider_curr['disable_autostep']); ?>  />
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Time between Transitions','testimonial-slider'); ?></th>
<td><input type="number" name="<?php echo $testimonial_slider_options;?>[time]" id="testimonial_slider_time" class="small-text" value="<?php echo $testimonial_slider_curr['time']; ?>" MIN="10" />
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('Enter number that you want the slider to stop before sliding to next slide like 10, 20, 30. Valid only in case auto-sliding is enabled','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Number of Testimonials in the Testimonial Slider','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[no_posts]" id="testimonial_slider_no_posts" class="small-text" value="<?php echo $testimonial_slider_curr['no_posts']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Number of Items Visible in One Set','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[visible]" id="testimonial_slider_visible" class="small-text" value="<?php echo $testimonial_slider_curr['visible']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Number of Items To Scroll while Sliding','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[scroll]" id="testimonial_slider_scroll" class="small-text" value="<?php echo $testimonial_slider_curr['scroll']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Complete Slider Width','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[width]" id="testimonial_slider_width" class="small-text" value="<?php echo $testimonial_slider_curr['width']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?>
<span class="moreInfo">
	<span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('If set to 0, will take the container\'s width','testimonial-slider'); ?>
	</div>
</span></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Min. Slide Item Width','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[iwidth]" id="testimonial_slider_iwidth" class="small-text" value="<?php echo $testimonial_slider_curr['iwidth']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Slide (Item) Height','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[height]" id="testimonial_slider_height" class="small-text" value="<?php echo $testimonial_slider_curr['height']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Slide Background Color','testimonial-slider'); ?></th>
<td><input type="text"  name="<?php echo $testimonial_slider_options;?>[bg_color]" id="testimonial_slider_bg_color" value="<?php echo $testimonial_slider_curr['bg_color']; ?>" class="wp-color-picker-field" data-default-color="#ffffff" />
<br/> 
<label for="testimonial_slider_bg"><input name="<?php echo $testimonial_slider_options;?>[bg]" type="checkbox" id="testimonial_slider_bg" value="1" <?php checked('1', $testimonial_slider_curr['bg']); ?>  /><?php _e(' Use Transparent Background','testimonial-slider'); ?></label> </td>
</tr>
 
<tr valign="top">
<th scope="row"><?php _e('Slide Border Thickness','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[border]" id="testimonial_slider_border" class="small-text" value="<?php echo $testimonial_slider_curr['border']; ?>" />&nbsp;<?php _e('px (put 0 if no border is required)','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Slide Border Color','testimonial-slider'); ?></th>
<td>
<input type="text"  name="<?php echo $testimonial_slider_options;?>[brcolor]" id="testimonial_slider_brcolor" value="<?php echo $testimonial_slider_curr['brcolor']; ?>" class="wp-color-picker-field" data-default-color="#000000" />
</td>
</tr>

</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</div>

<div class="sub_settings_m toggle_settings"  id="basic_exmin_tab_2">
<h2 class="sub-heading"  id="basic_exmin_2"><?php _e('Miscellaneous','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Continue Reading Text','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[more]" class="regular-text" value="<?php echo $testimonial_slider_curr['more']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Slide Link (\'a\' element) attributes  ','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[a_attr]" class="regular-text code" value="<?php echo htmlentities( $testimonial_slider_curr['a_attr'] , ENT_QUOTES); ?>" />
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('eg. target="_blank" rel="external nofollow"','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Randomize Slides in Slider','testimonial-slider'); ?></th>
<td><input name="<?php echo $testimonial_slider_options;?>[rand]" type="checkbox" value="1" <?php checked('1', $testimonial_slider_curr['rand']); ?>  />
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('check this if you want the testimonials added to appear in random order.','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

<?php if(!isset($cntr) or empty($cntr)){?>

<tr valign="top">
<th scope="row"><?php _e('Minimum User Level to add Testimonials to the Slider','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[user_level]" >
<option value="manage_options" <?php if ($testimonial_slider_curr['user_level'] == "manage_options"){ echo "selected";}?> ><?php _e('Administrator','testimonial-slider'); ?></option>
<option value="edit_others_posts" <?php if ($testimonial_slider_curr['user_level'] == "edit_others_posts"){ echo "selected";}?> ><?php _e('Editor and Admininstrator','testimonial-slider'); ?></option>
<option value="publish_posts" <?php if ($testimonial_slider_curr['user_level'] == "publish_posts"){ echo "selected";}?> ><?php _e('Author, Editor and Admininstrator','testimonial-slider'); ?></option>
<option value="edit_posts" <?php if ($testimonial_slider_curr['user_level'] == "edit_posts"){ echo "selected";}?> ><?php _e('Contributor, Author, Editor and Admininstrator','testimonial-slider'); ?></option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Text to display in the JavaScript disabled browser','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[noscript]" class="regular-text code" value="<?php echo $testimonial_slider_curr['noscript']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Add Shortcode Support','testimonial-slider'); ?></th>
<td><input name="<?php echo $testimonial_slider_options;?>[shortcode]" type="checkbox" value="1" <?php checked('1', $testimonial_slider_curr['shortcode']); ?>  />&nbsp;<?php _e('check this if you want to use Testimonial Slider Shortcode i.e [testimonialslider]','testimonial-slider'); ?></td>
</tr>
<?php } ?>

<!-- Removed Skins Selection -->

<?php if(!isset($cntr) or empty($cntr)){?>
<tr valign="top">
<th scope="row"><?php _e('Multiple Slider Feature','testimonial-slider'); ?></th>
<td><label for="testimonial_slider_multiple"> 
<input name="<?php echo $testimonial_slider_options;?>[multiple_sliders]" type="checkbox" id="testimonial_slider_multiple" value="1" <?php checked("1", $testimonial_slider_curr['multiple_sliders']); ?> /> 
 <?php _e('Grant Multiple Slider ability to Testimonial Slider','testimonial-slider'); ?></label></td>
</tr>
<?php } ?>

<tr valign="top">
<th scope="row"><?php _e('Enable FOUC','testimonial-slider'); ?></th>
<td><input name="<?php echo $testimonial_slider_options;?>[fouc]" type="checkbox" value="1" <?php checked('1', $testimonial_slider_curr['fouc']); ?>  />
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('check this if you would not want to disable Flash of Unstyled Content in the slider when the page is loaded.','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

<?php if(!isset($cntr) or empty($cntr)){?>

<tr valign="top">
<th scope="row"><?php _e('Custom Styles','testimonial-slider'); ?></th>
<td><textarea name="<?php echo $testimonial_slider_options;?>[css]"  rows="5" cols="30" class="regular-text code"><?php echo $testimonial_slider_curr['css']; ?></textarea>
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('custom css styles that you would want to be applied to the slider elements.','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Show Promotionals on Admin Page','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[support]" >
<option value="1" <?php if ($testimonial_slider_curr['support'] == "1"){ echo "selected";}?> ><?php _e('Yes','testimonial-slider'); ?></option>
<option value="0" <?php if ($testimonial_slider_curr['support'] == "0"){ echo "selected";}?> ><?php _e('No','testimonial-slider'); ?></option>
</select>
</td>
</tr>
<?php } ?>

</table>
</div>
<?php do_action('testimonial_addon_settings',$cntr,$testimonial_slider_options,$testimonial_slider_curr);?>
</div> <!--Basic Tab Ends-->

<div id="slider_content">
<div class="sub_settings toggle_settings" id="basic_exmin_tab_3">
<h2 class="sub-heading" id="basic_exmin_3"><?php _e('Slider Title','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<p><?php _e('Customize the looks of the main title of the Slideshow from here','testimonial-slider'); ?></p> 
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Default Title Text','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[title_text]" id="testimonial_slider_title_text" value="<?php echo htmlentities($testimonial_slider_curr['title_text'], ENT_QUOTES); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Pick Slider Title From','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[title_from]" >
<option value="0" <?php if ($testimonial_slider_curr['title_from'] == "0"){ echo "selected";}?> ><?php _e('Default Title Text','testimonial-slider'); ?></option>
<option value="1" <?php if ($testimonial_slider_curr['title_from'] == "1"){ echo "selected";}?> ><?php _e('Slider Name','testimonial-slider'); ?></option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[title_font]" id="testimonial_slider_title_font" >
<option value="Arial,Helvetica,sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "Arial,Helvetica,sans-serif"){ echo "selected";}?> >Arial,Helvetica,sans-serif</option>
<option value="Verdana,Geneva,sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "Verdana,Geneva,sans-serif"){ echo "selected";}?> >Verdana,Geneva,sans-serif</option>
<option value="Tahoma,Geneva,sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "Tahoma,Geneva,sans-serif"){ echo "selected";}?> >Tahoma,Geneva,sans-serif</option>
<option value="Trebuchet MS,sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "Trebuchet MS,sans-serif"){ echo "selected";}?> >Trebuchet MS,sans-serif</option>
<option value="'Century Gothic','Avant Garde',sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "'Century Gothic','Avant Garde',sans-serif"){ echo "selected";}?> >'Century Gothic','Avant Garde',sans-serif</option>
<option value="'Arial Narrow',sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "'Arial Narrow',sans-serif"){ echo "selected";}?> >'Arial Narrow',sans-serif</option>
<option value="'Arial Black',sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "'Arial Black',sans-serif"){ echo "selected";}?> >'Arial Black',sans-serif</option>
<option value="'Gills Sans MT','Gills Sans',sans-serif" <?php if ($testimonial_slider_curr['title_font'] == "'Gills Sans MT','Gills Sans',sans-serif"){ echo "selected";} ?> >'Gills Sans MT','Gills Sans',sans-serif</option>
<option value="'Lucida Sans Unicode', 'Lucida Grand', sans-serif;" <?php if ($testimonial_slider_curr['title_font'] == "'Lucida Sans Unicode', 'Lucida Grand', sans-serif;"){ echo "selected";} ?> >'Lucida Sans Unicode', 'Lucida Grand', sans-serif;</option>
<option value="'Times New Roman',Times,serif" <?php if ($testimonial_slider_curr['title_font'] == "'Times New Roman',Times,serif"){ echo "selected";}?> >'Times New Roman',Times,serif</option>
<option value="Georgia,serif" <?php if ($testimonial_slider_curr['title_font'] == "Georgia,serif"){ echo "selected";}?> >Georgia,serif</option>
<option value="Garamond,serif" <?php if ($testimonial_slider_curr['title_font'] == "Garamond,serif"){ echo "selected";}?> >Garamond,serif</option>
<option value="'Century Schoolbook','New Century Schoolbook',serif" <?php if ($testimonial_slider_curr['title_font'] == "'Century Schoolbook','New Century Schoolbook',serif"){ echo "selected";}?> >'Century Schoolbook','New Century Schoolbook',serif</option>
<option value="'Bookman Old Style',Bookman,serif" <?php if ($testimonial_slider_curr['title_font'] == "'Bookman Old Style',Bookman,serif"){ echo "selected";}?> >'Bookman Old Style',Bookman,serif</option>
<option value="'Comic Sans MS',cursive" <?php if ($testimonial_slider_curr['title_font'] == "'Comic Sans MS',cursive"){ echo "selected";}?> >'Comic Sans MS',cursive</option>
<option value="'Courier New',Courier,monospace" <?php if ($testimonial_slider_curr['title_font'] == "'Courier New',Courier,monospace"){ echo "selected";}?> >'Courier New',Courier,monospace</option>
<option value="'Copperplate Gothic Bold',Copperplate,fantasy" <?php if ($testimonial_slider_curr['title_font'] == "'Copperplate Gothic Bold',Copperplate,fantasy"){ echo "selected";}?> >'Copperplate Gothic Bold',Copperplate,fantasy</option>
<option value="Impact,fantasy" <?php if ($testimonial_slider_curr['title_font'] == "Impact,fantasy"){ echo "selected";}?> >Impact,fantasy</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Color','testimonial-slider'); ?></th>
<td>
<input type="text"  name="<?php echo $testimonial_slider_options;?>[title_fcolor]" id="testimonial_slider_title_fcolor" value="<?php echo $testimonial_slider_curr['title_fcolor']; ?>" class="wp-color-picker-field" data-default-color="#000000" />
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Size','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[title_fsize]" id="testimonial_slider_title_fsize" class="small-text" value="<?php echo $testimonial_slider_curr['title_fsize']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Style','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[title_fstyle]" id="testimonial_slider_title_fstyle" >
<option value="bold" <?php if ($testimonial_slider_curr['title_fstyle'] == "bold"){ echo "selected";}?> ><?php _e('Bold','testimonial-slider'); ?></option>
<option value="bold italic" <?php if ($testimonial_slider_curr['title_fstyle'] == "bold italic"){ echo "selected";}?> ><?php _e('Bold Italic','testimonial-slider'); ?></option>
<option value="italic" <?php if ($testimonial_slider_curr['title_fstyle'] == "italic"){ echo "selected";}?> ><?php _e('Italic','testimonial-slider'); ?></option>
<option value="normal" <?php if ($testimonial_slider_curr['title_fstyle'] == "normal"){ echo "selected";}?> ><?php _e('Normal','testimonial-slider'); ?></option>
</select>
</td>
</tr>
</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</div>

<div class="sub_settings_m toggle_settings" id="basic_exmin_tab_4">
<h2 class="sub-heading" id="basic_exmin_4"><?php _e('Gravtar/Customer Image','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Default Avatar URL','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[default_avatar]" class="regular-text code" value="<?php echo $testimonial_slider_curr['default_avatar']; ?>" /></td>
</tr>
<?php if($testimonial_slider_curr['show_avatar'] == 1) $showchk = "onSelected";
	else $showchk = "";
      if($testimonial_slider_curr['show_avatar'] == 0) $hidechk = "offSelected";
	else $hidechk = "";
 ?>
<tr valign="top">
<th scope="row"><?php _e('Avatar Image','testimonial-slider'); ?></th>
<td><div class="onoffswitch">
    <input type="hidden" name="<?php echo $testimonial_slider_options;?>[show_avatar]" class="onoffswitch-checkbox" id="onOffVal" value="<?php echo $testimonial_slider_curr['show_avatar'];?>"  >
    <lable class="lable_on <?php echo $hidechk;?>" id="swithOff">Hide</lable><lable  class="lable_off <?php echo $showchk;?>" id="swithOn">Show</lable>
</div></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Avatar Shape','testimonial-slider'); ?></th>
<td>
<input type="radio" name="<?php echo $testimonial_slider_options;?>[avatar_shape]" value="square" <?php if ($testimonial_slider_curr['avatar_shape'] == "square"){ echo "checked";}?> id="testimonial_slider_avatar_shape" onclick="return hide_radius();">Square
<input type="radio" name="<?php echo $testimonial_slider_options;?>[avatar_shape]" id="testimonial_slider_avatar_shape" value="circle" 
<?php if ($testimonial_slider_curr['avatar_shape'] == "circle"){ echo "checked";}?> onclick="return show_radius();">Circle
</td>
</tr>
<?php if($testimonial_slider_curr['avatar_shape'] == "circle") { $radius_css = "display: compact;"; } 
	else $radius_css = "display: none;"
?>
<tr valign="top" id="tr_avatar_radius" style="<?php echo $radius_css; ?>">
<th scope="row"><?php _e('Avatar Radius','testimonial-slider'); ?></th>
<td>
<input type="text" name="<?php echo $testimonial_slider_options;?>[avatar_radius]" id="testimonial_slider_avatar_radius" class="small-text" value="<?php echo $testimonial_slider_curr['avatar_radius']; ?>" /> &nbsp; %
</td>
</tr>

<tr valign="top"> 
<th scope="row"><?php _e('Image Width','testimonial-slider'); ?></th> 
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[img_width]" id="testimonial_slider_img_width" class="small-text" value="<?php echo $testimonial_slider_curr['img_width']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?> </td> 
</tr> 

<tr valign="top">
<th scope="row"><?php _e('Max. Image Height','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[img_height]" id="testimonial_slider_img_height" class="small-text" value="<?php echo $testimonial_slider_curr['img_height']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?> </td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Border Thickness','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[img_border]" id="testimonial_slider_img_border" class="small-text" value="<?php echo $testimonial_slider_curr['img_border']; ?>" />&nbsp;<?php _e('px  (put 0 if no border is required)','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Border Color','testimonial-slider'); ?></th>
<td><input type="text"  name="<?php echo $testimonial_slider_options;?>[img_brcolor]" id="testimonial_slider_img_brcolor" value="<?php echo $testimonial_slider_curr['img_brcolor']; ?>" class="wp-color-picker-field" data-default-color="#000000" />
</td>
</tr>

</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</div>

<div class="sub_settings_m toggle_settings" id="basic_exmin_tab_5">
<h2 class="sub-heading" id="basic_exmin_5"><?php _e('Customer\'s name','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<p><?php _e('Customize the Customer\'s Name field looks','testimonial-slider'); ?></p> 
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Font','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[ptitle_font]" id="testimonial_slider_ptitle_font" >
<option value="Arial,Helvetica,sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "Arial,Helvetica,sans-serif"){ echo "selected";}?> >Arial,Helvetica,sans-serif</option>
<option value="Verdana,Geneva,sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "Verdana,Geneva,sans-serif"){ echo "selected";}?> >Verdana,Geneva,sans-serif</option>
<option value="Tahoma,Geneva,sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "Tahoma,Geneva,sans-serif"){ echo "selected";}?> >Tahoma,Geneva,sans-serif</option>
<option value="Trebuchet MS,sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "Trebuchet MS,sans-serif"){ echo "selected";}?> >Trebuchet MS,sans-serif</option>
<option value="'Century Gothic','Avant Garde',sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Century Gothic','Avant Garde',sans-serif"){ echo "selected";}?> >'Century Gothic','Avant Garde',sans-serif</option>
<option value="'Arial Narrow',sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Arial Narrow',sans-serif"){ echo "selected";}?> >'Arial Narrow',sans-serif</option>
<option value="'Arial Black',sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Arial Black',sans-serif"){ echo "selected";}?> >'Arial Black',sans-serif</option>
<option value="'Gills Sans MT','Gills Sans',sans-serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Gills Sans MT','Gills Sans',sans-serif"){ echo "selected";} ?> >'Gills Sans MT','Gills Sans',sans-serif</option>
<option value="'Lucida Sans Unicode', 'Lucida Grand', sans-serif;" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Lucida Sans Unicode', 'Lucida Grand', sans-serif;"){ echo "selected";} ?> >'Lucida Sans Unicode', 'Lucida Grand', sans-serif;</option>
<option value="'Times New Roman',Times,serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Times New Roman',Times,serif"){ echo "selected";}?> >'Times New Roman',Times,serif</option>
<option value="Georgia,serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "Georgia,serif"){ echo "selected";}?> >Georgia,serif</option>
<option value="Garamond,serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "Garamond,serif"){ echo "selected";}?> >Garamond,serif</option>
<option value="'Century Schoolbook','New Century Schoolbook',serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Century Schoolbook','New Century Schoolbook',serif"){ echo "selected";}?> >'Century Schoolbook','New Century Schoolbook',serif</option>
<option value="'Bookman Old Style',Bookman,serif" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Bookman Old Style',Bookman,serif"){ echo "selected";}?> >'Bookman Old Style',Bookman,serif</option>
<option value="'Comic Sans MS',cursive" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Comic Sans MS',cursive"){ echo "selected";}?> >'Comic Sans MS',cursive</option>
<option value="'Courier New',Courier,monospace" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Courier New',Courier,monospace"){ echo "selected";}?> >'Courier New',Courier,monospace</option>
<option value="'Copperplate Gothic Bold',Copperplate,fantasy" <?php if ($testimonial_slider_curr['ptitle_font'] == "'Copperplate Gothic Bold',Copperplate,fantasy"){ echo "selected";}?> >'Copperplate Gothic Bold',Copperplate,fantasy</option>
<option value="Impact,fantasy" <?php if ($testimonial_slider_curr['ptitle_font'] == "Impact,fantasy"){ echo "selected";}?> >Impact,fantasy</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Color','testimonial-slider'); ?></th>
<td><input type="text"  name="<?php echo $testimonial_slider_options;?>[ptitle_fcolor]" id="testimonial_slider_ptitle_fcolor" value="<?php echo $testimonial_slider_curr['ptitle_fcolor']; ?>" class="wp-color-picker-field" data-default-color="#000000" />
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Size','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[ptitle_fsize]" id="testimonial_slider_ptitle_fsize" class="small-text" value="<?php echo $testimonial_slider_curr['ptitle_fsize']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Style','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[ptitle_fstyle]" id="testimonial_slider_ptitle_fstyle" >
<option value="bold" <?php if ($testimonial_slider_curr['ptitle_fstyle'] == "bold"){ echo "selected";}?> ><?php _e('Bold','testimonial-slider'); ?></option>
<option value="bold italic" <?php if ($testimonial_slider_curr['ptitle_fstyle'] == "bold italic"){ echo "selected";}?> ><?php _e('Bold Italic','testimonial-slider'); ?></option>
<option value="italic" <?php if ($testimonial_slider_curr['ptitle_fstyle'] == "italic"){ echo "selected";}?> ><?php _e('Italic','testimonial-slider'); ?></option>
<option value="normal" <?php if ($testimonial_slider_curr['ptitle_fstyle'] == "normal"){ echo "selected";}?> ><?php _e('Normal','testimonial-slider'); ?></option>
</select>
</td>
</tr>
</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</div>

<div class="sub_settings_m toggle_settings" id="basic_exmin_tab_6">
<h2 class="sub-heading" id="basic_exmin_6"><?php _e('Customer\'s Company/Site','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<p><?php _e('Customize the Customer\'s Company/Site field looks','testimonial-slider'); ?></p> 
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Font','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[psite_font]" id="testimonial_slider_psite_font" >
<option value="Arial,Helvetica,sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "Arial,Helvetica,sans-serif"){ echo "selected";}?> >Arial,Helvetica,sans-serif</option>
<option value="Verdana,Geneva,sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "Verdana,Geneva,sans-serif"){ echo "selected";}?> >Verdana,Geneva,sans-serif</option>
<option value="Tahoma,Geneva,sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "Tahoma,Geneva,sans-serif"){ echo "selected";}?> >Tahoma,Geneva,sans-serif</option>
<option value="Trebuchet MS,sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "Trebuchet MS,sans-serif"){ echo "selected";}?> >Trebuchet MS,sans-serif</option>
<option value="'Century Gothic','Avant Garde',sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "'Century Gothic','Avant Garde',sans-serif"){ echo "selected";}?> >'Century Gothic','Avant Garde',sans-serif</option>
<option value="'Arial Narrow',sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "'Arial Narrow',sans-serif"){ echo "selected";}?> >'Arial Narrow',sans-serif</option>
<option value="'Arial Black',sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "'Arial Black',sans-serif"){ echo "selected";}?> >'Arial Black',sans-serif</option>
<option value="'Gills Sans MT','Gills Sans',sans-serif" <?php if ($testimonial_slider_curr['psite_font'] == "'Gills Sans MT','Gills Sans',sans-serif"){ echo "selected";} ?> >'Gills Sans MT','Gills Sans',sans-serif</option>
<option value="'Lucida Sans Unicode', 'Lucida Grand', sans-serif;" <?php if ($testimonial_slider_curr['psite_font'] == "'Lucida Sans Unicode', 'Lucida Grand', sans-serif;"){ echo "selected";} ?> >'Lucida Sans Unicode', 'Lucida Grand', sans-serif;</option>
<option value="'Times New Roman',Times,serif" <?php if ($testimonial_slider_curr['psite_font'] == "'Times New Roman',Times,serif"){ echo "selected";}?> >'Times New Roman',Times,serif</option>
<option value="Georgia,serif" <?php if ($testimonial_slider_curr['psite_font'] == "Georgia,serif"){ echo "selected";}?> >Georgia,serif</option>
<option value="Garamond,serif" <?php if ($testimonial_slider_curr['psite_font'] == "Garamond,serif"){ echo "selected";}?> >Garamond,serif</option>
<option value="'Century Schoolbook','New Century Schoolbook',serif" <?php if ($testimonial_slider_curr['psite_font'] == "'Century Schoolbook','New Century Schoolbook',serif"){ echo "selected";}?> >'Century Schoolbook','New Century Schoolbook',serif</option>
<option value="'Bookman Old Style',Bookman,serif" <?php if ($testimonial_slider_curr['psite_font'] == "'Bookman Old Style',Bookman,serif"){ echo "selected";}?> >'Bookman Old Style',Bookman,serif</option>
<option value="'Comic Sans MS',cursive" <?php if ($testimonial_slider_curr['psite_font'] == "'Comic Sans MS',cursive"){ echo "selected";}?> >'Comic Sans MS',cursive</option>
<option value="'Courier New',Courier,monospace" <?php if ($testimonial_slider_curr['psite_font'] == "'Courier New',Courier,monospace"){ echo "selected";}?> >'Courier New',Courier,monospace</option>
<option value="'Copperplate Gothic Bold',Copperplate,fantasy" <?php if ($testimonial_slider_curr['psite_font'] == "'Copperplate Gothic Bold',Copperplate,fantasy"){ echo "selected";}?> >'Copperplate Gothic Bold',Copperplate,fantasy</option>
<option value="Impact,fantasy" <?php if ($testimonial_slider_curr['psite_font'] == "Impact,fantasy"){ echo "selected";}?> >Impact,fantasy</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Color','testimonial-slider'); ?></th>
<td><input type="text"  name="<?php echo $testimonial_slider_options;?>[psite_fcolor]" id="testimonial_slider_psite_fcolor" value="<?php echo $testimonial_slider_curr['psite_fcolor']; ?>" class="wp-color-picker-field" data-default-color="#000000" />
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Size','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[psite_fsize]" id="testimonial_slider_psite_fsize" class="small-text" value="<?php echo $testimonial_slider_curr['psite_fsize']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Style','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[psite_fstyle]" id="testimonial_slider_psite_fstyle" >
<option value="bold" <?php if ($testimonial_slider_curr['psite_fstyle'] == "bold"){ echo "selected";}?> ><?php _e('Bold','testimonial-slider'); ?></option>
<option value="bold italic" <?php if ($testimonial_slider_curr['psite_fstyle'] == "bold italic"){ echo "selected";}?> ><?php _e('Bold Italic','testimonial-slider'); ?></option>
<option value="italic" <?php if ($testimonial_slider_curr['psite_fstyle'] == "italic"){ echo "selected";}?> ><?php _e('Italic','testimonial-slider'); ?></option>
<option value="normal" <?php if ($testimonial_slider_curr['psite_fstyle'] == "normal"){ echo "selected";}?> ><?php _e('Normal','testimonial-slider'); ?></option>
</select>
</td>
</tr>
</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</div>

<div class="sub_settings_m toggle_settings" id="basic_exmin_tab_7">
<h2 class="sub-heading" id="basic_exmin_7"><?php _e('Testimonial Content','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('Font','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[content_font]" id="testimonial_slider_content_font" >
<option value="Arial,Helvetica,sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "Arial,Helvetica,sans-serif"){ echo "selected";}?> >Arial,Helvetica,sans-serif</option>
<option value="Verdana,Geneva,sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "Verdana,Geneva,sans-serif"){ echo "selected";}?> >Verdana,Geneva,sans-serif</option>
<option value="Tahoma,Geneva,sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "Tahoma,Geneva,sans-serif"){ echo "selected";}?> >Tahoma,Geneva,sans-serif</option>
<option value="Trebuchet MS,sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "Trebuchet MS,sans-serif"){ echo "selected";}?> >Trebuchet MS,sans-serif</option>
<option value="'Century Gothic','Avant Garde',sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "'Century Gothic','Avant Garde',sans-serif"){ echo "selected";}?> >'Century Gothic','Avant Garde',sans-serif</option>
<option value="'Arial Narrow',sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "'Arial Narrow',sans-serif"){ echo "selected";}?> >'Arial Narrow',sans-serif</option>
<option value="'Arial Black',sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "'Arial Black',sans-serif"){ echo "selected";}?> >'Arial Black',sans-serif</option>
<option value="'Gills Sans MT','Gills Sans',sans-serif" <?php if ($testimonial_slider_curr['content_font'] == "'Gills Sans MT','Gills Sans',sans-serif"){ echo "selected";} ?> >'Gills Sans MT','Gills Sans',sans-serif</option>
<option value="'Lucida Sans Unicode', 'Lucida Grand', sans-serif;" <?php if ($testimonial_slider_curr['content_font'] == "'Lucida Sans Unicode', 'Lucida Grand', sans-serif;"){ echo "selected";} ?> >'Lucida Sans Unicode', 'Lucida Grand', sans-serif;</option>
<option value="'Times New Roman',Times,serif" <?php if ($testimonial_slider_curr['content_font'] == "'Times New Roman',Times,serif"){ echo "selected";}?> >'Times New Roman',Times,serif</option>
<option value="Georgia,serif" <?php if ($testimonial_slider_curr['content_font'] == "Georgia,serif"){ echo "selected";}?> >Georgia,serif</option>
<option value="Garamond,serif" <?php if ($testimonial_slider_curr['content_font'] == "Garamond,serif"){ echo "selected";}?> >Garamond,serif</option>
<option value="'Century Schoolbook','New Century Schoolbook',serif" <?php if ($testimonial_slider_curr['content_font'] == "'Century Schoolbook','New Century Schoolbook',serif"){ echo "selected";}?> >'Century Schoolbook','New Century Schoolbook',serif</option>
<option value="'Bookman Old Style',Bookman,serif" <?php if ($testimonial_slider_curr['content_font'] == "'Bookman Old Style',Bookman,serif"){ echo "selected";}?> >'Bookman Old Style',Bookman,serif</option>
<option value="'Comic Sans MS',cursive" <?php if ($testimonial_slider_curr['content_font'] == "'Comic Sans MS',cursive"){ echo "selected";}?> >'Comic Sans MS',cursive</option>
<option value="'Courier New',Courier,monospace" <?php if ($testimonial_slider_curr['content_font'] == "'Courier New',Courier,monospace"){ echo "selected";}?> >'Courier New',Courier,monospace</option>
<option value="'Copperplate Gothic Bold',Copperplate,fantasy" <?php if ($testimonial_slider_curr['content_font'] == "'Copperplate Gothic Bold',Copperplate,fantasy"){ echo "selected";}?> >'Copperplate Gothic Bold',Copperplate,fantasy</option>
<option value="Impact,fantasy" <?php if ($testimonial_slider_curr['content_font'] == "Impact,fantasy"){ echo "selected";}?> >Impact,fantasy</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Color','testimonial-slider'); ?></th>
<td><input type="text"  name="<?php echo $testimonial_slider_options;?>[content_fcolor]" id="testimonial_slider_content_fcolor" value="<?php echo $testimonial_slider_curr['content_fcolor']; ?>" class="wp-color-picker-field" data-default-color="#000000" />
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Size','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[content_fsize]" id="testimonial_slider_content_fsize" class="small-text" value="<?php echo $testimonial_slider_curr['content_fsize']; ?>" />&nbsp;<?php _e('px','testimonial-slider'); ?></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Font Style','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[content_fstyle]" id="testimonial_slider_content_fstyle" >
<option value="bold" <?php if ($testimonial_slider_curr['content_fstyle'] == "bold"){ echo "selected";}?> ><?php _e('Bold','testimonial-slider'); ?></option>
<option value="bold italic" <?php if ($testimonial_slider_curr['content_fstyle'] == "bold italic"){ echo "selected";}?> ><?php _e('Bold Italic','testimonial-slider'); ?></option>
<option value="italic" <?php if ($testimonial_slider_curr['content_fstyle'] == "italic"){ echo "selected";}?> ><?php _e('Italic','testimonial-slider'); ?></option>
<option value="normal" <?php if ($testimonial_slider_curr['content_fstyle'] == "normal"){ echo "selected";}?> ><?php _e('Normal','testimonial-slider'); ?></option>
</select>
</td>
</tr>

<tr valign="top">
	<th scope="row"><?php _e('Star Color','testimonial-slider')?></th>
	<td><input type="text" name="<?php echo $testimonial_slider_options;?>[star_color]" id="testimonial_slider_star_color" value="<?php echo $testimonial_slider_curr['star_color'];?>" class="wp-color-picker-field" data-default-color="#f1c40f" />
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Star Size','testimonial-slider')?></th>
	<td><input type="number" name="<?php echo $testimonial_slider_options;?>[star_size]" id="testimonial_slider_star_size" value="<?php echo $testimonial_slider_curr['star_size'];?>" class="small-text" /> &nbsp;px
	</td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Show Star Rating','testimonial-slider')?></th>
	<td>
		<input id="testimonial_slider_show_star" name="<?php echo $testimonial_slider_options;?>[show_star]" value="1" type="checkbox" <?php echo checked('1', $testimonial_slider_curr['show_star']);?> >
	</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Pick content From','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[content_from]" id="testimonial_slider_content_from" >
<option value="content" <?php if ($testimonial_slider_curr['content_from'] == "content"){ echo "selected";}?> ><?php _e('From Content','testimonial-slider'); ?></option>
</select>
</td>
</tr>
<tr valign="top">
<th scope="row"><?php _e('Maximum content','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[content_limit]" id="testimonial_slider_content_limit" class="small-text" value="<?php echo $testimonial_slider_curr['content_limit']; ?>" />&nbsp;<?php _e('words','testimonial-slider'); ?>
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('Keep empty to select complete Content','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

</table>

</div>
</div> <!-- slider_content tab ends-->

<div id="slider_nav">
<div class="sub_settings toggle_settings">
<h2 class="sub-heading"><?php _e('Navigational Buttons','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Show Navigation Buttons','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[navnum]" >
<option value="0" <?php if ($testimonial_slider_curr['navnum'] == "0"){ echo "selected";}?> ><?php _e('No','testimonial-slider'); ?></option>
<option value="1" <?php if ($testimonial_slider_curr['navnum'] == "1"){ echo "selected";}?> ><?php _e('Bottom of Slider','testimonial-slider'); ?></option>
<option value="2" <?php if ($testimonial_slider_curr['navnum'] == "2"){ echo "selected";}?> ><?php _e('Top of Slider','testimonial-slider'); ?></option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Navigation Button Width','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[navimg_w]" id="testimonial_slider_navimg_w" class="small-text" value="<?php echo $testimonial_slider_curr['navimg_w']; ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Navigation Button Height','testimonial-slider'); ?></th>
<td><input type="text" name="<?php echo $testimonial_slider_options;?>[navimg_h]" id="testimonial_slider_navimg_h" class="small-text" value="<?php echo $testimonial_slider_curr['navimg_h']; ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Navigation Button Color','testimonial-slider'); ?></th>
<td><input type="text"  name="<?php echo $testimonial_slider_options;?>[nav_color]" id="testimonial_slider_nav_color" value="<?php echo $testimonial_slider_curr['nav_color']; ?>" class="wp-color-picker-field" data-default-color="#999999" />
</td>
</tr>

</table>

</div>
<div class="sub_settings_m toggle_settings" >
<h2 class="sub-heading"><?php _e('Navigational Arrows','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 

<table class="form-table">
<?php if($testimonial_slider_curr['prev_next'] == 0) $showArrowchk = "onSelected";
	else $showArrowchk = "";
      if($testimonial_slider_curr['prev_next'] == 1) $hideArrowchk = "offSelected";
	else $hideArrowchk = "";
 ?>
<tr valign="top"> 
<th scope="row"><?php _e('Hide Prev/Next navigation arrows','testimonial-slider'); ?></th> 
<td>
<div class="onoffswitch">
    <input type="hidden" name="<?php echo $testimonial_slider_options;?>[prev_next]" class="onoffswitch-checkbox" id="showHideArrow" value="<?php echo $testimonial_slider_curr['prev_next'];?>"  >
    <lable class="lable_on <?php echo $hideArrowchk;?>" id="hideArrow">Hide</lable><lable  class="lable_off <?php echo $showArrowchk;?>" id="showArrow">Show</lable>
</div>
</td>
</tr>

<?php if($testimonial_slider_curr['stylesheet'] == 'default') $navigation_text = 'Navigation Arrows/Buttons Folder';
	else $navigation_text = 'Navigation Arrows Folder';?>
<tr valign="top">
<th scope="row"><?php _e($navigation_text,'testimonial-slider'); ?></th>
<td style="background: #ddd;">
<?php 
$directory = TESTIMONIAL_SLIDER_CSS_DIR.$testimonial_slider['stylesheet'].'/buttons/';
if ($handle = opendir($directory)) {
    while (false !== ($file = readdir($handle))) { 
     if($file != '.' and $file != '..') { 
     $nexturl='css/skins/'.$testimonial_slider_curr['stylesheet'].'/buttons/'.$file.'/next.png';?>
	<div class="arrows"><img src="<?php echo testimonial_slider_plugin_url($nexturl);?>" style="width: 16px;height: 16px;"/>
	<input name="<?php echo $testimonial_slider_options;?>[buttons]" type="radio" id="testimonial_slider_buttons" class="arrows_input" value="<?php echo $file;?>" <?php if($testimonial_slider_curr['buttons'] == $file)  echo ' checked="checked"';?> /></div>
 <?php  } }
    closedir($handle);
}
?>
<div class="svilla_cl"></div>
</td>
</tr>
</table>
</div>

</div><!-- slider_nav tab ends-->

<div id="preview">
<div class="sub_settings toggle_settings" id="basic_exmin_tab_8">
<h2 class="sub-heading" id="basic_exmin_8"><?php _e('Preview on Settings Panel','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 

<table class="form-table">

<tr valign="top"> 
<th scope="row"><label for="testimonial_slider_disable_preview"><?php _e('Disable Preview Section','testimonial-slider'); ?></label></th> 
<td> 
<input name="<?php echo $testimonial_slider_options;?>[disable_preview]" type="checkbox" id="testimonial_slider_disable_preview" value="1" <?php checked("1", $testimonial_slider_curr['disable_preview']); ?> />
<span class="moreInfo">
	&nbsp; <span class="trigger"> ? </span>
	<div class="tooltip">
	<?php _e('If disabled, the \'Preview\' of Slider on this Settings page will be removed.','testimonial-slider'); ?>
	</div>
</span>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Testimonial Template Tag for Preview','testimonial-slider'); ?></th>
<td><select name="<?php echo $testimonial_slider_options;?>[preview]" id="testimonial_slider_preview" onchange="checkpreview(this.value);">
<option value="2" <?php if ($testimonial_slider_curr['preview'] == "2"){ echo "selected";}?> ><?php _e('Recent Testimonials Slider','testimonial-slider'); ?></option>
<option value="1" <?php if ($testimonial_slider_curr['preview'] == "1"){ echo "selected";}?> ><?php _e('Category Testimonial Slider','testimonial-slider'); ?></option>
<option value="0" <?php if ($testimonial_slider_curr['preview'] == "0"){ echo "selected";}?> ><?php _e('Custom Slider with Slider ID','testimonial-slider'); ?></option>
</select>
</td>
</tr>
<?php
//category slug Select Option
$args=array(
		'taxonomy'=> 'testimonial_category'
	);
	$categories = get_categories($args);
	$scat_html='<option value="" selected >Select the Category</option>';
	foreach ($categories as $category) { 
		 if($category->slug==$testimonial_slider_curr['catg_slug']){$selected = 'selected';} else{$selected='';}
			 $scat_html =$scat_html.'<option value="'.$category->slug.'" '.$selected.'>'.$category->name.'</option>';
		  } 
	?>
		  <p><label for=""><?php _e('Select Category for Slider:','testimonial-slider'); ?> </label></p>
<?php
//slider names Select Option
global $testimonial_slider;
if(isset($testimonial_slider['multiple_sliders']) && $testimonial_slider['multiple_sliders']== '1') {	
			$slider_id = $testimonial_slider_curr['slider_id'];	
			$sliders = testimonial_ss_get_sliders();
			$sname_html='<option value="0" selected >Select the Slider</option>';
	 		
		  foreach ($sliders as $slider) { 
			 if($slider['slider_id']==$slider_id){$selected = 'selected';} else{$selected='';}
			 $sname_html =$sname_html.'<option value="'.$slider['slider_id'].'" '.$selected.'>'.$slider['slider_name'].'</option>';
		  } 
}
?>
<tr valign="top" class="testimonial_slider_params"> 
<th scope="row"><?php _e('Preview Slider Params','testimonial-slider'); ?></th> 
<td><fieldset><legend class="screen-reader-text"><span><?php _e('Preview Slider Params','testimonial-slider'); ?></span></legend> 

<label for="<?php echo $testimonial_slider_options;?>[slider_id]" class="testimonial_sid"><?php _e('Slider ID in case of Custom Slider','testimonial-slider'); ?></label>
<select id="testimonial_slider_id" name="<?php echo $testimonial_slider_options;?>[slider_id]" class="testimonial_sid"><?php echo $sname_html;?></select>

<label for="<?php echo $testimonial_slider_options;?>[catg_slug]" class="testimonial_catslug"><?php _e('Category Slug in case of Testimonial Category Slider','testimonial-slider'); ?></label>
<select name="<?php echo $testimonial_slider_options;?>[catg_slug]" id="testimonial_slider_catslug" class="testimonial_catslug"><?php echo $scat_html;?></select>
</fieldset></td> 
</tr> 

</table>
</div>

<div class="sub_settings_m toggle_settings" id="basic_exmin_tab_9">
<h2 class="sub-heading" id="basic_exmin_9"><?php _e('Shortcode for Testimonial Slider','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<p><?php _e('Paste the below shortcode on Page/Post Edit Panel to get the slider as shown in the above Preview','testimonial-slider'); ?></p><br />
<?php if($cntr=='') $s_set='1'; else $s_set=$cntr;
if ($testimonial_slider_curr['preview'] == "0")
	$preview = '[testimonialslider id="'.$testimonial_slider_curr['slider_id'].'" set="'.$s_set.'"]';
elseif($testimonial_slider_curr['preview'] == "1")
	$preview = '[testimonialcategory catg_slug="'.$testimonial_slider_curr['catg_slug'].'" set="'.$s_set.'"]';
else
	$preview = '[testimonialrecent set="'.$s_set.'"]';
echo "<p>".$preview."</p>";
?>
</div>

<div class="sub_settings_m toggle_settings" id="basic_exmin_tab_10">
<h2 class="sub-heading" id="basic_exmin_10"><?php _e('Template Tag for Testimonial Slider','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<p><?php _e('Paste the below template tag in your theme template file like index.php or page.php at required location to get the slider as shown in the above Preview','testimonial-slider'); ?></p><br />
<?php 
if ($testimonial_slider_curr['preview'] == "0")
	echo '<code>&lt;?php if(function_exists("get_testimonial_slider")){get_testimonial_slider($slider_id="'.$testimonial_slider_curr['slider_id'].'",$set="'.$s_set.'");}?&gt;</code>';
elseif($testimonial_slider_curr['preview'] == "1")
	echo '<code>&lt;?php if(function_exists("get_testimonial_slider_category")){get_testimonial_slider_category($catg_slug="'.$testimonial_slider_curr['catg_slug'].'",$set="'.$s_set.'");}?&gt;</code>';
else
	echo '<code>&lt;?php if(function_exists("get_testimonial_slider_recent")){get_testimonial_slider_recent($set="'.$s_set.'");}?&gt;</code>';
?>
</div>

<div class="sub_settings_m toggle_settings" id="basic_exmin_tab_11">
<h2 class="sub-heading" id="basic_exmin_11"><?php _e('Shortcode for Testimonials List','testimonial-slider'); ?><img src="<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>" id="minmax_img" class="toggle_img"></h2> 
<p><?php _e('Paste the below shortcode on Page/Post Edit Panel to get the list of Testimonials in the above Preview Testimonial Slider','testimonial-slider'); ?></p><br />
<p>
<?php if($cntr=='') $s_set='1'; else $s_set=$cntr;
if ($testimonial_slider_curr['preview'] == "0")
	echo '[testimonialCustomList id="'.$testimonial_slider_curr['slider_id'].'" set="'.$s_set.'"]';
elseif($testimonial_slider_curr['preview'] == "1")
	echo '[testimonialListCategory catg_slug="'.$testimonial_slider_curr['catg_slug'].'" set="'.$s_set.'"]';
else
	echo '[testimonialList set="'.$s_set.'"]';
?>
</p>
</div>

</div><!-- preview tab ends-->

<div class="svilla_cl"></div><div class="svilla_cr"></div>
</div> <!--end of tabs -->

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes ') ?>" />
</p>

<input type="hidden" name="<?php echo $testimonial_slider_options;?>[active_tab]" id="testimonial_activetab" value="<?php echo $testimonial_slider_curr['active_tab']; ?>" />
<input type="hidden" name="testimonial_slider_options[reviewme]" id="testimonial_reviewme" value="<?php echo $testimonial_slider_curr['reviewme']; ?>" /> 
<input type="hidden" name="<?php echo $testimonial_slider_options;?>[new]" id="testimonial_new_set" value="0" />
<input type="hidden" name="<?php echo $testimonial_slider_options;?>[popup]" id="testimonialpopup" value="<?php echo $testimonial_slider_curr['popup']; ?>" />
<input type="hidden" name="oldnew" id="oldnew" value="<?php echo $testimonial_slider_curr['new']; ?>" />
<input type="hidden" name="hidden_preview" id="hidden_preview" value="<?php echo $testimonial_slider_curr['preview']; ?>" />
<input type="hidden" name="hidden_category" id="hidden_category" value="<?php echo $testimonial_slider_curr['catg_slug']; ?>" />
<input type="hidden" name="hidden_sliderid" id="hidden_sliderid" value="<?php echo $testimonial_slider_curr['slider_id']; ?>" />
</form>

<div id="saveResult"></div>
<!--Form to reset Settings set-->
<form style="float:left;" action="" method="post">
<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e('Reset Settings to','testimonial-slider'); ?></th>
<td><select name="testimonial_reset_settings" id="testimonial_slider_reset_settings">
<option value="n" selected ><?php _e('None','testimonial-slider'); ?></option>
<option value="g" ><?php _e('Global Default','testimonial-slider'); ?></option>
<?php 
$directory = TESTIMONIAL_SLIDER_CSS_DIR;
if ($handle = opendir($directory)) {
    while (false !== ($file = readdir($handle))) { 
     if($file != '.' and $file != '..') { ?>
      <option value="<?php echo $file;?>"><?php echo $file;?></option>
 <?php 
	} }
    closedir($handle);
}
?>
<?php 
for($i=1;$i<=$scounter;$i++){
	if ($i==1){
	  echo '<option value="'.$i.'" >'.__('Default Settings Set','testimonial-slider').'</option>';
	}
	else {
	  if($settings_set=get_option('testimonial_slider_options'.$i)){
		echo '<option value="'.$i.'" >'.$settings_set['setname'].' (ID '.$i.')</option>';
	  }
	}
}
?>

</select>
</td>
</tr>
</table>

<p class="submit">
<input name="testimonial_reset_settings_submit" type="submit" class="button-primary" value="<?php _e('Reset Settings') ?>" />
</p>
</form>

<div class="svilla_cl"></div>

<div style="border:1px solid #ccc;padding:10px;background:#fff;margin:0;" id="import">
<?php echo $imported_settings_message;?>
<h3><?php _e('Import Settings Set by uploading a Settings File','testimonial-slider'); ?></h3>
<form style="margin-right:10px;font-size:14px;" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
<input type="file" name="settings_file" id="settings_file" style="font-size:13px;width:50%;padding:0 5px;" />
<input type="submit" value="Import" name="import"  onclick="return confirmSettingsImport()" title="<?php _e('Import Settings from a file','testimonial-slider'); ?>" class="button-primary" />
</form>
</div>

<?php 
	$now=strtotime("now");
	$testimonial_slider = get_option('testimonial_slider_options');
	$reviewme=$testimonial_slider_curr['reviewme'];
        if($reviewme!=0 and $reviewme<$now) {
		echo "<div id='reviewme' style='border:1px solid #ccc;padding:10px;background:#fff;margin-top:2%;float: left;width: 95%;'>
		<p>".__('Hey, I noticed you have created an awesome slider using Testimonial Slider and using it for more than a week. Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.', 'testimonial-slider')."</p>
		<p>".__("~ Tejaswini from SliderVilla","testimonial-slider")."</p>
			<ul><li><a href='//wordpress.org/support/view/plugin-reviews/testimonial-slider?filter=5' target='_blank' title='".__('Please review and rate Testimonial Slider on WordPress.org', 'testimonial-slider')."'>".__('Ok, you deserve it', 'testimonial-slider')."</a></li>
			<li><a id='later' href='#' title='".__('Rate Testimonial Slider at some other time!', 'testimonial-slider')."'>".__('Nope, maybe later', 'testimonial-slider')."</a></li>
			<li><a id='already' href='#' title='".__('Click this if you have already rated us 5-star!', 'testimonial-slider')."'>".__('I already did', 'testimonial-slider'). "</a></li></ul></div>";
   }
?>

</div> <!--end of float left -->

<script type="text/javascript">
<?php 
$directory = TESTIMONIAL_SLIDER_CSS_DIR;
if ($handle = opendir($directory)) {
    while (false !== ($file = readdir($handle))) { 
     if($file != '.' and $file != '..') { 
	$default_settings_str='default_settings_'.$file;
	global ${$default_settings_str};
      	echo 'var '.$default_settings_str.' = '.json_encode(${$default_settings_str}).';';
 } }
    closedir($handle);
}
?>
/* To populate Skin Specific attributes */
function checkskin(skin){ 
	var skin_array = window['default_settings_'+skin];       
	for (var key in skin_array) {
		var html_element='testimonial_slider_'+key;
		document.getElementById(html_element).value = skin_array[key];
	}
	
}
function resetSkin(skin){  
	document.getElementById("testimonial_slider_stylesheet").value= skin; 
	var skin_array = window['default_settings_'+skin];       
	for (var key in skin_array) {
		var html_element='testimonial_slider_'+key;
		document.getElementById(html_element).value = skin_array[key];
	}		
}
/* Radius Show/Hide */
function show_radius() {
	jQuery("#tr_avatar_radius").show();
}
function hide_radius() {
	jQuery("#tr_avatar_radius").hide();
}
// <!-- Added for validations - start -->
jQuery(document).ready(function($) {
	<?php if(isset($_GET['settings-updated'])) { if($_GET['settings-updated'] == 'true' and $testimonial_slider_curr['popup'] == '1' ) { 
?>
jQuery('#saveResult').html("<div id='popup'><div class='modal_shortcode'>Quick Embed Shortcode</div><span class='button b-close'><span>X</span></span></div>");
				jQuery('#popup').append('<div class="modal_preview"><?php echo $preview;?></div>');				
				jQuery('#popup').bPopup({
		    			opacity: 0.6,
					position: ['35%', '35%'],
		    			positionStyle: 'fixed', //'fixed' or 'absolute'			
					onClose: function() { return true; }
				});

<?php }} ?>

/* Added for settings page minimize and maximize - start */
//Basic tab
jQuery("#swithOn").on("click", function(){
	jQuery("#swithOn").addClass("onSelected");
	if (jQuery('#swithOff').hasClass('offSelected')) {
		jQuery("#swithOff").removeClass("offSelected");
	} 
	   jQuery("#onOffVal").val( 1 );
	  
});
jQuery("#swithOff").on("click", function(){
	jQuery("#swithOff").addClass("offSelected");
	if (jQuery('#swithOn').hasClass('onSelected')) {
		jQuery("#swithOn").removeClass("onSelected");
	}
	jQuery("#onOffVal").val( 0 );
});

jQuery("#showArrow").on("click", function(){
	jQuery("#showArrow").addClass("onSelected");
	if (jQuery('#hideArrow').hasClass('offSelected')) {
		jQuery("#hideArrow").removeClass("offSelected");
	} 
	   jQuery("#showHideArrow").val( 0 );
	  
});
jQuery("#hideArrow").on("click", function(){
	jQuery("#hideArrow").addClass("offSelected");
	if (jQuery('#showArrow').hasClass('onSelected')) {
		jQuery("#showArrow").removeClass("onSelected");
	}
	jQuery("#showHideArrow").val( 1 );
});

jQuery(this).find(".sub-heading").on("click", function(){
	var wrap=jQuery(this).parent(".toggle_settings"),
	tabcontent=wrap.find("p, table, code");
	tabcontent.toggle();
	var imgclass=jQuery(this).find(".toggle_img");
	if (tabcontent.css('display') == 'none') {
		imgclass.attr("src", imgclass.attr("src").replace("<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>", "<?php echo testimonial_slider_plugin_url( 'images/info.png' ); ?>"));
	} else {
		imgclass.attr("src", imgclass.attr("src").replace("<?php echo testimonial_slider_plugin_url( 'images/info.png' ); ?>", "<?php echo testimonial_slider_plugin_url( 'images/close.png' ); ?>"));
	}
});

	jQuery('#testimonial_slider_form').submit(function(event) { 
			/* Added for validations - Start */	
			var speed=jQuery("#testimonial_slider_speed").val();
			if(speed=='' || speed <= 0 || isNaN(speed)) {
					alert("Speed of Transition should be a number greater than 0!"); 
					jQuery("#testimonial_slider_speed").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_speed').offset().top-50}, 600);
					return false;
				}	
			var time=jQuery("#testimonial_slider_time").val();
			if(time=='' || time <= 0 || isNaN(time)) {
					alert("Time between Transitions should be a number greater than 0!"); 
					jQuery("#testimonial_slider_time").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_time').offset().top-50}, 600);
					return false;
				}
			var posts=jQuery("#testimonial_slider_no_posts").val();
			if(posts=='' || posts <= 0 || isNaN(posts)) {
					alert("Number of Posts in the testimonial Slider should be a number greater than 0!"); 
					jQuery("#testimonial_slider_no_posts").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_no_posts').offset().top-50}, 600);
					return false;
				}
			var visible=jQuery("#testimonial_slider_visible").val();
			if(visible=='' || visible <= 0 || isNaN(visible)) {
					alert("Number of Items Visible in One Set should be a number greater than 0!"); 
					jQuery("#testimonial_slider_visible").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_visible').offset().top-50}, 600);
					return false;
				}
			var numscroll=jQuery("#testimonial_slider_scroll").val();
			if(numscroll=='' || numscroll <= 0 || isNaN(numscroll)) {
					alert("Number of Items to scroll should be a number greater than 0!"); 
					jQuery("#testimonial_slider_scroll").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_scroll').offset().top-50}, 600);
					return false;
				}
			var width=jQuery("#testimonial_slider_width").val();
			if(width=='' || width < 0 || isNaN(width)) {
					alert("Complete Slider Width should be a number greater than or equal to 0!"); 
					jQuery("#testimonial_slider_width").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_width').offset().top-50}, 600);
					return false;
				}
			var iwidth=jQuery("#testimonial_slider_iwidth").val();
			if(iwidth=='' || iwidth <= 0 || isNaN(iwidth)) {
					alert("Slider Item Width should be a number greater than 0!"); 
					jQuery("#testimonial_slider_iwidth").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_iwidth').offset().top-50}, 600);
					return false;
				}			
			var height=jQuery("#testimonial_slider_height").val();
			if(height=='' || height <= 0 || isNaN(height)) {
					alert("Slider Item Height should be a number greater than 0!"); 
					jQuery("#testimonial_slider_height").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_height').offset().top-50}, 600);
					return false;
				}
			
			/* Added for validations - End */
			var slider_id = jQuery("#testimonial_slider_id").val(),	
			    hiddensliderid=jQuery("#hidden_sliderid").val(),		
			    slider_catslug=jQuery("#testimonial_slider_catslug").val(),
			    hiddencatslug=jQuery("#hidden_category").val(),
			    prev=jQuery("#testimonial_slider_preview").val(),
			    hiddenpreview=jQuery("#hidden_preview").val(),
			    new_save=jQuery("#oldnew").val();
			if(prev=='1' && slider_catslug=='') {
				alert("Category Slug should be mentioned whose posts you want to show!"); 
				jQuery("#testimonial_slider_catslug").addClass('error');
				jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_catslug').offset().top-50}, 600);
				return false;
			}
			if(prev=='0') {
				if(slider_id=='' || isNaN(slider_id) || slider_id<=0){
					alert("Slider ID Should be a number greater than 0!"); 
					jQuery("#testimonial_slider_id").addClass('error');
					jQuery("html,body").animate({scrollTop:jQuery('#testimonial_slider_id').offset().top-50}, 600);
					return false;
				}
			}
			if(hiddenpreview != prev || new_save=='1' || slider_id != hiddensliderid || slider_catslug != hiddencatslug ) jQuery('#testimonialpopup').val("1");					
			else jQuery('#testimonialpopup').val("0");	
		});
	});

</script>

<!-- Added for validations - end -->


<div id="poststuff" class="metabox-holder has-right-sidebar" style="float:left;max-width:270px;"> 
<!-- Right Side Quick Embed Tags -->
<div class="postbox" style="margin:0 0 10px 0;"> 
	<h3 class="hndle"><span></span><?php _e('Quick Embed Shortcode','testimonial-slider'); ?></h3> 
	<div class="inside" id="shortcodeview">
	<?php if($cntr=='') $s_set='1'; else $s_set=$cntr;
if ($testimonial_slider_curr['preview'] == "0")
	echo '[testimonialslider id="'.$testimonial_slider_curr['slider_id'].'" set="'.$s_set.'"]';
elseif($testimonial_slider_curr['preview'] == "1")
	echo '[testimonialcategory catg_slug="'.$testimonial_slider_curr['catg_slug'].'" set="'.$s_set.'"]';
else
	echo '[testimonialrecent set="'.$s_set.'"]';
?>
</div></div>

<div class="postbox" style="margin:10px 0;"> 
	<h3 class="hndle"><span></span><?php _e('Quick Embed Template Tag','testimonial-slider'); ?></h3> 
	<div class="inside">
	<?php 
	if ($testimonial_slider_curr['preview'] == "0")
		echo '<code>&lt;?php if( function_exists( "get_testimonial_slider" ) ){ get_testimonial_slider( $slider_id="'.$testimonial_slider_curr['slider_id'].'",$set="'.$s_set.'") ;}?&gt;</code>';
	elseif($testimonial_slider_curr['preview'] == "1")
		echo '<code>&lt;?php if( function_exists( "get_testimonial_slider_category" ) ){ get_testimonial_slider_category( $catg_slug="'.$testimonial_slider_curr['catg_slug'].'",$set="'.$s_set.'") ;}?&gt;</code>';
	else
		echo '<code>&lt;?php if( function_exists( "get_testimonial_slider_recent" ) ){ get_testimonial_slider_recent( $set="'.$s_set.'") ;}?&gt;</code>';
?>
</div></div>
<!-- End Quick Embed Tags -->

<?php $url = testimonial_sslider_admin_url( array( 'page' => 'testimonial-slider-admin' ) );?>
<form style="margin-right:10px;font-size:14px;width:100%;" action="" method="post">
<a href="<?php echo $url; ?>" title="<?php _e('Go to Sliders page where you can re-order the slide posts, delete the slides from the slider etc.','testimonial-slider'); ?>" class="svilla_button svilla_gray_button"><?php _e('Go to Sliders Admin','testimonial-slider'); ?></a>
<input type="submit" class="svilla_button" value="Create New Settings Set" name="create_set"  onclick="return confirmSettingsCreate()" /> <br />
<input type="submit" value="Export" name="export" title="<?php _e('Export this Settings Set to a file','testimonial-slider'); ?>" class="svilla_button" />
<a href="#import" title="<?php _e('Go to Import Settings Form','testimonial-slider'); ?>" class="svilla_button">Import</a>
<div class="svilla_cl"></div>
</form>
<div class="svilla_cl"></div>

<div class="postbox" style="margin:10px 0;"> 
			  <h3 class="hndle"><span></span><?php _e('Available Settings Sets','testimonial-slider'); ?></h3> 
			  <div class="inside">
<?php 
for($i=1;$i<=$scounter;$i++){
   if ($i==1){
      echo '<h4><a href="'.testimonial_sslider_admin_url( array( 'page' => 'testimonial-slider-settings' ) ).'" title="(Settings Set ID '.$i.')">Default Settings (ID '.$i.')</a></h4>';
   }
   else {
      if($settings_set=get_option('testimonial_slider_options'.$i)){
		echo '<h4><a href="'.testimonial_sslider_admin_url( array( 'page' => 'testimonial-slider-settings' ) ).'&scounter='.$i.'" title="(Settings Set ID '.$i.')">'.$settings_set['setname'].' (ID '.$i.')</a></h4>';
	  }
   }
}
?>
</div></div>

<div class="postbox"> 
<div style="background:#eee;line-height:200%"><a style="text-decoration:none;font-weight:bold;font-size:100%;color:#990000" href="//guides.slidervilla.com/testimonial-slider/" title="Click here to read how to use the plugin and frequently asked questions about the plugin" target="_blank"> ==> <?php _e('Usage Guide and General FAQs','testimonial-slider'); ?></a></div>
</div>

<?php if ($testimonial_slider['support'] == "1"){ ?>
    
     		<div class="postbox" style="margin:10px 0;"> 
				<div class="inside">
				<div style="margin:10px auto;">
							<a href="//slidervilla.com" title="Premium WordPress Slider Plugins" target="_blank"><img src="<?php echo testimonial_slider_plugin_url('images/banner-premium.png');?>" alt="Premium WordPress Slider Plugins" width="100%" /></a>
				</div>
				<p><a href="//slidervilla.com/" title="Recommended WordPress Sliders" target="_blank"><?php _e('SliderVilla slider plugins','testimonial-slider'); ?></a> <?php _e('are feature rich and stylish plugins to embed a nice looking featured content slider in your existing or new theme template. 100% customization options available on WordPress Settings page of the plugin.','testimonial-slider'); ?></p>
						<p><strong><?php _e('Stylish Sliders,','testimonial-slider'); ?> <a href="//slidervilla.com/blog/testimonials/" target="_blank"><?php _e('Happy Customers','testimonial-slider'); ?></a>!</strong></p>
                        <p><a href="//slidervilla.com/" title="Recommended WordPress Sliders" target="_blank"><?php _e('For more info visit SliderVilla','testimonial-slider'); ?></a></p>
            </div></div>
			
			
          
			<div class="postbox"> 
			  <h3 class="hndle"><span><?php _e('About this Plugin:','testimonial-slider'); ?></span></h3> 
			  <div class="inside">
                <ul>
                <li><a href="//slidervilla.com/testimonial-slider/" title="<?php _e('Testimonial Slider Homepage','testimonial-slider'); ?>
" ><?php _e('Plugin Homepage','testimonial-slider'); ?></a></li>
				<li><a href="//support.slidervilla.com/" title="<?php _e('Support Forum','testimonial-slider'); ?>
" ><?php _e('Support Forum','testimonial-slider'); ?></a></li>
				<li><a href="//guides.slidervilla.com/testimonial-slider/" title="<?php _e('Usage Guide','testimonial-slider'); ?>
" ><?php _e('Usage Guide','testimonial-slider'); ?></a></li>
				<li><strong>Current Version: <?php echo TESTIMONIAL_SLIDER_VER;?></strong></li>
                </ul> 
              </div> 
			</div> 
	<?php } ?>
                 
 </div> <!--end of poststuff --> 

<div style="clear:left;"></div>
<div style="clear:right;"></div>

</div> <!--end of float wrap -->
<?php	
}

function register_testimonial_settings() { // whitelist options
  $scounter=get_option('testimonial_slider_scounter');
  for($i=1;$i<=$scounter;$i++){
	   if ($i==1){
		  register_setting( 'testimonial-slider-group', 'testimonial_slider_options' );
	   }
	   else {
	      $group='testimonial-slider-group'.$i;
		  $options='testimonial_slider_options'.$i;
		  register_setting( $group, $options );
	   }
  }
}
?>
