<?php

class WonderPlugin_Slider_Creator {

	private $parent_view, $list_table;
	
	function __construct($parent) {
		
		$this->parent_view = $parent;
	}
	
	function render( $id, $config ) {
		
		?>
		
		<?php 
		$config = str_replace("<", "&lt;", $config);
		$config = str_replace(">", "&gt;", $config);
		$config = str_replace("&quot;", "\&quot;", $config);
		?>
		
		<h3><?php _e( 'General Options', 'wonderplugin_slider' ); ?></h3>
		
		<div id="wonderplugin-slider-id" style="display:none;"><?php echo $id; ?></div>
		<div id="wonderplugin-slider-id-config" style="display:none;"><?php echo $config; ?></div>
		<div id="wonderplugin-slider-pluginfolder" style="display:none;"><?php echo WONDERPLUGIN_SLIDER_URL; ?></div>
		<div id="wonderplugin-slider-jsfolder" style="display:none;"><?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?></div>
		<div id="wonderplugin-slider-viewadminurl" style="display:none;"><?php echo admin_url('admin.php?page=wonderplugin_slider_show_item'); ?></div>		
		<div id="wonderplugin-slider-wp-history-media-uploader" style="display:none;"><?php echo ( function_exists("wp_enqueue_media") ? "0" : "1"); ?></div>
		<div id="wonderplugin-slider-ajaxnonce" style="display:none;"><?php echo wp_create_nonce( 'wonderplugin-slider-ajaxnonce' ); ?></div>
		<div id="wonderplugin-slider-saveformnonce" style="display:none;"><?php wp_nonce_field('wonderplugin-slider', 'wonderplugin-slider-saveform'); ?></div>
		<div id="wonderplugin-slider-usepostsave" style="display:none;"><?php echo get_option( 'wonderplugin_slider_usepostsave', 0 ); ?></div>		
		<div id="wonderplugin-slider-addextrabackslash" style="display:none;"><?php echo get_option( 'wonderplugin_slider_addextrabackslash', 0 ); ?></div>
		
		<?php 
			$cats = get_categories();
			$catlist = array();
			foreach ( $cats as $cat )
			{
				$catlist[] = array(
						'ID' => $cat->cat_ID,
						'cat_name' => $cat ->cat_name
				);
			}
		?>
		<div id="wonderplugin-slider-catlist" style="display:none;"><?php echo json_encode($catlist); ?></div>
		
		<?php 
		$custom_post_types = get_post_types( array('_builtin' => false), 'objects' );
	
		$custom_post_list = array();
		foreach($custom_post_types as $custom_post)
		{
			$custom_post_list[] = array(
					'name' => $custom_post->name,
					'taxonomies' => array()
				);
		}

		foreach($custom_post_list as &$custom_post)
		{
			$taxonomies = get_object_taxonomies($custom_post['name'], 'objects');			
			if (!empty($taxonomies))
			{
				
				$taxonomies_list = array();
				foreach($taxonomies as $taxonomy)
				{
					$terms = get_terms($taxonomy->name);
					
					$terms_list = array();
					foreach($terms as $term)
					{
						$terms_list[] = array(
								'name' => $term->name,
								'slug' => $term->slug
							);
					}

					$taxonomies_list[] = array(
							'name' => $taxonomy->name,
							'terms' => $terms_list
						);
				}
				
				$custom_post['taxonomies'] = $taxonomies_list;
			}
		}
		?>
		<div id="wonderplugin-slider-custompostlist" style="display:none;"><?php echo json_encode($custom_post_list); ?></div>
		
		<div style="margin:0 12px;">
		<table class="wonderplugin-form-table">
			<tr>
				<th><?php _e( 'Name', 'wonderplugin_slider' ); ?></th>
				<td><input name="wonderplugin-slider-name" type="text" id="wonderplugin-slider-name" value="My Slider" class="regular-text" /></td>
			</tr>
			<tr>
				<th><?php _e( 'Width', 'wonderplugin_slider' ); ?> / <?php _e( 'Height', 'wonderplugin_slider' ); ?></th>
				<td><input name="wonderplugin-slider-width" type="text" id="wonderplugin-slider-width" value="640" class="small-text" /> / <input name="wonderplugin-slider-height" type="text" id="wonderplugin-slider-height" value="300" class="small-text" /></td>
			</tr>
		</table>
		</div>
		
		<h3><?php _e( 'Designing', 'wonderplugin_slider' ); ?></h3>
		
		<div style="margin:0 12px;">
		<ul class="wonderplugin-tab-buttons" id="wonderplugin-slider-toolbar">
			<li class="wonderplugin-tab-button step1 wonderplugin-tab-buttons-selected"><?php _e( 'Images & Videos', 'wonderplugin_slider' ); ?></li>
			<li class="wonderplugin-tab-button step2"><?php _e( 'Skins', 'wonderplugin_slider' ); ?></li>
			<li class="wonderplugin-tab-button step3"><?php _e( 'Options', 'wonderplugin_slider' ); ?></li>
			<li class="wonderplugin-tab-button step4"><?php _e( 'Preview', 'wonderplugin_slider' ); ?></li>
			<li class="laststep"><input class="button button-primary" type="button" value="<?php _e( 'Save & Publish', 'wonderplugin_slider' ); ?>"></input></li>
		</ul>
				
		<ul class="wonderplugin-tabs" id="wonderplugin-slider-tabs">
			<li class="wonderplugin-tab wonderplugin-tab-selected">	
			
				<div class="wonderplugin-toolbar">	
					<input type="button" class="button" id="wonderplugin-add-image" value="<?php _e( 'Add Image', 'wonderplugin_slider' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-video" value="<?php _e( 'Add Video', 'wonderplugin_slider' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-youtube" value="<?php _e( 'Add YouTube', 'wonderplugin_slider' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-vimeo" value="<?php _e( 'Add Vimeo', 'wonderplugin_slider' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-posts" value="<?php _e( 'Add WordPress Posts', 'wonderplugin_slider' ); ?>" />
					<input type="button" class="button" id="wonderplugin-add-custompost" value="<?php _e( 'Add WooCommerce / Custom Post Type', 'wonderplugin_slider' ); ?>" />
					<label style="float:right;"><input type="button" class="button" id="wonderplugin-reverselist" value="<?php _e( 'Reverse List', 'wonderplugin_slider' ); ?>" /></label>
					<label style="float:right;padding-top:4px;margin-right:8px;"><input type='checkbox' id='wonderplugin-newestfirst' value='' /> Add new item to the beginning</label>
				</div>
        		
        		<ul class="wonderplugin-table" id="wonderplugin-slider-media-table">
			    </ul>
			    <div style="clear:both;"></div>
      
			</li>
			<li class="wonderplugin-tab">
				<form>
					<fieldset>
						
						<?php 
						$skins = array(
								"classic" => "Classic",
								"cube" => "Cube",
								"content" => "Content",
								"elegant" => "Elegant",
								"contentbox" => "ContentBox",
								"events" => "Events",
								"featurelist" => "FeatureList",
								"frontpage" => "Frontpage",
								"mediapage" => "Mediapage",
								"mediagallery" => "Media Gallery",
								"multirows" => "Multirows",
								"gallery" => "Gallery",
								"header" => "Header",
								"lightbox" => "Lightbox",
								"navigator" => "Navigator",
								"numbering" => "Numbering",
								"pink" => "Pink",
								"redandblack" => "Red & Black",
								"rotator" => "Rotator",
								"showcase" => "Showcase",
								"simplicity" => "Simplicity",
								"stylish" => "Stylish",
								"vertical" => "Vertical",
								"verticalnumber" => "VerticalNumber",
								"light" => "Light",
								"rightthumbs" => "Vertical Thumbnails",
								"righttabs" => "Vertical Tabs",
								"righttabsdark" => "Dark Vertical Tabs",
								"thumbnails" => "Thumbnails Slider",
								"textnavigation" => "Text Navigation",
								"simplecontrols" => "Simple Controls",
								"topcarousel" => "Top Carousel",
								"bottomcarousel" => "Bottom Carousel"
								);
						
						$skin_index = 0;
						foreach ($skins as $key => $value) {
							$skin_disabled = (WONDERPLUGIN_SLIDER_VERSION_TYPE == 'L' && $skin_index++ > 2);
						?>
							<div class="wonderplugin-tab-skin<?php if ($skin_disabled) echo " wonderplugin-slider-skin-commercial-only";?>" >
							<label><input type="radio" name="wonderplugin-slider-skin" value="<?php echo $key; ?>" selected <?php if ($skin_disabled) echo "disabled"; ?>> <?php echo $value; ?> <br /><img class="selected" style="width:300px;" src="<?php echo WONDERPLUGIN_SLIDER_URL; ?>images/<?php echo $key; ?>.jpg" /></label>
							<?php if ($skin_disabled) { ?>
								<div class="wonderplugin-slider-skin-commercial-lock"></div>
								<div class="wonderplugin-slider-skin-commercial-textblock"><div class="wonderplugin-slider-skin-commercial-text"><p>This skin is only available in Commercial Version.</p><p><a href="https://www.wonderplugin.com/wordpress-slider/order/?ref=lite" target="_blank">Upgrade to Commercial Version</a></p><p><a href="https://www.wonderplugin.com/wordpress-slider/examples/?ref=lite" target="_blank">View Demos Created with Commercial Version</a></p></div></div>
							<?php }?>
							</div>
						<?php
						}
						?>
						
					</fieldset>
				</form>
			</li>
			<li class="wonderplugin-tab">
			
				<div class="wonderplugin-slider-options">
					<div class="wonderplugin-slider-options-menu" id="wonderplugin-slider-options-menu">
						<div class="wonderplugin-slider-options-menu-item wonderplugin-slider-options-menu-item-selected"><?php _e( 'Slider options', 'wonderplugin_slider' ); ?></div>
						<div class="wonderplugin-slider-options-menu-item"><?php _e( 'Transition effects', 'wonderplugin_slider' ); ?></div>
						<div class="wonderplugin-slider-options-menu-item"><?php _e( 'Skin options', 'wonderplugin_slider' ); ?></div>
						<div class="wonderplugin-slider-options-menu-item"><?php _e( 'Bullets & Thumbnails', 'wonderplugin_slider' ); ?></div>
						<div class="wonderplugin-slider-options-menu-item"><?php _e( 'Text effect', 'wonderplugin_slider' ); ?></div>
						<div class="wonderplugin-slider-options-menu-item"><?php _e( 'Lightbox options', 'wonderplugin_slider' ); ?></div>
						<div class="wonderplugin-slider-options-menu-item"><?php _e( 'Social Media options', 'wonderplugin_slider' ); ?></div>
						<div class="wonderplugin-slider-options-menu-item"><?php _e( 'Advanced options', 'wonderplugin_slider' ); ?></div>
					</div>
					
					<div class="wonderplugin-slider-options-tabs" id="wonderplugin-slider-options-tabs">
						<div class="wonderplugin-slider-options-tab wonderplugin-slider-options-tab-selected">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Slideshow</th>
									<td><label><input name='wonderplugin-slider-autoplay' type='checkbox' id='wonderplugin-slider-autoplay' value='' /> Auto play</label>
									<br /><label><input name='wonderplugin-slider-pauseonmouseover' type='checkbox' id='wonderplugin-slider-pauseonmouseover' value='' /> Pause the slideshow on mouse over</label>
									<br /><label><input name='wonderplugin-slider-randomplay' type='checkbox' id='wonderplugin-slider-randomplay' value='' /> Random play</label>
									<br /><label><input name='wonderplugin-slider-loadimageondemand' type='checkbox' id='wonderplugin-slider-loadimageondemand' value='' /> Load images on demand</label>
									<br /><label><input name='wonderplugin-slider-transitiononfirstslide' type='checkbox' id='wonderplugin-slider-transitiononfirstslide' value='' /> Apply transition to first slide</label>
									</td>
								</tr>
								<tr>
									<th>Video</th>
									<td><label><input name='wonderplugin-slider-autoplayvideo' type='checkbox' id='wonderplugin-slider-autoplayvideo' value='' /> Auto play video</label>
									</td>
								</tr>
								<tr>
									<th>Responsive</th>
									<td><label><input name='wonderplugin-slider-isresponsive' type='checkbox' id='wonderplugin-slider-isresponsive' value='' /> Create a responsive slider</label><br />
									<label><input name='wonderplugin-slider-fullwidth' type='checkbox' id='wonderplugin-slider-fullwidth' value='' /> Create a full width slider</label> &nbsp;&nbsp;
									<label><input name='wonderplugin-slider-isfullscreen' type='checkbox' id='wonderplugin-slider-isfullscreen' value='' /> Extend to the parent container height</label>
									</td>
								</tr>
								<tr>
									<th>Aspect ratio on small screens</th>
									<td><label><input name='wonderplugin-slider-ratioresponsive' type='checkbox' id='wonderplugin-slider-ratioresponsive' value='' /> Change aspect ratio on small screens</label><br />
									<label>Extend height to <input name='wonderplugin-slider-ratiomediumheight' type='number' step='0.1' id='wonderplugin-slider-ratiomediumheight' value='1.2' class="small-text" /> times of the original height when the screen width is less than <input name='wonderplugin-slider-ratiomediumscreen' type='number' id='wonderplugin-slider-ratiomediumscreen' value='900' class="small-text"  /> px</label>
									<br><label>Extend height to <input name='wonderplugin-slider-ratiosmallheight' type='number' step='0.1' id='wonderplugin-slider-ratiosmallheight' value='2' class="small-text" /> times of the original height when the screen width is less than <input name='wonderplugin-slider-ratiosmallscreen' type='number' id='wonderplugin-slider-ratiosmallscreen' value='640' class="small-text"  /> px</label>
									</td>
								</tr>
								<tr>
									<th>Image resize mode</th>
									<td><label>
										<select name='wonderplugin-slider-scalemode' id='wonderplugin-slider-scalemode'>
										  <option value="fit">Resize to fit</option>
										  <option value="fill">Resize to fill</option>
										  <option value="flexheight">Same width, flexible height</option>
										</select>
									</label></td>
								</tr>
								<tr>
									<th>Text</th>
									<td><label><input name='wonderplugin-slider-showtext' type='checkbox' id='wonderplugin-slider-showtext' value='' /> Show text</label></td>
								</tr>
								<tr>
									<th>Timer</th>
									<td><label><input name='wonderplugin-slider-showtimer' type='checkbox' id='wonderplugin-slider-showtimer' value='' /> Show a line timer at the bottom of the image when slideshow playing</label></td>
								</tr>
								<tr>
									<th>Loop times ( 0 will loop forever)</th>
									<td><label><input name='wonderplugin-slider-loop' type='text' size="10" id='wonderplugin-slider-loop' value='0' /></label></td>
								</tr>
								<tr>
									<th>Slideshow interval (ms)</th>
									<td><label><input name='wonderplugin-slider-slideinterval' type='text' size="10" id='wonderplugin-slider-slideinterval' value='8000' /></label></td>
								</tr>
								<tr>
									<th>Inline CSS</th>
									<td><label><input name='wonderplugin-slider-disableinlinecss' type='checkbox' id='wonderplugin-slider-disableinlinecss' value='' /> Disable inline CSS (you may need to add the CSS code manually to your WordPress theme style.css file)</label>
									</td>
								</tr>
								<tr>
									<th>WooCommerce slider</th>
									<td><label><input name='wonderplugin-slider-addwoocommerceclass' type='checkbox' id='wonderplugin-slider-addwoocommerceclass' value='' /> Add class name woocommerce to the slider</label>
									</td>
								</tr>
							</table>
						</div>
						<div class="wonderplugin-slider-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<td>
									<div class="wonderplugin-form-half">
										<table>
										<tr><td><label><input name='wonderplugin-slider-effect-fade' type='checkbox' id='wonderplugin-slider-effect-fade' value='fade' /> Fade</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-fadeduration' type='number' class="small-text" id='wonderplugin-slider-fadeduration' value='1000' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-crossfade' type='checkbox' id='wonderplugin-slider-effect-crossfade' value='crossfade' /> Crossfade</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-crossfadeduration' type='number' class="small-text" id='wonderplugin-slider-crossfadeduration' value='1000' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-slide' type='checkbox' id='wonderplugin-slider-effect-slide' value='slide' /> Slide</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-slideduration' type='number' class="small-text" id='wonderplugin-slider-slideduration' value='1000' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-elastic' type='checkbox' id='wonderplugin-slider-effect-elastic' value='slide' /> Elastic slide</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-elasticduration' type='number' class="small-text" id='wonderplugin-slider-elasticduration' value='1000' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-slice' type='checkbox' id='wonderplugin-slider-effect-slice' value='slice' /> Slice</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-sliceduration' type='number' class="small-text" id='wonderplugin-slider-sliceduration' value='1500' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-blinds' type='checkbox' id='wonderplugin-slider-effect-blinds' value='blinds' /> Blinds</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-blindsduration' type='number' class="small-text" id='wonderplugin-slider-blindsduration' value='1500' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-blocks' type='checkbox' id='wonderplugin-slider-effect-blocks' value='blocks' /> Blocks</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-blocksduration' type='number' class="small-text" id='wonderplugin-slider-blocksduration' value='1500' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-shuffle' type='checkbox' id='wonderplugin-slider-effect-shuffle' value='shuffle' /> Shuffle</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-shuffleduration' type='number' class="small-text" id='wonderplugin-slider-shuffleduration' value='1500' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-tiles' type='checkbox' id='wonderplugin-slider-effect-tiles' value='tiles' /> Tiles</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-tilesduration' type='number' class="small-text" id='wonderplugin-slider-tilesduration' value='1500' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-kenburns' type='checkbox' id='wonderplugin-slider-effect-kenburns' value='kenburns' /> Ken burns</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-kenburnsduration' type='number' class="small-text" id='wonderplugin-slider-kenburnsduration' value='1500' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-flip' type='checkbox' id='wonderplugin-slider-effect-flip' value='flip' /> Flip</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-flipduration' type='number' class="small-text" id='wonderplugin-slider-flipduration' value='1500' /></label></td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-flipwithzoom' type='checkbox' id='wonderplugin-slider-effect-flipwithzoom' value='Flip with zoom' /> Flip with zoom</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-flipwithzoomduration' type='number' class="small-text" id='wonderplugin-slider-flipwithzoomduration' value='1500' /></label></td></tr>
										</table>
									</div>
									<div class="wonderplugin-form-half">
										<table>
										<tr><td><label><input name='wonderplugin-slider-effect-threed' type='checkbox' id='wonderplugin-slider-effect-threed' value='threed' /> 3D</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-threedduration' type='number' class="small-text" id='wonderplugin-slider-threedduration' value='1000' /></label>
										<br><label>Fallback to effect on Internet Explorer:
										<select name='wonderplugin-slider-threedfallback' id='wonderplugin-slider-threedfallback'>
										  <option value="fade">Fade</option>
										  <option value="crossfade">Crossfade</option>
										  <option value="slide">Slide</option>
										  <option value="elastic">Elastic slide</option>
										  <option value="slice">Slice</option>
										  <option value="blinds">Blinds</option>
										  <option value="blocks">Blocks</option>
										  <option value="shuffle">Shuffle</option>
										  <option value="tiles">Tiles</option>
										  <option value="kenburns">Ken burns</option>
										  <option value="flip">Flip</option>
										  <option value="flipwithzoom">Flip with zoom</option></select>
										</label>
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-threedwithzoom' type='checkbox' id='wonderplugin-slider-effect-threedwithzoom' value='threedwithzoom' /> 3D with zoom</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-threedwithzoomduration' type='number' class="small-text" id='wonderplugin-slider-threedwithzoomduration' value='1500' /></label>
										<br><label>Fallback to effect on Internet Explorer:
										<select name='wonderplugin-slider-threedwithzoomfallback' id='wonderplugin-slider-threedwithzoomfallback'>
										  <option value="fade">Fade</option>
										  <option value="crossfade">Crossfade</option>
										  <option value="slide">Slide</option>
										  <option value="elastic">Elastic slide</option>
										  <option value="slice">Slice</option>
										  <option value="blinds">Blinds</option>
										  <option value="blocks">Blocks</option>
										  <option value="shuffle">Shuffle</option>
										  <option value="tiles">Tiles</option>
										  <option value="kenburns">Ken burns</option>
										  <option value="flip">Flip</option>
										  <option value="flipwithzoom">Flip with zoom</option></select>
										</label>
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-threedhorizontal' type='checkbox' id='wonderplugin-slider-effect-threedhorizontal' value='threedhorizontal' /> 3D horizontal</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-threedhorizontalduration' type='number' class="small-text" id='wonderplugin-slider-threedhorizontalduration' value='1500' /></label>
										<br><label>Fallback to effect on Internet Explorer:
										<select name='wonderplugin-slider-threedhorizontalfallback' id='wonderplugin-slider-threedhorizontalfallback'>
										  <option value="fade">Fade</option>
										  <option value="crossfade">Crossfade</option>
										  <option value="slide">Slide</option>
										  <option value="elastic">Elastic slide</option>
										  <option value="slice">Slice</option>
										  <option value="blinds">Blinds</option>
										  <option value="blocks">Blocks</option>
										  <option value="shuffle">Shuffle</option>
										  <option value="tiles">Tiles</option>
										  <option value="kenburns">Ken burns</option>
										  <option value="flip">Flip</option>
										  <option value="flipwithzoom">Flip with zoom</option></select>
										</label>
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-threedhorizontalwithzoom' type='checkbox' id='wonderplugin-slider-effect-threedhorizontalwithzoom' value='threedhorizontalwithzoom' /> 3D horizontal with zoom</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-threedhorizontalwithzoomduration' type='number' class="small-text" id='wonderplugin-slider-threedhorizontalwithzoomduration' value='1500' /></label>
										<br><label>Fallback to effect on Internet Explorer:
										<select name='wonderplugin-slider-threedhorizontalwithzoomfallback' id='wonderplugin-slider-threedhorizontalwithzoomfallback'>
										  <option value="fade">Fade</option>
										  <option value="crossfade">Crossfade</option>
										  <option value="slide">Slide</option>
										  <option value="elastic">Elastic slide</option>
										  <option value="slice">Slice</option>
										  <option value="blinds">Blinds</option>
										  <option value="blocks">Blocks</option>
										  <option value="shuffle">Shuffle</option>
										  <option value="tiles">Tiles</option>
										  <option value="kenburns">Ken burns</option>
										  <option value="flip">Flip</option>
										  <option value="flipwithzoom">Flip with zoom</option></select>
										</label>
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-threedflip' type='checkbox' id='wonderplugin-slider-effect-threedflip' value='threedflip' /> 3D flip</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-threedflipduration' type='number' class="small-text" id='wonderplugin-slider-threedflipduration' value='1500' /></label>
										<br><label>Fallback to effect on Internet Explorer:
										<select name='wonderplugin-slider-threedflipfallback' id='wonderplugin-slider-threedflipfallback'>
										  <option value="fade">Fade</option>
										  <option value="crossfade">Crossfade</option>
										  <option value="slide">Slide</option>
										  <option value="elastic">Elastic slide</option>
										  <option value="slice">Slice</option>
										  <option value="blinds">Blinds</option>
										  <option value="blocks">Blocks</option>
										  <option value="shuffle">Shuffle</option>
										  <option value="tiles">Tiles</option>
										  <option value="kenburns">Ken burns</option>
										  <option value="flip">Flip</option>
										  <option value="flipwithzoom">Flip with zoom</option></select>
										</label>
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-threedflipwithzoom' type='checkbox' id='wonderplugin-slider-effect-threedflipwithzoom' value='threedflipwithzoom' /> 3D flip with zoom</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-threedflipwithzoomduration' type='number' class="small-text" id='wonderplugin-slider-threedflipwithzoomduration' value='1500' /></label>
										<br><label>Fallback to effect on Internet Explorer:
										<select name='wonderplugin-slider-threedflipwithzoomfallback' id='wonderplugin-slider-threedflipwithzoomfallback'>
										  <option value="fade">Fade</option>
										  <option value="crossfade">Crossfade</option>
										  <option value="slide">Slide</option>
										  <option value="elastic">Elastic slide</option>
										  <option value="slice">Slice</option>
										  <option value="blinds">Blinds</option>
										  <option value="blocks">Blocks</option>
										  <option value="shuffle">Shuffle</option>
										  <option value="tiles">Tiles</option>
										  <option value="kenburns">Ken burns</option>
										  <option value="flip">Flip</option>
										  <option value="flipwithzoom">Flip with zoom</option></select>
										</label>
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-effect-threedtiles' type='checkbox' id='wonderplugin-slider-effect-threedtiles' value='threedtiles' /> 3D tiles</label></td><td><label>Duration (ms): <input name='wonderplugin-slider-threedtilesduration' type='number' class="small-text" id='wonderplugin-slider-threedtilesduration' value='1500' /></label>
										<br><label>Fallback to effect on Internet Explorer:
										<select name='wonderplugin-slider-threedtilesfallback' id='wonderplugin-slider-threedtilesfallback'>
										  <option value="fade">Fade</option>
										  <option value="crossfade">Crossfade</option>
										  <option value="slide">Slide</option>
										  <option value="elastic">Elastic slide</option>
										  <option value="slice">Slice</option>
										  <option value="blinds">Blinds</option>
										  <option value="blocks">Blocks</option>
										  <option value="shuffle">Shuffle</option>
										  <option value="tiles">Tiles</option>
										  <option value="kenburns">Ken burns</option>
										  <option value="flip">Flip</option>
										  <option value="flipwithzoom">Flip with zoom</option></select>
										</label>
										</td></tr>
										</table>
									</div>
									<div style="clear:both;"></div>
									</td>
								</tr>
							</table>
						</div>
						<div class="wonderplugin-slider-options-tab">
							<p class="wonderplugin-slider-options-tab-title"><?php _e( 'Skin option will be restored to its default value if you switch to a new skin in the Skins tab.', 'wonderplugin_slider' ); ?></p>
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Slideshow padding</th>
									<td>Padding left: <input name='wonderplugin-slider-paddingleft' type='number' class="small-text" id='wonderplugin-slider-paddingleft' value='0' />
									Padding right: <input name='wonderplugin-slider-paddingright' type='number' class="small-text" id='wonderplugin-slider-paddingright' value='0' />
									Padding top: <input name='wonderplugin-slider-paddingtop' type='number' class="small-text" id='wonderplugin-slider-paddingtop' value='0' />
									Padding bottom: <input name='wonderplugin-slider-paddingbottom' type='number' class="small-text" id='wonderplugin-slider-paddingbottom' value='0' />
									</td>
								</tr>
								<tr>
									<th>Show bottom shadow</th>
									<td><label><input name='wonderplugin-slider-showbottomshadow' type='checkbox' id='wonderplugin-slider-showbottomshadow'  /> Show bottom shadow</label>
									</td>
								</tr>
								<tr>
									<th>Show thumbnail preview</th>
									<td><label><input name='wonderplugin-slider-navshowpreview' type='checkbox' id='wonderplugin-slider-navshowpreview'  /> Show thumbnail preview</label>
									</td>
								</tr>
								<tr>
									<th>Border size</th>
									<td><label><input name='wonderplugin-slider-border' type='number' class="small-text" id='wonderplugin-slider-border' value='0' /></label></td>
								</tr>
								<tr>
									<th>Arrows</th>
									<td><label>
										<select name='wonderplugin-slider-arrowstyle' id='wonderplugin-slider-arrowstyle'>
										  <option value="mouseover">Show on mouseover</option>
										  <option value="always">Always show</option>
										  <option value="none">Hide</option>
										</select>
									</label></td>
								</tr>
								<tr>
									<th>Arrow image</th>
									<td>
										<img id="wonderplugin-slider-displayarrowimage" />
										<br />
										<label>
											<input type="radio" name="wonderplugin-slider-arrowimagemode" value="custom">
											<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
											<input name='wonderplugin-slider-customarrowimage' type='text' class="regular-text" id='wonderplugin-slider-customarrowimage' value='' />
										</label>
										<br />
										<label>
											<input type="radio" name="wonderplugin-slider-arrowimagemode" value="defined">
											<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
											<select name='wonderplugin-slider-arrowimage' id='wonderplugin-slider-arrowimage'>
											<?php 
												$arrowimage_list = array("arrows-32-32-0.png", "arrows-32-32-1.png", "arrows-32-32-2.png", "arrows-32-32-3.png", "arrows-32-32-4.png", 
														"arrows-36-36-0.png",
														"arrows-36-80-0.png",
														"arrows-48-48-0.png", "arrows-48-48-1.png", "arrows-48-48-2.png", "arrows-48-48-3.png", "arrows-48-48-4.png",
														"arrows-72-72-0.png");
												foreach ($arrowimage_list as $arrowimage)
													echo '<option value="' . $arrowimage . '">' . $arrowimage . '</option>';
											?>
											</select>
										</label><br />
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=wonderplugin-slider-arrowimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#wonderplugin-slider-displayarrowimage").attr("src", jQuery('#wonderplugin-slider-customarrowimage').val());
												else
													jQuery("#wonderplugin-slider-displayarrowimage").attr("src", "<?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?>" + jQuery('#wonderplugin-slider-arrowimage').val());
											});

											jQuery("#wonderplugin-slider-arrowimage").change(function(){
												if (jQuery("input:radio[name=wonderplugin-slider-arrowimagemode]:checked").val() == 'defined')
													jQuery("#wonderplugin-slider-displayarrowimage").attr("src", "<?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#wonderplugin-slider-arrowwidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#wonderplugin-slider-arrowheight").val(arrowsize[2]);
												}
													
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='wonderplugin-slider-arrowwidth' type='number' class='small-text' id='wonderplugin-slider-arrowwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='wonderplugin-slider-arrowheight' type='number' class='small-text' id='wonderplugin-slider-arrowheight' value='32' /></label><br />
										<label><span style="display:inline-block;min-width:100px;">Left/right margin:</span> <input name='wonderplugin-slider-arrowmargin' type='number' class='small-text' id='wonderplugin-slider-arrowmargin' value='8' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Top (percent):</span> <input name='wonderplugin-slider-arrowtop' type='number' class='small-text' id='wonderplugin-slider-arrowtop' value='50' /></label>
										
									</td>
								</tr>
								
								<tr id="wonderplugin-slider-configplayvideoimage">
									<th>Play video button</th>
									<td>
										<img id="wonderplugin-slider-displayplayvideoimage" />
										<br />
										<label>
											<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
											<select name='wonderplugin-slider-playvideoimage' id='wonderplugin-slider-playvideoimage'>
											<?php 
												$playvideoimage_list = array("playvideo-32-32-0.png", "playvideo-64-64-0.png", "playvideo-64-64-1.png", "playvideo-64-64-2.png", "playvideo-64-64-3.png", "playvideo-64-64-4.png", "playvideo-64-64-5.png",
														"playvideo-72-72-0.png");
												foreach ($playvideoimage_list as $playvideoimage)
													echo '<option value="' . $playvideoimage . '">' . $playvideoimage . '</option>';
											?>
											</select>
										</label><br />
										<script language="JavaScript">
										jQuery(document).ready(function(){

											jQuery("#wonderplugin-slider-playvideoimage").change(function(){
												jQuery("#wonderplugin-slider-displayplayvideoimage").attr("src", "<?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#wonderplugin-slider-playvideoimagewidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#wonderplugin-slider-playvideoimageheight").val(arrowsize[2]);
												}							
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='wonderplugin-slider-playvideoimagewidth' type='number' class='small-text' id='wonderplugin-slider-playvideoimagewidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='wonderplugin-slider-playvideoimageheight' type='number' class='small-text' id='wonderplugin-slider-playvideoimageheight' value='32' /></label><br />										
									</td>
								</tr>
							</table>
						</div>
						
						<div class="wonderplugin-slider-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Navigation</th>
									<td>
									<label><input name='wonderplugin-slider-shownav' type='checkbox' id='wonderplugin-slider-shownav' value='' /> Show navigation</label>
									</td>
								</tr>
								<tr>
									<th>Position and Spacing</th>
									<td>
									<div id="wonderplugin-slider-confignavgeneral">
										<label style="margin-right:24px;"><span style="display:inline-block;">Position:</span> <select name='wonderplugin-slider-navposition' id='wonderplugin-slider-navposition'>
										  <option value="topright">Top right</option>
										  <option value="topleft">Top left</option>
										  <option value="bottomright">Bottom right</option>
										  <option value="bottomleft">Bottom left</option>
										  <option value="top">Top</option>
										  <option value="bottom">Bottom</option>
										  <option value="left">Left</option>
										  <option value="right">Right</option>
										</select>
										</label>
										<label style="margin-right:24px;"><span style="display:inline-block;">Margin X:</span> <input name='wonderplugin-slider-navmarginx' type='number' class="small-text" id='wonderplugin-slider-navmarginx' value='8' /></label>
										<label style="margin-right:24px;"><span style="display:inline-block;">Margin Y:</span> <input name='wonderplugin-slider-navmarginy' type='number' class="small-text" id='wonderplugin-slider-navmarginy' value='8' /></label>
										<label><span style="display:inline-block;">Spacing:</span> <input name='wonderplugin-slider-navspacing' type='number' class="small-text" id='wonderplugin-slider-navspacing' value='8' /></label>
									</div>
									</td>
								</tr>
								<tr id="wonderplugin-slider-confignavimage">
									<th>
									<span class="wonderplugin-slider-confignavbullets-title">Bullets</span>
									<span class="wonderplugin-slider-confignavthumbnails-title">Thumbnails</span>
									<td>									    
									    <div class="wonderplugin-slider-confignavbullets">
										<img id="wonderplugin-slider-displaynavimage" />
										<br />
										<label>
											<input type="radio" name="wonderplugin-slider-navimagemode" value="custom">
											<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
											<input name='wonderplugin-slider-customnavimage' type='text' class="regular-text" id='wonderplugin-slider-customnavimage' value='' />
										</label>
										<br />
										<label>
											<input type="radio" name="wonderplugin-slider-navimagemode" value="defined">
											<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
											<select name='wonderplugin-slider-navimage' id='wonderplugin-slider-navimage'>
											<?php 
												$navimage_list = array("bullet-12-12-0.png",
														"bullet-16-16-0.png", "bullet-16-16-1.png", "bullet-16-16-2.png", "bullet-16-16-3.png", 
														"bullet-20-20-0.png", "bullet-20-20-1.png", 
														"bullet-24-24-0.png", "bullet-24-24-1.png", "bullet-24-24-2.png", "bullet-24-24-3.png", "bullet-24-24-4.png", "bullet-24-24-5.png", "bullet-24-24-6.png");
												foreach ($navimage_list as $navimage)
													echo '<option value="' . $navimage . '">' . $navimage . '</option>';
											?>
											</select>
										</label><br />
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=wonderplugin-slider-navimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#wonderplugin-slider-displaynavimage").attr("src", jQuery('#wonderplugin-slider-customnavimage').val());
												else
													jQuery("#wonderplugin-slider-displaynavimage").attr("src", "<?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?>" + jQuery('#wonderplugin-slider-navimage').val());
											});

											jQuery("#wonderplugin-slider-navimage").change(function(){
												if (jQuery("input:radio[name=wonderplugin-slider-navimagemode]:checked").val() == 'defined')
													jQuery("#wonderplugin-slider-displaynavimage").attr("src", "<?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#wonderplugin-slider-navwidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#wonderplugin-slider-navheight").val(arrowsize[2]);
												}
													
											});
										});
										</script>
										</div>
										
										<div class="wonderplugin-slider-confignavthumbnails">
										
										<label><span style="display:inline-block;">Thumbnail size mode:</span> <select name='wonderplugin-slider-navthumbresponsivemode' id='wonderplugin-slider-navthumbresponsivemode'>
										  <option value="samesize">Keep size</option>
										  <option value="samecolumn">Keep column</option>
										</select>
										</label><br>
										
										<script language="JavaScript">
										(function($) {
											$(document).ready(function() {
												$("#wonderplugin-slider-navthumbresponsivemode").change(function(){
													if ($(this).val() == 'samesize')
													{
														$('.wonderplugin-slider-navthumbnailsamesize').show();
														$('.wonderplugin-slider-navthumbnailsamecolumn').hide();
													}
													else
													{
														$('.wonderplugin-slider-navthumbnailsamesize').hide();
														$('.wonderplugin-slider-navthumbnailsamecolumn').show();
													}	
												});
											});
										})(jQuery);
										</script>
										</div>
										
										<div class="wonderplugin-slider-confignavthumbnailsandbullets">
										<p>
										<label class="wonderplugin-slider-navthumbnailsamesize" style="margin-right:24px;"><span style="display:inline-block;">Width:</span> <input name='wonderplugin-slider-navwidth' type='number' class='small-text' id='wonderplugin-slider-navwidth' value='32' /></label>
										<label class="wonderplugin-slider-navthumbnailsamesize"><span style="display:inline-block;">Height:</span> <input name='wonderplugin-slider-navheight' type='number' class='small-text' id='wonderplugin-slider-navheight' value='32' /></label>
										</p>
										</div>
										
										<div class="wonderplugin-slider-confignavthumbnails">
										<p>
										<label class="wonderplugin-slider-navthumbnailsamecolumn"><span style="display:inline-block;">Column number:</span> <input name='wonderplugin-slider-navthumbcolumn' type='number' class='small-text' id='wonderplugin-slider-navthumbcolumn' value='32' /></label>
										</p>
										<p>
										<label><span style="display:inline-block;">Style:</span> <select name='wonderplugin-slider-navthumbstyle' id='wonderplugin-slider-navthumbstyle'>
										  <option value="imageonly">Image only</option>
										  <option value="imageandtitle">Image and title</option>
										  <option value="imageandtitledescription">Image, title and description</option>
										  <option value="textonly">Text only</option>
										</select>
										</label>
										<label style="margin-right:24px;"><span style="display:inline-block;">Title width:</span> <input name='wonderplugin-slider-navthumbtitlewidth' type='number' class='small-text' id='wonderplugin-slider-navthumbtitlewidth' value='32' /></label>
										<label><span style="display:inline-block;">Title height:</span> <input name='wonderplugin-slider-navthumbtitleheight' type='number' class='small-text' id='wonderplugin-slider-navthumbtitleheight' value='32' /></label>
										</p>
										
										<p><label><input name='wonderplugin-slider-navthumbresponsive' type='checkbox' id='wonderplugin-slider-navthumbresponsive' value='' /> Responsive thumbnails</label></p>
										
										<ul style="list-style-type:square;margin-left:20px;">
											<li>When the screen width is less than <input name='wonderplugin-slider-navthumbmediumsize' type='number' class='small-text' id='wonderplugin-slider-navthumbmediumsize' value='900' /> px:
											
											<p>
											<label class="wonderplugin-slider-navthumbnailsamesize" style="margin-right:24px;"><span style="display:inline-block;">Width:</span> <input name='wonderplugin-slider-navthumbmediumwidth' type='number' class='small-text' id='wonderplugin-slider-navthumbmediumwidth' value='32' /></label>
											<label class="wonderplugin-slider-navthumbnailsamesize"><span style="display:inline-block;">Height:</span> <input name='wonderplugin-slider-navthumbmediumheight' type='number' class='small-text' id='wonderplugin-slider-navthumbmediumheight' value='32' /></label>
											
											<label class="wonderplugin-slider-navthumbnailsamecolumn"><span style="display:inline-block;">Column number:</span> <input name='wonderplugin-slider-navthumbmediumcolumn' type='number' class='small-text' id='wonderplugin-slider-navthumbmediumcolumn' value='32' /></label>
											
											<label style="margin-right:24px;"><span style="display:inline-block;">Title width:</span> <input name='wonderplugin-slider-navthumbmediumtitlewidth' type='number' class='small-text' id='wonderplugin-slider-navthumbmediumtitlewidth' value='32' /></label>
											<label><span style="display:inline-block;">Title height:</span> <input name='wonderplugin-slider-navthumbmediumtitleheight' type='number' class='small-text' id='wonderplugin-slider-navthumbmediumtitleheight' value='32' /></label>
											</p>
											
											</li>
											<li>When the screen width is less than <input name='wonderplugin-slider-navthumbsmallsize' type='number' class='small-text' id='wonderplugin-slider-navthumbsmallsize' value='600' /> px:
											
											<p>
											<label class="wonderplugin-slider-navthumbnailsamesize" style="margin-right:24px;"><span style="display:inline-block;">Width:</span> <input name='wonderplugin-slider-navthumbsmallwidth' type='number' class='small-text' id='wonderplugin-slider-navthumbsmallwidth' value='32' /></label>
											<label class="wonderplugin-slider-navthumbnailsamesize"><span style="display:inline-block;">Height:</span> <input name='wonderplugin-slider-navthumbsmallheight' type='number' class='small-text' id='wonderplugin-slider-navthumbsmallheight' value='32' /></label>
											
											<label class="wonderplugin-slider-navthumbnailsamecolumn"><span style="display:inline-block;">Column number:</span> <input name='wonderplugin-slider-navthumbsmallcolumn' type='number' class='small-text' id='wonderplugin-slider-navthumbsmallcolumn' value='32' /></label>
											
											<label style="margin-right:24px;"><span style="display:inline-block;">Title width:</span> <input name='wonderplugin-slider-navthumbsmalltitlewidth' type='number' class='small-text' id='wonderplugin-slider-navthumbsmalltitlewidth' value='32' /></label>
											<label><span style="display:inline-block;">Title height:</span> <input name='wonderplugin-slider-navthumbsmalltitleheight' type='number' class='small-text' id='wonderplugin-slider-navthumbsmalltitleheight' value='32' /></label>
											</p>
											
											</li>
										</ul>
										
										<p><label><input name='wonderplugin-slider-navshowfeaturedarrow' type='checkbox' id='wonderplugin-slider-navshowfeaturedarrow' value='' /> Show arrow on the highlighted thumbnail</label></p>
	
										</div>
									</td>
								</tr>
								
								<tr>
									<th>Carousel Arrows</th>
									<td>
									<label><span style="display:inline-block;">Arrow style:</span> <select name='wonderplugin-slider-navthumbnavigationstyle' id='wonderplugin-slider-navthumbnavigationstyle'>
										  <option value="auto">No arrow</option>
										  <option value="arrow">Arrow</option>
										  <option value="arrowinside">Arrow inside</option>
										  <option value="arrowoutside">Arrow outside</option>
										</select>
									</label>
									
									<div>
									<img id="wonderplugin-slider-displaynavthumbnavigationarrowimage" />
									<br />
									<label>
										<input type="radio" name="wonderplugin-slider-navthumbnavigationarrowimagemode" value="defined">
										<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
										<select name='wonderplugin-slider-navthumbnavigationarrowimage' id='wonderplugin-slider-navthumbnavigationarrowimage'>
										<?php 
											$navthumbnavigationarrowimage_list = array("carouselarrows-32-32-0.png", "carouselarrows-32-32-1.png", "carouselarrows-32-32-2.png", "carouselarrows-32-32-3.png", "carouselarrows-32-32-4.png", "carouselarrows-32-32-5.png");
											foreach ($navthumbnavigationarrowimage_list as $navthumbnavigationarrowimage)
												echo '<option value="' . $navthumbnavigationarrowimage . '">' . $navthumbnavigationarrowimage . '</option>';
										?>
										</select>
									</label>
									<br />
									<label>
										<input type="radio" name="wonderplugin-slider-navthumbnavigationarrowimagemode" value="custom">
										<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
										<input name='wonderplugin-slider-customnavthumbnavigationarrowimage' type='text' class="regular-text" id='wonderplugin-slider-customnavthumbnavigationarrowimage' value='' />
									</label>
									<br />
									<script language="JavaScript">
									jQuery(document).ready(function(){
										jQuery("input:radio[name=wonderplugin-slider-navthumbnavigationarrowimagemode]").click(function(){
											if (jQuery(this).val() == 'custom')
												jQuery("#wonderplugin-slider-displaynavthumbnavigationarrowimage").attr("src", jQuery('#wonderplugin-slider-customnavthumbnavigationarrowimage').val());
											else
												jQuery("#wonderplugin-slider-displaynavthumbnavigationarrowimage").attr("src", "<?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?>" + jQuery('#wonderplugin-slider-navthumbnavigationarrowimage').val());
										});

										jQuery("#wonderplugin-slider-navthumbnavigationarrowimage").change(function(){
											if (jQuery("input:radio[name=wonderplugin-slider-navthumbnavigationarrowimagemode]:checked").val() == 'defined')
												jQuery("#wonderplugin-slider-displaynavthumbnavigationarrowimage").attr("src", "<?php echo WONDERPLUGIN_SLIDER_URL . 'engine/'; ?>" + jQuery(this).val());
											var arrowsize = jQuery(this).val().split("-");
											if (arrowsize.length > 2)
											{
												if (!isNaN(arrowsize[1]))
													jQuery("#wonderplugin-slider-navthumbnavigationarrowimagewidth").val(arrowsize[1]);
												if (!isNaN(arrowsize[2]))
													jQuery("#wonderplugin-slider-navthumbnavigationarrowimageheight").val(arrowsize[2]);
											}
												
										});
									});
									</script>
									<p>
										<label style="margin-right:24px;"><span style="display:inline-block;">Width:</span> <input name='wonderplugin-slider-navthumbnavigationarrowimagewidth' type='number' class='small-text' id='wonderplugin-slider-navthumbnavigationarrowimagewidth' value='32' /></label>
										<label><span style="display:inline-block;">Height:</span> <input name='wonderplugin-slider-navthumbnavigationarrowimageheight' type='number' class='small-text' id='wonderplugin-slider-navthumbnavigationarrowimageheight' value='32' /></label>
									</p>
									</div>	
									</td>
								</tr>
							</table>
						</div>
							
						<div class="wonderplugin-slider-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Select a pre-defined text effect</th>
									<td><label>
										<select name='wonderplugin-slider-textformat' id='wonderplugin-slider-textformat'>
										  <?php 
												$textformat_list = array('Bottom bar', 'Bottom left', 'Left box', 'Center text', 'Center box', 'Left text', 'Color box', 'Blue box', 'Red box', 'Navy box', 'Pink box', 'Light box', 'Grey box', 'Color box right align', 'Red title', 'White title', 'Yellow title', 'Underneath center', 'Underneath left', 'None');
												foreach ($textformat_list as $textformat)
													echo '<option value="' . $textformat . '">' . $textformat . '</option>';
											?>
										</select>
									</label>
									<input class="button button-primary" type="button" id="save-current-text-effect" value="Save text effect">
									<input class="button button-primary" type="button" id="save-text-effect" value="Save as a new text effect">
									<input class="button button-primary" type="button" id="delete-current-text-effect" value="Delete text effect">
									<input type="hidden" id="custom-text-effect" value="">
									</td>
								</tr>
								
								<tr>
									<th></th>
									<td>
									<p>* The following options will be restored to the default value if you change text effect in the above drop-down list.</p>
									<div class='wonderplugin-slider-texteffect-static'>
									<label><input name='wonderplugin-slider-textautohide' type='checkbox' id='wonderplugin-slider-textautohide' value='' /> Auto hide text</label>
									</div>
									
									</td>
								</tr>
								
								<tr>
									<th>Text box CSS</th>
									<td><label><textarea name="wonderplugin-slider-textcss" id="wonderplugin-slider-textcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Text background CSS</th>
									<td><label><textarea name="wonderplugin-slider-textbgcss" id="wonderplugin-slider-textbgcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Title CSS</th>
									<td><label><textarea name="wonderplugin-slider-titlecss" id="wonderplugin-slider-titlecss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Description CSS</th>
									<td><label><textarea name="wonderplugin-slider-descriptioncss" id="wonderplugin-slider-descriptioncss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Button box CSS</th>
									<td><label><textarea name="wonderplugin-slider-buttoncss" id="wonderplugin-slider-buttoncss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr>
									<th>Position</th>
									<td>
									<div class='wonderplugin-slider-texteffect-static'>
										<select name='wonderplugin-slider-textpositionstatic' id='wonderplugin-slider-textpositionstatic'>
										  <option value="top">top</option>
										  <option value="bottom">bottom</option>
										  <option value="left">left</option>
										  <option value="right">right</option>
										  <option value="topoutside">topoutside</option>
										  <option value="bottomoutside">bottomoutside</option>
										</select>
										&nbsp;&nbsp;Percentage of text area when the position is left or right: <input name='wonderplugin-slider-textleftrightpercentforstatic' type='number' id='wonderplugin-slider-textleftrightpercentforstatic' class="small-text" value='40' />
									</div>
									<div  class='wonderplugin-slider-texteffect-dynamic'>
										<table>
										<tr><td><label><input name='wonderplugin-slider-textpositiondynamic-topleft' type='checkbox' id='wonderplugin-slider-textpositiondynamic-topleft' value='topleft' /> top-left</label> 
										</td><td><label><input name='wonderplugin-slider-textpositiondynamic-topcenter' type='checkbox' id='wonderplugin-slider-textpositiondynamic-topcenter' value='topcenter' /> top-center</label>
										</td><td><label><input name='wonderplugin-slider-textpositiondynamic-topright' type='checkbox' id='wonderplugin-slider-textpositiondynamic-topright' value='topright' /> top-right</label> 
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-textpositiondynamic-centerleft' type='checkbox' id='wonderplugin-slider-textpositiondynamic-centerleft' value='centerleft' /> middle-left</label> 
										</td><td><label><input name='wonderplugin-slider-textpositiondynamic-centercenter' type='checkbox' id='wonderplugin-slider-textpositiondynamic-centercenter' value='centercenter' /> middle-center</label>
										</td><td><label><input name='wonderplugin-slider-textpositiondynamic-centerright' type='checkbox' id='wonderplugin-slider-textpositiondynamic-centerright' value='centerright' /> middle-right</label>
										</td></tr>
										<tr><td><label><input name='wonderplugin-slider-textpositiondynamic-bottomleft' type='checkbox' id='wonderplugin-slider-textpositiondynamic-bottomleft' value='bottomleft' /> bottom-left</label> 
										</td><td><label><input name='wonderplugin-slider-textpositiondynamic-bottomcenter' type='checkbox' id='wonderplugin-slider-textpositiondynamic-bottomcenter' value='bottomcenter' /> bottom-center</label>
										</td><td><label><input name='wonderplugin-slider-textpositiondynamic-bottomright' type='checkbox' id='wonderplugin-slider-textpositiondynamic-bottomright' value='bottomright' /> bottom-right</label>
										</td></tr>
										</table>
										<p>* To place the text to top-center, middle-center and bottom-center, you need to make sure "Text box CSS" includes <span style="font-style:italic;color:#990000;">text-align:center;</span> , 
										"Title CSS", "Description CSS" and "Button box CSS" include <span style="font-style:italic;color:#990000;">margin-left:auto; margin-right:auto;</span> .</p>
										</div>
									</td>
								</tr>
								
								<tr>
									<th>Responsive design</th>
									<td><label><input name='wonderplugin-slider-texteffectresponsive' type='checkbox' id='wonderplugin-slider-texteffectresponsive' value='' /> Apply the responsive CSS when the screen is smaller than (px): </label>
									<input name='wonderplugin-slider-texteffectresponsivesize' type='number' id='wonderplugin-slider-texteffectresponsivesize' class="small-text" value='600' />
									</td>
								</tr>
								
								<tr>
									<th>Responsive title CSS</th>
									<td><label><textarea name="wonderplugin-slider-titlecssresponsive" id="wonderplugin-slider-titlecssresponsive" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Responsive description CSS</th>
									<td><label><textarea name="wonderplugin-slider-descriptioncssresponsive" id="wonderplugin-slider-descriptioncssresponsive" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								<tr>
									<th>Responsive button box CSS</th>
									<td><label><textarea name="wonderplugin-slider-buttoncssresponsive" id="wonderplugin-slider-buttoncssresponsive" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
							</table>
						</div>
    
						<div class="wonderplugin-slider-options-tab" style="padding:24px;">
						
						<ul class="wonderplugin-tab-buttons-horizontal" data-panelsid="wonderplugin-lightbox-panels">
							<li class="wonderplugin-tab-button-horizontal wonderplugin-tab-button-horizontal-selected"><?php _e( 'General', 'wonderplugin_slider' ); ?></li>
							<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Video', 'wonderplugin_slider' ); ?></li>
							<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Thumbnails', 'wonderplugin_slider' ); ?></li>
							<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Text', 'wonderplugin_slider' ); ?></li>
							<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Lightbox Advanced Options', 'wonderplugin_slider' ); ?></li>
							<div style="clear:both;"></div>
						</ul>
						
						<ul class="wonderplugin-tabs-horizontal" id="wonderplugin-lightbox-panels">
						
							<li class="wonderplugin-tab-horizontal wonderplugin-tab-horizontal-selected">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>General</th>
									<td><label><input name='wonderplugin-slider-lightboxresponsive' type='checkbox' id='wonderplugin-slider-lightboxresponsive'  /> Responsive</label>
									<br><label><input name="wonderplugin-slider-lightboxfullscreenmode" type="checkbox" id="wonderplugin-slider-lightboxfullscreenmode" /> Display in fullscreen mode (the close button on top right of the web browser)</label>
									<br><label><input name="wonderplugin-slider-lightboxcloseonoverlay" type="checkbox" id="wonderplugin-slider-lightboxcloseonoverlay" /> Close the lightbox when clicking on the overlay background</label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Slideshow</th>
									<td><label><input name="wonderplugin-slider-lightboxautoslide" type="checkbox" id="wonderplugin-slider-lightboxautoslide" /> Auto play slideshow</label>
									<br>Slideshow interval (ms): <input name="wonderplugin-slider-lightboxslideinterval" type="number" min=0 id="wonderplugin-slider-lightboxslideinterval" value="5000" class="small-text" />
									<br><label><input name="wonderplugin-slider-lightboxalwaysshownavarrows" type="checkbox" id="wonderplugin-slider-lightboxalwaysshownavarrows" /> Always show left and right navigation arrows</label>
									<br><label><input name="wonderplugin-slider-lightboxshowplaybutton" type="checkbox" id="wonderplugin-slider-lightboxshowplaybutton" /> Show play slideshow button</label>
									<br><label><input name="wonderplugin-slider-lightboxshowtimer" type="checkbox" id="wonderplugin-slider-lightboxshowtimer" /> Show line timer for image slideshow</label>
									<br>Timer position: <select name="wonderplugin-slider-lightboxtimerposition" id="wonderplugin-slider-lightboxtimerposition">
										  <option value="bottom">Bottom</option>
										  <option value="top">Top</option>
										</select>
									Timer color: <input name="wonderplugin-slider-lightboxtimercolor" type="text" id="wonderplugin-slider-lightboxtimercolor" value="#dc572e" class="medium-text" />
									Timer height: <input name="wonderplugin-slider-lightboxtimerheight" type="number" min=0 id="wonderplugin-slider-lightboxtimerheight" value="2" class="small-text" />
									Timer opacity: <input name="wonderplugin-slider-lightboxtimeropacity" type="number" min=0 max=1 step="0.1" id="wonderplugin-slider-lightboxtimeropacity" value="1" class="small-text" />
									<p style="font-style:italic;">* Video autoplay is not supported on mobile and tables. The limitation comes from iOS and Android.</p>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Overlay</th>
									<td>Color: <input name="wonderplugin-slider-lightboxoverlaybgcolor" type="text" id="wonderplugin-slider-lightboxoverlaybgcolor" value="#333" class="medium-text" />
									Opacity: <input name="wonderplugin-slider-lightboxoverlayopacity" type="number" min=0 max=1 step="0.1" id="wonderplugin-slider-lightboxoverlayopacity" value="0.9" class="small-text" /></td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Background color</th>
									<td><input name="wonderplugin-slider-lightboxbgcolor" type="text" id="wonderplugin-slider-lightboxbgcolor" value="#fff" class="medium-text" /></td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Border</th>
									<td>Radius (px): <input name="wonderplugin-slider-lightboxborderradius" type="number" min=0 id="wonderplugin-slider-lightboxborderradius" value="0" class="small-text" />
									Size (px): <input name="wonderplugin-slider-lightboxbordersize" type="number" min=0 id="wonderplugin-slider-lightboxbordersize" value="8" class="small-text" />
									</td>
								</tr>
								
								<tr>
									<th>Group</th>
									<td><label><input name='wonderplugin-slider-lightboxnogroup' type='checkbox' id='wonderplugin-slider-lightboxnogroup'  /> Do not display lightboxes as a group</label>
									</td>
								</tr>
							</table>
							</li>
							
							<li class="wonderplugin-tab-horizontal">
							<table class="wonderplugin-form-table-noborder">
								<tr valign="top">
									<th scope="row">Default volume of MP4/WebM videos</th>
									<td><label><input name="wonderplugin-slider-lightboxdefaultvideovolume" type="number" min=0 max=1 step="0.1" id="wonderplugin-slider-lightboxdefaultvideovolume" value="1" class="small-text" /> (0 - 1)</label></td>
								</tr>
		
								<tr>
									<th>Video</th>
									<td><label><input name='wonderplugin-slider-lightboxvideohidecontrols' type='checkbox' id='wonderplugin-slider-lightboxvideohidecontrols'  /> Hide MP4/WebM video play control bar</label>
									</td>
								</tr>
							</table>
							</li>
							
							<li class="wonderplugin-tab-horizontal">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th>Thumbnails</th>
									<td><label><input name='wonderplugin-slider-lightboxshownavigation' type='checkbox' id='wonderplugin-slider-lightboxshownavigation'  /> Show thumbnails</label>
									</td>
								</tr>
								<tr>
									<th></th>
									<td><label>Thumbnail size: <input name="wonderplugin-slider-lightboxthumbwidth" type="text" id="wonderplugin-slider-lightboxthumbwidth" value="96" class="small-text" /> x <input name="wonderplugin-slider-lightboxthumbheight" type="text" id="wonderplugin-slider-lightboxthumbheight" value="72" class="small-text" /></label> 
									<label>Top margin: <input name="wonderplugin-slider-lightboxthumbtopmargin" type="text" id="wonderplugin-slider-lightboxthumbtopmargin" value="12" class="small-text" /> Bottom margin: <input name="wonderplugin-slider-lightboxthumbbottommargin" type="text" id="wonderplugin-slider-lightboxthumbbottommargin" value="12" class="small-text" /></label>
									</td>
								</tr>
							</table>
							</li>
							
							<li class="wonderplugin-tab-horizontal">
							<table class="wonderplugin-form-table-noborder">
								<tr valign="top">
									<th scope="row">Text position</th>
									<td>
										<select name="wonderplugin-slider-lightboxtitlestyle" id="wonderplugin-slider-lightboxtitlestyle">
										  <option value="bottom">Bottom</option>
										  <option value="inside">Inside</option>
										  <option value="right">Right</option>
										  <option value="left">Left</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<th>Maximum text bar height when text position is bottom</th>
									<td><label><input name="wonderplugin-slider-lightboxbarheight" type="text" id="wonderplugin-slider-lightboxbarheight" value="64" class="small-text" /></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Image/video width percentage when text position is right or left</th>
									<td><input name="wonderplugin-slider-lightboximagepercentage" type="number" id="wonderplugin-slider-lightboximagepercentage" value="75" class="small-text" />%</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Title</th>
									<td><label><input name="wonderplugin-slider-lightboxshowtitle" type="checkbox" id="wonderplugin-slider-lightboxshowtitle" /> Show title</label></td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Add the following prefix to title</th>
									<td><label><input name="wonderplugin-slider-lightboxshowtitleprefix" type="checkbox" id="wonderplugin-slider-lightboxshowtitleprefix" /> Add prefix:</label><input name="wonderplugin-slider-lightboxtitleprefix" type="text" id="wonderplugin-slider-lightboxtitleprefix" value="" class="regular-text" /></td>
								</tr>
								
								<tr>
									<th>Title CSS</th>
									<td><label><textarea name="wonderplugin-slider-lightboxtitlebottomcss" id="wonderplugin-slider-lightboxtitlebottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Title CSS when text position is inside</th>
									<td><textarea name="wonderplugin-slider-lightboxtitleinsidecss" id="wonderplugin-slider-lightboxtitleinsidecss" rows="2" class="large-text code"></textarea></td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Description</th>
									<td><label><input name="wonderplugin-slider-lightboxshowdescription" type="checkbox" id="wonderplugin-slider-lightboxshowdescription" /> Show description</label></td>
								</tr>
								
								<tr>
									<th>Description CSS</th>
									<td><label><textarea name="wonderplugin-slider-lightboxdescriptionbottomcss" id="wonderplugin-slider-lightboxdescriptionbottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Description CSS when text position is inside</th>
									<td><textarea name="wonderplugin-slider-lightboxdescriptioninsidecss" id="wonderplugin-slider-lightboxdescriptioninsidecss" rows="2" class="large-text code"></textarea></td>
								</tr>
							</table>
							</li>
							
							<li class="wonderplugin-tab-horizontal">
							<table class="wonderplugin-form-table-noborder">
								<tr valign="top">
									<th scope="row">Lightbox Advanced Options</th>
									<td><textarea name="wonderplugin-slider-lightboxadvancedoptions" id="wonderplugin-slider-lightboxadvancedoptions" rows="4" class="large-text code"></textarea></td>
								</tr>
							</table>
							</li>
						
						</ul>

						</div>						

						<div class="wonderplugin-slider-options-tab" style="padding:24px;">
							<ul class="wonderplugin-tab-buttons-horizontal" data-panelsid="wonderplugin-share-panels">
								<li class="wonderplugin-tab-button-horizontal wonderplugin-tab-button-horizontal-selected"><?php _e( 'Slideshow Share', 'wonderplugin_slider' ); ?></li>
								<li class="wonderplugin-tab-button-horizontal"></span><?php _e( 'Lightbox Share', 'wonderplugin_slider' ); ?></li>
								<div style="clear:both;"></div>
							</ul>
							
							<ul class="wonderplugin-tabs-horizontal" id="wonderplugin-share-panels">
								<li class="wonderplugin-tab-horizontal wonderplugin-tab-horizontal-selected">
									<table class="wonderplugin-form-table-noborder">
										<tr valign="top">
										<th scope="row">Social Media</th>
										<td><label for="wonderplugin-slider-showsocial"><input name="wonderplugin-slider-showsocial" type="checkbox" id="wonderplugin-slider-showsocial" /> Enable social media buttons on the slideshow</label>
										<p><label for="wonderplugin-slider-showfacebook"><input name="wonderplugin-slider-showfacebook" type="checkbox" id="wonderplugin-slider-showfacebook" /> Show Facebook button</label>
										<br><label for="wonderplugin-slider-showtwitter"><input name="wonderplugin-slider-showtwitter" type="checkbox" id="wonderplugin-slider-showtwitter" /> Show Twitter button</label>
										<br><label for="wonderplugin-slider-showpinterest"><input name="wonderplugin-slider-showpinterest" type="checkbox" id="wonderplugin-slider-showpinterest" /> Show Pinterest button</label></p>
										</td>
									</tr>
						        	
						        	<tr valign="top">
										<th scope="row">Position and Size</th>
										<td>
										Display mode:
										<select name="wonderplugin-slider-socialmode" id="wonderplugin-slider-socialmode">
										  <option value="mouseover" selected="selected">On mouse over</option>
										  <option value="always">Always</option>
										</select>
										<p>Position CSS: <input name="wonderplugin-slider-socialposition" type="text" id="wonderplugin-slider-socialposition" value="" class="regular-text" /></p>
		                				<p>Position CSS on small screen: <input name="wonderplugin-slider-socialpositionsmallscreen" type="text" id="wonderplugin-slider-socialpositionsmallscreen" value="" class="regular-text" /></p>
										<p>Button size: <input name="wonderplugin-slider-socialbuttonsize" type="number" id="wonderplugin-slider-socialbuttonsize" value="32" class="small-text" />
										Button font size: <input name="wonderplugin-slider-socialbuttonfontsize" type="number" id="wonderplugin-slider-socialbuttonfontsize" value="18" class="small-text" />
										Buttons direction:
										<select name="wonderplugin-slider-socialdirection" id="wonderplugin-slider-socialdirection">
										  <option value="horizontal" selected="selected">horizontal</option>
										  <option value="vertical">vertical</option>
										</select>
										</p>
										<p><label for="wonderplugin-slider-socialrotateeffect"><input name="wonderplugin-slider-socialrotateeffect" type="checkbox" id="wonderplugin-slider-socialrotateeffect" /> Enable button rotating effect on mouse hover</label></p>	
										</td>
									</tr>
									</table>
								</li>
								<li class="wonderplugin-tab-horizontal">
									<table class="wonderplugin-form-table-noborder">
										<tr valign="top">
										<th scope="row">Social Media</th>
										<td><label for="wonderplugin-slider-lightboxshowsocial"><input name="wonderplugin-slider-lightboxshowsocial" type="checkbox" id="wonderplugin-slider-lightboxshowsocial" /> Enable social media buttons on the lightbox popup</label>
										<p><label for="wonderplugin-slider-lightboxshowfacebook"><input name="wonderplugin-slider-lightboxshowfacebook" type="checkbox" id="wonderplugin-slider-lightboxshowfacebook" /> Show Facebook button</label>
										<br><label for="wonderplugin-slider-lightboxshowtwitter"><input name="wonderplugin-slider-lightboxshowtwitter" type="checkbox" id="wonderplugin-slider-lightboxshowtwitter" /> Show Twitter button</label>
										<br><label for="wonderplugin-slider-lightboxshowpinterest"><input name="wonderplugin-slider-lightboxshowpinterest" type="checkbox" id="wonderplugin-slider-lightboxshowpinterest" /> Show Pinterest button</label></p>
										</td>
									</tr>
						        	
						        	<tr valign="top">
										<th scope="row">Position and Size</th>
										<td>
										Position CSS: <input name="wonderplugin-slider-lightboxsocialposition" type="text" id="wonderplugin-slider-lightboxsocialposition" value="" class="regular-text" />
		                				<p>Position CSS on small screen: <input name="wonderplugin-slider-lightboxsocialpositionsmallscreen" type="text" id="wonderplugin-slider-lightboxsocialpositionsmallscreen" value="" class="regular-text" /></p>
										<p>Button size: <input name="wonderplugin-slider-lightboxsocialbuttonsize" type="number" id="wonderplugin-slider-lightboxsocialbuttonsize" value="32" class="small-text" />
										Button font size: <input name="wonderplugin-slider-lightboxsocialbuttonfontsize" type="number" id="wonderplugin-slider-lightboxsocialbuttonfontsize" value="18" class="small-text" />
										Buttons direction:
										<select name="wonderplugin-slider-lightboxsocialdirection" id="wonderplugin-slider-lightboxsocialdirection">
										  <option value="horizontal" selected="selected">horizontal</option>
										  <option value="vertical">>vertical</option>
										</select>
										</p>
										<p><label for="wonderplugin-slider-lightboxsocialrotateeffect"><input name="wonderplugin-slider-lightboxsocialrotateeffect" type="checkbox" id="wonderplugin-slider-lightboxsocialrotateeffect" /> Enable button rotating effect on mouse hover</label></p>	
										</td>
									</tr>
									</table>
								</li>
							</ul>
						</div>
						
						<div class="wonderplugin-slider-options-tab">
							<table class="wonderplugin-form-table-noborder">
								<tr>
									<th></th>
									<td><p><label><input name='wonderplugin-slider-donotinit' type='checkbox' id='wonderplugin-slider-donotinit'  /> Do not init the slider when the page is loaded. Check this option if you would like to manually init the slider with JavaScript API.</label></p>
									<p><label><input name='wonderplugin-slider-addinitscript' type='checkbox' id='wonderplugin-slider-addinitscript'  /> Add init scripts together with slider HTML code. Check this option if your WordPress site uses Ajax to load pages and posts.</label></p>
									<p><label><input name='wonderplugin-slider-triggerresize' type='checkbox' id='wonderplugin-slider-triggerresize'  /> Trigger window resize event after (ms): </label><input name="wonderplugin-slider-triggerresizedelay" type="number" min=0 id="wonderplugin-slider-triggerresizedelay" value="0" class="small-text" /></p>
									</td>
								</tr>
								<tr>
								<tr>
									<th>Custom CSS</th>
									<td><textarea name='wonderplugin-slider-custom-css' id='wonderplugin-slider-custom-css' value='' class='large-text' rows="10"></textarea></td>
								</tr>
								<tr>
									<th>Advanced Options</th>
									<td><textarea name='wonderplugin-slider-data-options' id='wonderplugin-slider-data-options' value='' class='large-text' rows="10"></textarea></td>
								</tr>
								<tr>
									<th>Custom JavaScript</th>
									<td><textarea name='wonderplugin-slider-customjs' id='wonderplugin-slider-customjs' value='' class='large-text' rows="10"></textarea><br />
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				
			</li>
			<li class="wonderplugin-tab">
				<div id="wonderplugin-slider-preview-tab">
					<div id="wonderplugin-slider-preview-message"></div>
					<div class="wonderpluginslider-container" id="wonderplugin-slider-preview-container">
					</div>
				</div>
			</li>
			<li class="wonderplugin-tab">
				<div id="wonderplugin-slider-publish-loading"></div>
				<div id="wonderplugin-slider-publish-information"></div>
			</li>
		</ul>
		</div>
		
		<?php
	}
	
	function get_list_data() {
		return array();
	}
}