<?php // This function displays the page content for the Testimonial Slider Options submenu
function testimonial_slider_create_multiple_sliders() {
global $testimonial_slider;
?>

<div class="wrap testimonial_sliders_create" id="testimonial_sliders_create" style="clear:both;">

<h2 class="top_heading"><span><?php _e('Sliders Created','testimonial-slider'); ?></span></h2>
<?php 
if (isset ($_POST['remove_posts_slider'])) {
	if ( isset($_POST['slider_posts'] ) ) {
		global $wpdb, $table_prefix;
		$table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
		$current_slider = intval( $_POST['current_slider_id'] );
		foreach ( $_POST['slider_posts'] as $post_id=>$val ) {
			$sql = "DELETE FROM $table_name WHERE post_id = '$post_id' AND slider_id = '$current_slider' LIMIT 1";
			$wpdb->query($sql);
		}
	}
	if (isset ($_POST['remove_all'])) {
		if ($_POST['remove_all'] == __('Remove All at Once','testimonial-slider')) {
			global $wpdb, $table_prefix;
			$table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
			$current_slider = intval( $_POST['current_slider_id'] );
			if(is_testimonial_slider_on_slider_table($current_slider)) {
				$wpdb->delete($table_name, array('slider_id' => $current_slider), array('%d'));
			}
		}
	}
   if (isset ($_POST['remove_all'])) {
	   if ($_POST['remove_all'] == __('Delete Slider','testimonial-slider')) {
		   $slider_id = intval( $_POST['current_slider_id'] );
		   global $wpdb, $table_prefix;
		   $slider_table = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
		   $slider_meta = $table_prefix.TESTIMONIAL_SLIDER_META;
		   $slider_postmeta = $table_prefix.TESTIMONIAL_SLIDER_POST_META;
		   if(is_testimonial_slider_on_slider_table($slider_id)) {
			$wpdb->delete($slider_table, array('slider_id' => $slider_id), array('%d'));
		   }
		   if(is_testimonial_slider_on_meta_table($slider_id)) {
			$wpdb->delete($slider_meta, array('slider_id' => $slider_id), array('%d'));
		   }
		   if(is_testimonial_slider_on_postmeta_table($slider_id)) {
			$wpdb->delete($slider_postmeta, array('slider_id' => $slider_id), array('%d'));
		   }
	   }
   }
}
if (isset ($_POST['create_new_slider'])) {
   $slider_name = $_POST['new_slider_name'];
   global $wpdb,$table_prefix;
   $slider_meta = $table_prefix.TESTIMONIAL_SLIDER_META;   
   $wpdb->insert( 
		$slider_meta, 
		array(
			'slider_name'=> $slider_name
		), 
		array( 
			'%s'
		) 
	);
}

if (isset ($_POST['reorder_posts_slider'])) {
   $i=1;
   global $wpdb, $table_prefix;
   $table_name = $table_prefix.TESTIMONIAL_SLIDER_TABLE;
   $slider_id = intval( $_POST['current_slider_id'] );
   foreach ($_POST['order'] as $slide_order) {
    $slide_order = intval($slide_order);
    $sql = 'UPDATE '.$table_name.' SET slide_order='.$i.' WHERE post_id='.$slide_order.' and slider_id='.$slider_id;
    $wpdb->query($sql);
    $i++;
  }
}

if ((isset ($_POST['rename_slider'])) and ($_POST['rename_slider'] == __('Rename','testimonial-slider'))) {
	$slider_name = $_POST['rename_slider_to'];
	$slider_id = intval( $_POST['current_slider_id'] );
	if( !empty($slider_name) ) {
		global $wpdb,$table_prefix;
		$slider_meta = $table_prefix.TESTIMONIAL_SLIDER_META;
		$wpdb->update($slider_meta, array('slider_name' => $slider_name), array('slider_id' => $slider_id), array('%s'), array('%d') );
	}
}

?>
<div style="clear:left"></div>
<?php $url = testimonial_sslider_admin_url( array( 'page' => 'testimonial-slider-settings' ) );?>
<a class="svorangebutton" href="<?php echo $url; ?>" title="<?php _e('Settings Page for Testimonial Slider where you can change the color, font etc. for the sliders','testimonial-slider'); ?>"><?php _e('Go to Testimonial Slider Settings page','testimonial-slider'); ?></a>
<div style="clear:right"></div>
<?php $sliders = testimonial_ss_get_sliders(); ?>

<div id="slider_tabs">
        <ul class="ui-tabs" >
        <?php foreach($sliders as $slider){?>
            <li class="yellow"><a href="#tabs-<?php echo $slider['slider_id'];?>"><?php echo $slider['slider_name'];?></a></li>
        <?php } ?>
        <?php if(isset($testimonial_slider['multiple_sliders']) && $testimonial_slider['multiple_sliders'] == '1') {?>
            <li class="green"><a href="#new_slider"><?php _e('Create New Slider','testimonial-slider'); ?></a></li>
        <?php } ?>
        </ul>

<?php foreach($sliders as $slider){?>
<div id="tabs-<?php echo $slider['slider_id'];?>" class="tabsid">
<strong>Quick Embed Shortcode:</strong>
<div class="admin_shortcode">
<pre style="padding: 10px 0;">[testimonialslider id='<?php echo $slider['slider_id'];?>']</pre>
</div>
<form action="" method="post">
<?php settings_fields('testimonial-slider-group'); ?>

<input type="hidden" name="remove_posts_slider" value="1" />
<div id="tabs-<?php echo $slider['slider_id'];?>">
<h3><?php _e('Posts/Pages Added To','testimonial-slider'); ?> <?php echo $slider['slider_name'];?><?php _e('(Slider ID','testimonial-slider'); ?> = <?php echo $slider['slider_id'];?>)</h3>
<p><em><?php _e('Check the Post/Page and Press "Remove Selected" to remove them From','testimonial-slider'); ?> <?php echo $slider['slider_name'];?>. <?php _e('Press "Remove All at Once" to remove all the posts from the','testimonial-slider'); ?> <?php echo $slider['slider_name'];?>.</em></p>

    <table class="widefat">
    <thead class="blue"><tr><th><?php _e('Post/Page Title','testimonial-slider'); ?></th><th><?php _e('Author','testimonial-slider'); ?></th><th><?php _e('Post Date','testimonial-slider'); ?></th><th><?php _e('Remove Post','testimonial-slider'); ?></th></tr></thead><tbody>

<?php  
	$slider_id = $slider['slider_id'];
	$slider_posts=testimonial_get_slider_posts_in_order($slider_id); ?>
	<input type="hidden" name="current_slider_id" value="<?php echo $slider_id;?>" />
    
<?php   $count = 0;	
	foreach($slider_posts as $slider_post) {
	  $slider_arr[] = $slider_post->post_id;
	  $post = get_post($slider_post->post_id);	  
	  if ( in_array($post->ID, $slider_arr) ) {
		  $count++;
		  $sslider_author = get_userdata($post->post_author);
          $sslider_author_dname = $sslider_author->display_name;
		  echo '<tr' . ($count % 2 ? ' class="alternate"' : '') . '><td><strong>' . $post->post_title . '</strong><a href="'.get_edit_post_link( $post->ID, $context = 'display' ).'" target="_blank"> '.__( '(Edit)', 'testimonial-slider' ).'</a> <a href="'.get_permalink( $post->ID ).'" target="_blank"> '.__( '(View)', 'testimonial-slider' ).' </a></td><td>By ' . $sslider_author_dname . '</td><td>' . date('l, F j. Y',strtotime($post->post_date)) . '</td><td><input type="checkbox" name="slider_posts[' . $post->ID . ']" value="1" /></td></tr>'; 
	  }
	}
		
	if ($count == 0) {
		echo '<tr><td colspan="4">'.__( 'No posts/pages have been added to the Slider - You can add respective post/page to slider on the Edit screen for that Post/Page', 'testimonial-slider' ).'</td></tr>';
	}
	echo '</tbody><tfoot class="blue"><tr><th>'.__( 'Post/Page Title', 'testimonial-slider' ).'</th><th>'.__( 'Author', 'testimonial-slider' ).'</th><th>'.__( 'Post Date', 'testimonial-slider' ).'</th><th>'.__( 'Remove Post', 'testimonial-slider' ).'</th></tr></tfoot></table>'; 
    
	echo '<div class="submit">';
	
	if ($count) {echo '<input type="submit" value="'.__( 'Remove Selected', 'testimonial-slider' ).'" onclick="return confirmRemove()" /><input type="submit" name="remove_all" value="'.__( 'Remove All at Once', 'testimonial-slider' ).'" onclick="return confirmRemoveAll()" />';}
	
	if($slider_id != '1') {
	   echo '<input type="submit" value="'.__( 'Delete Slider', 'testimonial-slider' ).'" name="remove_all" onclick="return confirmSliderDelete()" />';
	}
	
	echo '</div>';
?>    
    </tbody></table>
	
	<input type="hidden" name="active_tab" class="testimonial_activetab" value="0" />
	
 </form>
 
 
 <form action="" method="post">
    <input type="hidden" name="reorder_posts_slider" value="1" />
    <h3><?php _e('Reorder the Posts/Pages Added To','testimonial-slider'); ?> <?php echo $slider['slider_name'];?>(Slider ID = <?php echo $slider['slider_id'];?>)</h3>
    <p><em><?php _e('Click on and drag the post/page title to a new spot within the list, and the other items will adjust to fit.','testimonial-slider'); ?> </em></p>
    <ul id="sslider_sortable_<?php echo $slider['slider_id'];?>" style="color:#326078">    
    <?php  
   $slider_id = $slider['slider_id'];
   $slider_posts=testimonial_get_slider_posts_in_order($slider_id);?>
   <input type="hidden" name="current_slider_id" value="<?php echo $slider_id;?>" />
        
    <?php    
    	$count = 0;	
        foreach($slider_posts as $slider_post) {
          $slider_arr[] = $slider_post->post_id;
          $post = get_post($slider_post->post_id);	  
          if ( in_array($post->ID, $slider_arr) ) {
              $count++;
              $sslider_author = get_userdata($post->post_author);
              $sslider_author_dname = $sslider_author->display_name;
              echo '<li id="'.$post->ID.'"><input type="hidden" name="order[]" value="'.$post->ID.'" /><strong> &raquo; &nbsp; ' . $post->post_title . '</strong></li>'; 
          }
        }
            
        if ($count == 0) {
            echo '<li>'.__( 'No posts/pages have been added to the Slider - You can add respective post/page to slider on the Edit screen for that Post/Page', 'testimonial-slider' ).'</li>';
        }
		        
        echo '</ul><div class="submit">';
        
        if ($count) {echo '<input type="submit" value="Save the order"  />';}
                
        echo '</div>';
    ?>    
       </div>     

		<input type="hidden" name="active_tab" class="testimonial_activetab" value="0" />
		
  </form>
  
<form action="" method="post"> 
	<table class="form-table">
		<tr valign="top">
		<th scope="row"><h3><?php _e('Rename Slider to','testimonial-slider'); ?></h3></th>
		<td><h3><input type="text" name="rename_slider_to" class="regular-text" value="<?php echo $slider['slider_name'];?>" /></h3></td>
		</tr>
	</table>
	<input type="hidden" name="current_slider_id" value="<?php echo $slider_id;?>" />
	<input type="submit" value="<?php _e('Rename','testimonial-slider'); ?>"  name="<?php _e('rename_slider','testimonial-slider'); ?>" />
	<input type="hidden" name="active_tab" class="testimonial_activetab" value="0" />
	<input type="hidden" name="testimonial_slider_options[reviewme]" id="testimonial_reviewme" value="<?php echo $testimonial_slider['reviewme']; ?>" /> 
	
</form>
  
</div> 
 
<?php } ?>

