<?php /****************************************************************************************************************************
Plugin Name: Testimonial Slider
Plugin URI: http://slidervilla.com/testimonial-slider/
Description: Use Testimonial Slider to show the awesome testimonials you have received in a beautiful horizontal slider format.
Version: 1.2.5	
Author: SliderVilla
Text Domain: testimonial-slider
Author URI: http://slidervilla.com/
Wordpress version supported: 3.5 and above
License: GPL2
*-----------------------------------------*
Copyright 2008-2017  SliderVilla (email : support@slidervilla.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*-----------------------------------------*
* Developers: Tejaswini (@WebFanzine Media)
* Tested By: Sagar (@WebFanzine Media)
**************************************************************************************************************************************/
//defined global variables and constants here
global $testimonial_slider,$default_testimonial_slider_settings,$testimonial_db_version;
$testimonial_db_version='1.2.4'; //current version of testimonial slider database 
$testimonial_slider = get_option('testimonial_slider_options');
$default_testimonial_slider_settings = array('speed'=>'6', 
	'time'=>'20',
	'no_posts'=>'10',
	'visible'=>'1',
	'scroll'=>'1',
	'type'=>'0',
	'bg_color'=>'#ffffff', 
	'bg'=>'0',
	'height'=>'150',
	'width'=>'300',
	'iwidth'=>'300',
	'border'=>'0',
	'brcolor'=>'#dddddd',
	'prev_next'=>'0',
	'title_text'=>'Featured Articles',
	'title_from'=>'0',
	'title_font'=>'Trebuchet MS,sans-serif',
	'title_fsize'=>'18',
	'title_fstyle'=>'bold',
	'title_fcolor'=>'#3F4C6B',
	'ptitle_font'=>"'Lucida Sans Unicode', 'Lucida Grand', sans-serif;",
	'ptitle_fsize'=>'12',
	'ptitle_fstyle'=>'normal',
	'ptitle_fcolor'=>'#737373',
	'psite_font'=>"'Lucida Sans Unicode', 'Lucida Grand', sans-serif;",
	'psite_fsize'=>'12',
	'psite_fstyle'=>'normal',
	'psite_fcolor'=>'#f16022',
	'img_height'=>'80',
	'img_width'=>'80',
	'img_border'=>'1',
	'img_brcolor'=>'#cccccc',
	'default_avatar'=>'//www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&f=y',
	'content_font'=>"'Lucida Sans Unicode', 'Lucida Grand', sans-serif;",
	'content_fsize'=>'12',
	'content_fstyle'=>'italic',
	'content_fcolor'=>'#737373',
	'content_from'=>'content',
	'content_limit'=>'100',
	'show_star'=>'1',
	'star_color'=>'#f1c40f',
	'star_size'=>'18',
	'allowable_tags'=>'',
	'more'=>'',
	'a_attr'=>'',
	'user_level'=>'edit_others_posts',
	'crop'=>'0',
	'transition'=>'scroll',
	'easing'=>'swing',
	'disable_autostep'=>'0',
	'multiple_sliders'=>'1',
	'stylesheet'=>'default',
	'shortcode'=>'1',
	'rand'=>'0',
	'preview'=>'2',
	'slider_id'=>'1',
	'catg_slug'=>'',
	'fields'=>'',
	'ver'=>'1',
	'support'=>'1',
	'fouc'=>'0',
	'buttons'=>'default',
	'navbottom'=>'0',
	'navnum'=>'1',
	'navimg_w'=>'16',
	'navimg_h'=>'16',
	'css'=>'',
	'new'=>'1',
	'popup'=>'1',
	'setname'=>'Set',
	'disable_preview'=>'0',
	'nav_color'=>'#999',
	'active_tab'=>'0',
	'show_avatar'=> '1',
	'avatar_shape'=> 'square',
	'avatar_radius'=>'0',
	'noscript'=>'This page is having a slideshow that uses Javascript. Your browser either doesn\'t support Javascript or you have it turned off. To see this page as it is meant to appear please use a Javascript enabled browser.',
	'reviewme'=>strtotime("+1 week")
);
define('TESTIMONIAL_SLIDER_TABLE','testimonial_slider'); //Slider TABLE NAME
define('TESTIMONIAL_SLIDER_META','testimonial_slider_meta'); //Meta TABLE NAME
define('TESTIMONIAL_SLIDER_POST_META','testimonial_slider_postmeta'); //Meta TABLE NAME
define("TESTIMONIAL_SLIDER_VER","1.2.5",false);//Current Version of Testimonial Slider
if ( ! defined( 'TESTIMONIAL_SLIDER_PLUGIN_BASENAME' ) )
	define( 'TESTIMONIAL_SLIDER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'TESTIMONIAL_SLIDER_CSS_DIR' ) ){
	define( 'TESTIMONIAL_SLIDER_CSS_DIR', WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/css/skins/' );
}
// Create Text Domain For Translations
load_plugin_textdomain('testimonial-slider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

function install_testimonial_slider() {
	global $wpdb, $table_prefix,$testimonial_db_version;
	$installed_ver = get_option( "testimonial_db_version" );
	if( $installed_ver != $testimonial_db_version ) {
		$table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
		if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
			$sql = "CREATE TABLE $table_name (
						id int(5) NOT NULL AUTO_INCREMENT,
						post_id int(11) NOT NULL,
						date datetime NOT NULL,
						slider_id int(5) NOT NULL DEFAULT '1',
						slide_order int(5) NOT NULL DEFAULT '0',
						UNIQUE KEY id(id)
					);";
			$rs = $wpdb->query($sql);
		}
	   	$meta_table_name = $table_prefix.TESTIMONIAL_SLIDER_META;
		if($wpdb->get_var("show tables like '$meta_table_name'") != $meta_table_name) {
			$sql = "CREATE TABLE $meta_table_name (
						slider_id int(5) NOT NULL AUTO_INCREMENT,
						slider_name varchar(100) NOT NULL default '',
						UNIQUE KEY slider_id(slider_id)
					);";
			$rs2 = $wpdb->query($sql);
		
			$wpdb->insert($meta_table_name, array('slider_id' => 1, 'slider_name' => 'Testimonial Slider'), array('%d', '%s'));
		}
	
		$slider_postmeta = $table_prefix.TESTIMONIAL_SLIDER_POST_META;
		if($wpdb->get_var("show tables like '$slider_postmeta'") != $slider_postmeta) {
			$sql = "CREATE TABLE $slider_postmeta (
						post_id int(11) NOT NULL,
						slider_id int(5) NOT NULL default '1',
						UNIQUE KEY post_id(post_id)
					);";
			$rs4 = $wpdb->query($sql);
		}
	   // Testimonial Slider Settings and Options
	   $default_slider = array();
	   global $default_testimonial_slider_settings;
	   $default_slider = $default_testimonial_slider_settings;
	   
	   	      	   $default_scounter='1';
		   $scounter=get_option('testimonial_slider_scounter');
		   if(!isset($scounter) or $scounter=='' or empty($scounter)){
		      update_option('testimonial_slider_scounter',$default_scounter);
			  $scounter=$default_scounter;
		   }
		   
		   for($i=1;$i<=$scounter;$i++){
		       if ($i==1){
			    $testimonial_slider_options='testimonial_slider_options';
			   }
			   else{
			    $testimonial_slider_options='testimonial_slider_options'.$i;
			   }
			   $testimonial_slider_curr=get_option($testimonial_slider_options);
		   				 
			   if(!$testimonial_slider_curr and $i==1) {
				 $testimonial_slider_curr = array();
			   }
		
			   if($testimonial_slider_curr or $i==1) {
				   foreach($default_slider as $key=>$value) {
					  if(!isset($testimonial_slider_curr[$key])) {
						 $testimonial_slider_curr[$key] = $value;
					  }
				   }
				   update_option($testimonial_slider_options,$testimonial_slider_curr);
				   update_option( "testimonial_db_version", $testimonial_db_version );
			   }
		   } //end for loop
	}
}
register_activation_hook( __FILE__, 'install_testimonial_slider' );
/* Added for auto update - start */
function testimonial_update_db_check() {
	global $testimonial_db_version;
	if (get_option('testimonial_db_version') != $testimonial_db_version) {
		install_testimonial_slider();
	}
	/* Check whether Testimonials Options are created (if not) add options */
	if(get_option('testimonial_slider_options') == false) {
		global $default_testimonial_slider_settings;
		add_option('testimonial_slider_options',$default_testimonial_slider_settings);
	}
}
add_action('plugins_loaded', 'testimonial_update_db_check');

