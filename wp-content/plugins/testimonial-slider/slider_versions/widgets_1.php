<?php
if(!class_exists('Testimonial_Slider_Simple_Widget')){
	class Testimonial_Slider_Simple_Widget extends WP_Widget {
		function __construct() {
			$widget_options = array('classname' => 'testimonial_slider_wclass', 'description' => 'Insert Testimonial Slider' );
			parent::__construct('testimonial_sslider_wid', 'Testimonial Slider - Simple', $widget_options);
		}

		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
		    global $testimonial_slider;
	
			echo $before_widget;
			if($testimonial_slider['multiple_sliders'] == '1') {
			$slider_id = empty($instance['slider_id']) ? '1' : apply_filters('widget_slider_id', $instance['slider_id']);
			}
			else{
			 $slider_id = '1';
			}
	
			$set = empty($instance['set']) ? '' : apply_filters('widget_set', $instance['set']);

			echo $before_title . $after_title; 
			 get_testimonial_slider($slider_id,$set);
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
		    global $testimonial_slider;
			$instance = $old_instance;
			if($testimonial_slider['multiple_sliders'] == '1') {
			   $instance['slider_id'] = strip_tags($new_instance['slider_id']);
			}
			$instance['set'] = strip_tags($new_instance['set']);

			return $instance;
		}

		function form($instance) {
		    global $testimonial_slider;
	
			$instance = wp_parse_args( (array) $instance, array( 'slider_id' => '','set' => '' ) );
			$set = strip_tags($instance['set']);
			$scounter=get_option('testimonial_slider_scounter');		
			if($testimonial_slider['multiple_sliders'] == '1') {	
				$slider_id = strip_tags($instance['slider_id']);		
				$sliders = testimonial_ss_get_sliders();
				$sname_html='<option value="0" selected >Select the Slider</option>';
		 
			  foreach ($sliders as $slider) { 
				 if($slider['slider_id']==$slider_id){$selected = 'selected';} else{$selected='';}
				 $sname_html =$sname_html.'<option value="'.$slider['slider_id'].'" '.$selected.'>'.$slider['slider_name'].'</option>';
			  } 
		?>
					<p><label for="<?php echo $this->get_field_id('slider_id'); ?>">Select Slider Name: <select class="widefat" id="<?php echo $this->get_field_id('slider_id'); ?>" name="<?php echo $this->get_field_name('slider_id'); ?>"><?php echo $sname_html;?></select></label></p>
	<?php  }
	   
		 $sset_html='<option value="0" selected >Select the Settings</option>';
			  for($i=1;$i<=$scounter;$i++) { 
				 if($i==$set){$selected = 'selected';} else{$selected='';}
				   if($i==1){
				     $settings='Default Settings';
					 $sset_html =$sset_html.'<option value="'.$i.'" '.$selected.'>'.$settings.'</option>';
				   }
				   else{
					  if($settings_set=get_option('testimonial_slider_options'.$i))
						$sset_html =$sset_html.'<option value="'.$i.'" '.$selected.'>'.$settings_set['setname'].' (ID '.$i.')</option>';
				   }
			  } 
	   ?>             
		 <p><label for="<?php echo $this->get_field_id('set'); ?>">Select Settings to Apply: <select class="widefat" id="<?php echo $this->get_field_id('set'); ?>" name="<?php echo $this->get_field_name('set'); ?>"><?php echo $sset_html;?></select></label></p> 
		 
	<?php }
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("Testimonial_Slider_Simple_Widget");') );
}
if(!class_exists('Testimonial_Slider_Category_Widget')){
	//Category Widget
	class Testimonial_Slider_Category_Widget extends WP_Widget {
		function __construct() {
			$widget_options = array('classname' => 'testimonial_sliderc_wclass', 'description' => 'Testimonial Category Slider' );
			parent::__construct('testimonial_ssliderc_wid', 'Testimonial Slider - Category', $widget_options);
		}

		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
		    global $testimonial_slider;
		
			echo $before_widget;
		
			$cat = empty($instance['cat']) ? '' : apply_filters('widget_cat', $instance['cat']);
			$set = empty($instance['set']) ? '' : apply_filters('widget_set', $instance['set']);

			echo $before_title . $after_title; 
			 get_testimonial_slider_category($cat,$set);
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
		    global $testimonial_slider;
			$instance = $old_instance;
		
			$instance['cat'] = strip_tags($new_instance['cat']);
			$instance['set'] = strip_tags($new_instance['set']);

			return $instance;
		}

		function form($instance) {
		    global $testimonial_slider;
		
			$scounter=get_option('testimonial_slider_scounter');

			$instance = wp_parse_args( (array) $instance, array( 'cat' => '','set' => '' ) );
			$cat = strip_tags($instance['cat']);
			$set = strip_tags($instance['set']);
		
				$args=array(
						'taxonomy'=> 'testimonial_category'
					);
				$categories = get_categories($args);
				$scat_html='<option value="" selected >Select the Category</option>';
		 
			  foreach ($categories as $category) { 
				 if($category->slug==$cat){$selected = 'selected';} else{$selected='';}
				 $scat_html =$scat_html.'<option value="'.$category->slug.'" '.$selected.'>'.$category->name.'</option>';
			  } 
		?>
			  <p><label for="<?php echo $this->get_field_id('cat'); ?>">Select Category for Slider: <select class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>"><?php echo $scat_html;?></select></label></p>
	  
	 <?php  
		  $sset_html='<option value="0" selected >Select the Settings</option>';
			  for($i=1;$i<=$scounter;$i++) { 
				 if($i==$set){$selected = 'selected';} else{$selected='';}
				   if($i==1){
				     $settings='Default Settings';
					 $sset_html =$sset_html.'<option value="'.$i.'" '.$selected.'>'.$settings.'</option>';
				   }
				   else{
				       if($settings_set=get_option('testimonial_slider_options'.$i))
						$sset_html =$sset_html.'<option value="'.$i.'" '.$selected.'>'.$settings_set['setname'].' (ID '.$i.')</option>';
				   }
			  } 
	   ?>             
		 <p><label for="<?php echo $this->get_field_id('set'); ?>">Select Settings to Apply: <select class="widefat" id="<?php echo $this->get_field_id('set'); ?>" name="<?php echo $this->get_field_name('set'); ?>"><?php echo $sset_html;?></select></label></p> 
		 
	<?php }
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("Testimonial_Slider_Category_Widget");') );
}
if(!class_exists('Testimonial_Slider_Recent_Widget')){
	//Recent Posts Widget
	class Testimonial_Slider_Recent_Widget extends WP_Widget {
		function __construct() {
			$widget_options = array('classname' => 'testimonial_sliderr_wclass', 'description' => 'Testimonial Recent Posts Slider' );
			parent::__construct('testimonial_ssliderr_wid', 'Testimonial Slider - Recent Posts', $widget_options);
		}
	
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
		    global $testimonial_slider;
		
			echo $before_widget;
		
			$set = empty($instance['set']) ? '' : apply_filters('widget_set', $instance['set']);

			echo $before_title . $after_title; 
			 get_testimonial_slider_recent($set);
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
		    global $testimonial_slider;
			$instance = $old_instance;
		
			$instance['set'] = strip_tags($new_instance['set']);

			return $instance;
		}

		function form($instance) {
		    global $testimonial_slider;
		
			$scounter=get_option('testimonial_slider_scounter');

			$instance = wp_parse_args( (array) $instance, array( 'set' => '' ) );
			$set = strip_tags($instance['set']); ?>
		 
	  <?php  
		  $sset_html='<option value="0" selected >Select the Settings</option>';
			  for($i=1;$i<=$scounter;$i++) { 
				 if($i==$set){$selected = 'selected';} else{$selected='';}
				   if($i==1){
				     $settings='Default Settings';
					 $sset_html =$sset_html.'<option value="'.$i.'" '.$selected.'>'.$settings.'</option>';
				   }
				   else{
				       if($settings_set=get_option('testimonial_slider_options'.$i))
						$sset_html =$sset_html.'<option value="'.$i.'" '.$selected.'>'.$settings_set['setname'].' (ID '.$i.')</option>';
				   }
			  } 
	   ?>             
		 <p><label for="<?php echo $this->get_field_id('set'); ?>">Select Settings to Apply: <select class="widefat" id="<?php echo $this->get_field_id('set'); ?>" name="<?php echo $this->get_field_name('set'); ?>"><?php echo $sset_html;?></select></label></p> 
		 
	<?php }
	}
	add_action( 'widgets_init', create_function('', 'return register_widget("Testimonial_Slider_Recent_Widget");') );
}
?>