<?php if(isset($testimonial_slider['multiple_sliders']) && $testimonial_slider['multiple_sliders'] == '1') {?>
    <div id="new_slider" style="width: 56%;">
    <form action="" method="post" onsubmit="return slider_checkform(this);" >
    <h3><?php _e('Enter New Slider Name','testimonial-slider'); ?></h3>
    <input type="hidden" name="create_new_slider" value="1" />
    
    <input name="new_slider_name" class="regular-text code" value="" style="clear:both;" />
    
    <div class="submit"><input type="submit" value="<?php _e('Create New','testimonial-slider'); ?>" name="create_new" /></div>
    
	<input type="hidden" name="active_tab" class="testimonial_activetab" value="0" />
	
    </form>
    </div>
<?php }?> 

</div>

<div id="poststuff" class="metabox-holder has-right-sidebar poststuffSliders"> 
<?php if ($testimonial_slider['support'] == "1"){ ?>
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
			<li><strong><?php _e('Current Version:','testimonial-slider'); ?> <?php echo TESTIMONIAL_SLIDER_VER;?></strong></li>
		   </ul> 
		   </div> 
	</div>  
	<div class="postbox" style="margin:10px 0;"> 
		<div class="inside">
			<div style="margin:10px auto;">
				<a href="//slidervilla.com" title="Premium WordPress Slider Plugins" target="_blank"><img src="<?php echo testimonial_slider_plugin_url('images/banner-premium.png');?>" alt="Premium WordPress Slider Plugins" width="100%" /></a>
			</div>
		</div>
	</div>
<?php } ?>
     <div style="clear:left;"></div>
 </div> <!--end of poststuff --> 