require_once (dirname (__FILE__) . '/includes/testimonial-slider-functions.php');

//This adds the post to the slider
function testimonial_add_to_slider($post_id) {
	global $testimonial_slider;
	if(isset($_POST['testimonial-sldr-verify']) and current_user_can( $testimonial_slider['user_level'] ) ) {
		global $wpdb, $table_prefix, $post;
		$table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
	
		if(isset($_POST['testimonial-slider']) and !isset($_POST['testimonial_slider_name'])) {
	  		$slider_id = '1';
			if(is_post_on_any_testimonial_slider($post_id)){
				$wpdb->delete($table_name, array('post_id' => $post_id), array('%d'));
			}
	  		if(isset($_POST['testimonial-slider']) and $_POST['testimonial-slider'] == "testimonial-slider" and !testimonial_slider($post_id,$slider_id)) {
				$dt = date('Y-m-d H:i:s');
				$wpdb->insert($table_name, array('post_id' => $post_id, 'date' => $dt, 'slider_id' => $slider_id), array('%d', '%s', '%d'));
			}
		}
		if(isset($_POST['testimonial-slider']) and $_POST['testimonial-slider'] == "testimonial-slider" and isset($_POST['testimonial_slider_name'])) {
			$slider_id_arr = $_POST['testimonial_slider_name'];
			$post_sliders_data = testimonial_ss_get_post_sliders($post_id);
	  
			foreach($post_sliders_data as $post_slider_data){
				if(!in_array($post_slider_data['slider_id'],$slider_id_arr)) {
					$wpdb->delete($table_name, array('post_id' => $post_id), array('%d'));
				}
			}

			foreach($slider_id_arr as $slider_id) {
				if(!testimonial_slider($post_id,$slider_id)) {
					$dt = date('Y-m-d H:i:s');
					$wpdb->insert($table_name, array('post_id' => $post_id, 'date' => $dt, 'slider_id' => $slider_id), array('%d', '%s', '%d'));
				}
			}
		}
		$table_name = $table_prefix.TESTIMONIAL_SLIDER_POST_META;
		if(isset($_POST['testimonial_display_slider']) and !isset($_POST['testimonial_display_slider_name'])) {
			$slider_id = '1';
		}
		if(isset($_POST['testimonial_display_slider']) and isset($_POST['testimonial_display_slider_name'])){
		  $slider_id = $_POST['testimonial_display_slider_name'];
		}
	  	if(isset($_POST['testimonial_display_slider'])){	
			if(!testimonial_ss_post_on_slider($post_id,$slider_id)) {
				$wpdb->delete($table_name, array('post_id' => $post_id), array('%d'));
				$wpdb->insert($table_name, array('post_id' => $post_id, 'slider_id' => $slider_id), array('%d', '%d'));
			}
		}
	
		$_testimonial_by = get_post_meta($post_id,'_testimonial_by',true);
		$post_testimonial_by = $_POST['_testimonial_by'];
		if($_testimonial_by!= $post_testimonial_by) {
		  update_post_meta($post_id, '_testimonial_by', $post_testimonial_by);	
		}

		$_testimonial_avatar = get_post_meta($post_id,'_testimonial_avatar',true);
		$post_testimonial_avatar = $_POST['_testimonial_avatar'];
		if($_testimonial_avatar!= $post_testimonial_avatar) {
		  update_post_meta($post_id, '_testimonial_avatar', $post_testimonial_avatar);	
		}

		$_testimonial_site = get_post_meta($post_id,'_testimonial_site',true);
		$post_testimonial_site = $_POST['_testimonial_site'];
		if($_testimonial_site!= $post_testimonial_site) {
		  update_post_meta($post_id, '_testimonial_site', $post_testimonial_site);	
		}

		$_testimonial_siteurl = get_post_meta($post_id,'_testimonial_siteurl',true);
		$post_testimonial_siteurl = $_POST['_testimonial_siteurl'];
		if($_testimonial_siteurl!= $post_testimonial_siteurl) {
		  update_post_meta($post_id, '_testimonial_siteurl', $post_testimonial_siteurl);	
		}
		// Added for star rating
		$testimonial_star = get_post_meta($post_id,'_testimonial_star',true);
		$post_testimonial_star = $_POST['testimonial_star'];
		if($testimonial_star!= $post_testimonial_star) {
			update_post_meta($post_id, '_testimonial_star', $post_testimonial_star);	
		}

		$testimonial_link_attr = get_post_meta($post_id,'testimonial_link_attr',true);
		$link_attr=htmlentities($_POST['testimonial_link_attr'],ENT_QUOTES);
		if($testimonial_link_attr != $link_attr) {
		  update_post_meta($post_id, 'testimonial_link_attr', $link_attr);	
		}

		$testimonial_sslider_link = get_post_meta($post_id,'testimonial_slide_redirect_url',true);
		$link=$_POST['testimonial_sslider_link'];
		if($testimonial_sslider_link != $link) {
		  update_post_meta($post_id, 'testimonial_slide_redirect_url', $link);	
		}

		$_testimonial_sslider_nolink = get_post_meta($post_id,'_testimonial_sslider_nolink',true);
		$post__testimonial_sslider_nolink = $_POST['_testimonial_sslider_nolink'];
		if($_testimonial_sslider_nolink != $post__testimonial_sslider_nolink) {
		  update_post_meta($post_id, '_testimonial_sslider_nolink', $post__testimonial_sslider_nolink);	
		}
	
  	} //testimonial-sldr-verify
}