<?php 
	$now=strtotime("now");
	$testimonial_slider = get_option('testimonial_slider_options');
	$reviewme=$testimonial_slider['reviewme'];
        if($reviewme!=0 and $reviewme<$now) {
		echo "<div id='reviewme' style='border:1px solid #ccc;padding:10px;background:#fff;margin-top:2%;float: left;width: 95%;'>
		<p>".__('Hey, I noticed you have created an awesome slider using Testimonial Slider and using it for more than a week. Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.', 'testimonial-slider')."</p>
		<p>".__("~ Tejaswini from SliderVilla","testimonial-slider")."</p>
			<ul><li><a href='//wordpress.org/support/view/plugin-reviews/testimonial-slider?filter=5' target='_blank' title='".__('Please review and rate Testimonial Slider on WordPress.org', 'testimonial-slider')."'>".__('Ok, you deserve it', 'testimonial-slider')."</a></li>
			<li><a id='later' href='#' title='".__('Rate Testimonial Slider at some other time!', 'testimonial-slider')."'>".__('Nope, maybe later', 'testimonial-slider')."</a></li>
			<li><a id='already' href='#' title='".__('Click this if you have already rated us 5-star!', 'testimonial-slider')."'>".__('I already did', 'testimonial-slider'). "</a></li></ul></div>";
   }
?>
</div> <!--end of float wrap -->
<?php	
}
?>