//Removes the post from the slider, if you uncheck the checkbox from the edit post screen
function testimonial_remove_from_slider($post_id) {
	if(isset($_POST['testimonial-sldr-verify'])) {
		global $wpdb, $table_prefix;
		$table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
	
		// authorization
		if (!current_user_can('edit_post', $post_id))
			return $post_id;
		// origination and intention
		if (!wp_verify_nonce($_POST['testimonial-sldr-verify'], 'TestimonialSlider'))
			return $post_id;
	
	    if(empty($_POST['testimonial-slider']) and is_post_on_any_testimonial_slider($post_id)) {
			$wpdb->delete($table_name, array('post_id' => $post_id), array('%d'));
		}
	
		$display_slider = $_POST['testimonial_display_slider'];
		$table_name = $table_prefix.TESTIMONIAL_SLIDER_POST_META;
		if(empty($display_slider) and testimonial_ss_slider_on_this_post($post_id)){
		  $wpdb->delete($table_name, array('post_id' => $post_id), array('%d'));
		}
	}
} 
  
function testimonial_delete_from_slider_table($post_id){
    global $wpdb, $table_prefix;
	$table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
    if(is_post_on_any_testimonial_slider($post_id)) {
		$wpdb->delete($table_name, array('post_id' => $post_id), array('%d'));
	}
	$table_name = $table_prefix.TESTIMONIAL_SLIDER_POST_META;
    if(testimonial_ss_slider_on_this_post($post_id)) {
		$wpdb->delete($table_name, array('post_id' => $post_id), array('%d'));
	}
}

// Slider checkbox on the admin page

function testimonial_slider_edit_custom_box(){
   testimonial_add_to_slider_checkbox();
}

function testimonial_slider_add_custom_box() {
	global $testimonial_slider;
	if (current_user_can( $testimonial_slider['user_level'] )) {
		if( function_exists( 'add_meta_box' ) ) {
			add_meta_box( 'testimonial_slider_box', __( 'Testimonial Slider' , 'testimonial-slider'), 'testimonial_slider_edit_custom_box', 'testimonial', 'advanced' );
		} 
	}
}
/* Use the admin_menu action to define the custom boxes */
add_action('admin_menu', 'testimonial_slider_add_custom_box');

function testimonial_add_to_slider_checkbox() {
	global $post, $testimonial_slider;
	if (current_user_can( $testimonial_slider['user_level'] )) {
		$extra = "";
		$post_id = $post->ID;
		
		if(isset($post->ID)) {
			$post_id = $post->ID;
			if(is_post_on_any_testimonial_slider($post_id)) { $extra = 'checked="checked"'; }
		} 
		$post_slider_arr = array();
		$post_sliders = testimonial_ss_get_post_sliders($post_id);
		if($post_sliders) {
			foreach($post_sliders as $post_slider){
			   $post_slider_arr[] = $post_slider['slider_id'];
			}
		}
		$sliders = testimonial_ss_get_sliders();
		?>
		<div class="slider_checkbox">
			<table class="form-table">
				
			<tr valign="top">
				<th scope="row"><input type="checkbox" class="sldr_post" name="testimonial-slider" value="testimonial-slider" <?php echo $extra;?> />
				<label for="testimonial-slider"><?php _e('Add this Testimonial to','testimonial-slider'); ?> </label></th>
				<td><select name="testimonial_slider_name[]" multiple="multiple" size="3" >
                <?php foreach ($sliders as $slider) { ?>
                  <option value="<?php echo $slider['slider_id'];?>" <?php if(in_array($slider['slider_id'],$post_slider_arr)){echo 'selected';} ?>><?php echo $slider['slider_name'];?></option>
                <?php } ?>
                </select>
				<input type="hidden" name="testimonial-sldr-verify" id="testimonial-sldr-verify" value="<?php echo wp_create_nonce('TestimonialSlider');?>" />
				</td>
			</tr>
	    	</div>
       		<div>
        	<?php 		
			$_testimonial_by=get_post_meta($post_id, '_testimonial_by', true);
			$_testimonial_avatar=get_post_meta($post_id, '_testimonial_avatar', true);
			$_testimonial_site=get_post_meta($post_id, '_testimonial_site', true);
			$_testimonial_siteurl=get_post_meta($post_id, '_testimonial_siteurl', true);
			$testimonial_star=get_post_meta($post_id, '_testimonial_star', true);
			$testimonial_sslider_link= get_post_meta($post_id, 'testimonial_slide_redirect_url', true);  
			$_testimonial_sslider_nolink=get_post_meta($post_id, '_testimonial_sslider_nolink', true);
			$testimonial_link_attr=get_post_meta($post_id, 'testimonial_link_attr', true);
  		?>
			<tr valign="top">
				<th scope="row"><label for="_testimonial_by"><?php _e('Customer\'s Name','testimonial-slider'); ?></label></th>
				<td><input type="text" name="_testimonial_by" class="_testimonial_by" value="<?php echo $_testimonial_by;?>" size="50" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="_testimonial_avatar"><?php _e('Customer\'s Avatar/Image URL','testimonial-slider'); ?></label></th>
				<td><input type="text" name="_testimonial_avatar" id="_testimonial_avatar" class="_testimonial_avatar" value="<?php echo $_testimonial_avatar;?>" size="50" /> &nbsp; <input id="testimonial_upload_avatar_button" type="button" value="<?php _e('Upload Image','testimonial-slider');?>" /></td>
			</tr>
			<script language="JavaScript">
				jQuery(document).ready(function() {
					jQuery('#testimonial_upload_avatar_button').click(function() {
						formfield = jQuery('#_testimonial_avatar').attr('name');
						tb_show('', 'media-upload.php?type=image&TB_iframe=true');
						return false;
					});

					window.send_to_editor = function(html) {
						var imgurl = jQuery(html).attr('src');
						jQuery('#_testimonial_avatar').val(imgurl);
						tb_remove();
					}
					jQuery(".rt-star").click(function() {
						var cntStar = jQuery(this).attr('id');
						for(var i=1; i <= 5; i++) {
							if(i <= cntStar) {
								jQuery("#"+i).removeClass("dashicons-star-empty");
								jQuery("#"+i).addClass("dashicons-star-filled");
							}
							else {
								jQuery("#"+i).removeClass("dashicons-star-filled");
								jQuery("#"+i).addClass("dashicons-star-empty");
							}
						}
						jQuery("input[name='testimonial_star']").val(cntStar);

					});
				});
			</script>
			<tr valign="top">
				<th scope="row"><label for="_testimonial_site"><?php _e('Customer\'s Company Name ','testimonial-slider'); ?></label></th>
				<td><input type="text" name="_testimonial_site" class="_testimonial_site" value="<?php echo $_testimonial_site;?>" size="50" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><label for="_testimonial_siteurl"><?php _e('Customer\'s Website ','testimonial-slider'); ?></label></th>
				<td><input type="text" name="_testimonial_siteurl" class="_testimonial_siteurl" value="<?php echo $_testimonial_siteurl;?>" size="50" /></td>
			</tr>
			
			<tr valign="top">
	        		<th scope="row"><label for="testimonial_star"><?php _e('Star Rating ','testimonial-slider'); ?></label></th>
				<td>
				<?php 		
				for($i = 1; $i <= 5; $i++ ) {
					if($i <= $testimonial_star) { ?>
						<div id="<?php echo $i;?>" class="dashicons dashicons-star-filled rt-star"></div>
					<?php } else { ?>
						<div id="<?php echo $i;?>" class="dashicons dashicons-star-empty rt-star"></div>
				<?php }
				} ?>
				 <input type="hidden" name="testimonial_star" value="<?php echo $testimonial_star;?>" />
				</td>		
	       		</tr>
				
			<tr valign="top">
				<th scope="row"><label for="testimonial_sslider_link"><?php _e('"Read more" URL ','testimonial-slider'); ?></label></th>
				<td><input type="text" name="testimonial_sslider_link" class="testimonial_sslider_link" value="<?php echo $testimonial_sslider_link;?>" size="50" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><label for="_testimonial_sslider_nolink"><?php _e('Do not link this Testimonial to any "Read more" URL','testimonial-slider'); ?> </label></th>
		<td><input type="checkbox" name="_testimonial_sslider_nolink" class="_testimonial_sslider_nolink" value="1" <?php if($_testimonial_sslider_nolink=='1'){echo "checked";}?>  /></td>
			</tr>
			<tr valign="top">
               			<th scope="row"><label for="testimonial_link_attr"><?php _e('Read more" URL (anchor) attributes ','testimonial-slider'); ?></label></th>
                		<td><input type="text" name="testimonial_link_attr" class="testimonial_link_attr" value="<?php echo $testimonial_link_attr;?>" size="50" /><small><?php _e('e.g. target="_blank" rel="external nofollow"','testimonial-slider'); ?></small></td>
			</tr>
		</table>
		</div>
<?php }
}
//CSS for the checkbox on the admin page
function testimonial_slider_checkbox_css() {
?><style type="text/css" media="screen">.slider_checkbox{margin: 5px 0 10px 0;padding:3px;font-weight:bold;}.slider_checkbox input,.slider_checkbox select{font-weight:bold;}.slider_checkbox label,.slider_checkbox input,.slider_checkbox select{vertical-align:top;}</style>
<?php
}

add_action('publish_post', 'testimonial_add_to_slider');
add_action('publish_page', 'testimonial_add_to_slider');
add_action('edit_post', 'testimonial_add_to_slider');
add_action('publish_post', 'testimonial_remove_from_slider');
add_action('edit_post', 'testimonial_remove_from_slider');
add_action('deleted_post','testimonial_delete_from_slider_table');

function testimonial_slider_plugin_url( $path = '' ) {
	return plugins_url( $path, __FILE__ );
}

function testimonial_get_string_limit($output, $max_char)
{
    $output = str_replace(']]>', ']]&gt;', $output);
    $output = strip_tags($output);

  	if ((strlen($output)>$max_char) && ($espacio = strpos($output, " ", $max_char )))
	{
        $output = substr($output, 0, $espacio).'...';
		return $output;
   }
   else
   {
      return $output;
   }
}

add_filter( 'plugin_action_links', 'testimonial_sslider_plugin_action_links', 10, 2 );

function testimonial_sslider_plugin_action_links( $links, $file ) {
	if ( $file != TESTIMONIAL_SLIDER_PLUGIN_BASENAME )
		return $links;

	$url = testimonial_sslider_admin_url( array( 'page' => 'testimonial-slider-settings' ) );

	$settings_link = '<a href="' . esc_attr( $url ) . '">'
		. esc_html( __( 'Settings') ) . '</a>';

	array_unshift( $links, $settings_link );

	return $links;
}

//Create Custom Post Type for Testimonials
//hook into the init action and call create_testimonial_taxonomies when it fires
add_action( 'init', 'create_testimonial_taxonomies', 0 );

//create a taxonomy, Categories for Post Type "Testimonial"
function create_testimonial_taxonomies() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Testimonial Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Testimonial Category', 'taxonomy singular name' ),
  ); 	

  register_taxonomy('testimonial_category',array('testimonial'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'testimonial-category' ),
  ));
}

add_action( 'init', 'testimonial_post_type', 11 );
function testimonial_post_type() {
	$labels = array(
	'name' => _x('Testimonials', 'post type general name'),
	'singular_name' => _x('Testimonial', 'post type singular name'),
	'add_new' => _x('Add New', 'testimonial'),
	'add_new_item' => __('Add New Testimonial'),
	'edit_item' => __('Edit Testimonial'),
	'new_item' => __('New Testimonial'),
	'all_items' => __('All Testimonials'),
	'view_item' => __('View Testimonial'),
	'search_items' => __('Search Testimonials'),
	'not_found' =>  __('No testimonials found'),
	'not_found_in_trash' => __('No testimonials found in Trash'), 
	'parent_item_colon' => '',
	'menu_name' => 'Testimonials'

	);
	$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true, 
	'show_in_menu' => true, 
	'query_var' => true,
	'rewrite' => true,
	'capability_type' => 'post',
	'has_archive' => true, 
	'hierarchical' => false,
	'menu_position' => null,
	'supports' => array('title','editor')
	); 
	register_post_type('testimonial',$args);
}

//add filter to ensure the text Testimonial, or testimonial, is displayed when user updates a testimonial 
add_filter('post_updated_messages', 'testimonial_updated_messages');
function testimonial_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['testimonial'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Testimonial updated. <a href="%s">View testimonial</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Testimonial updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Testimonial restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Testimonial published. <a href="%s">View testimonial</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Testimonial saved.'),
    8 => sprintf( __('Testimonial submitted. <a target="_blank" href="%s">Preview testimonial</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview testimonial</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Testimonial draft updated. <a target="_blank" href="%s">Preview testimonial</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

require_once (dirname (__FILE__) . '/slider_versions/testimonial_1.php');
require_once (dirname (__FILE__) . '/slider_versions/testimonials_list.php');
require_once (dirname (__FILE__) . '/settings/settings.php');
?>
