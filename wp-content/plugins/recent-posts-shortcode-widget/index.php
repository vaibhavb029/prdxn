<?php
/*
* Plugin Name: Recent Posts Shortcode & Widget
* Description: Recent Posts Shortcode & Widget
* Plugin URI:  https://wordpress.org/plugins/recent-posts-shortcode-widget/
* Version:     1.8
* Author:      rajros
* Author URI:  https://profiles.wordpress.org/rajros
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* 
* Recent Posts Shortcode & Widget is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
 
* Recent Posts Shortcode & Widget is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
 
* You should have received a copy of the GNU General Public License
* along with Recent Posts Shortcode & Widget. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

*/

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter('widget_text', 'do_shortcode', 11);
	
function rpscw_lazy_image_size($image_id, $width, $height, $crop) {
    // Temporarily create an image size
    $size_id = 'lazy_' . $width . 'x' .$height . '_' . ((string) $crop);
    add_image_size($size_id, $width, $height, $crop);
 
    // Get the attachment data
    $meta = wp_get_attachment_metadata($image_id);
 
    // If the size does not exist
    if(!isset($meta['sizes'][$size_id])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
 
        $file = get_attached_file($image_id);
        $new_meta = wp_generate_attachment_metadata($image_id, $file);
 
        // Merge the sizes so we don't lose already generated sizes
        $new_meta['sizes'] = array_merge($meta['sizes'], $new_meta['sizes']);
 
        // Update the meta data
        wp_update_attachment_metadata($image_id, $new_meta);
    }
 
    // Fetch the sized image
    $sized = wp_get_attachment_image_src($image_id, $size_id);
 
    // Remove the image size so new images won't be created in this size automatically
    remove_image_size($size_id);
    return $sized;
}	
	

add_image_size('featured-size', 380, 160, true);


function rpscw_auto_featured_set($post_id)
	{
	;
	if (!has_post_thumbnail($post_id))
		{
		$featured_post 		= get_post($post_id);
		$featured_content 	= $featured_post->post_content;
		$featured_posttype 	=  $featured_post->post_type ? $featured_post->post_type : "Unknown";
		
		if ($featured_posttype != "post")
			{
			return;
			}
		
		$feat_exist_images 	= get_children( array("post_parent" => $post_id, "post_type" => "attachment", "post_mime_type" => "image", "numberposts" => -1) );
				$existn_images 	= array(); 
		preg_match_all( '/wp-image-([^"]*)"/i', $featured_content, $existn_images ) ;
		
		if ( count($existn_images [1])>0 )
			{
			$used_image_ids = array();
			
			foreach ($existn_images [1] as $featured_image_id)
				{

				if (strpos($featured_image_id, "/")>0)
					$featured_image_id = substr($featured_image_id, 0, -1);
				array_unshift($used_image_ids, $featured_image_id);
				}
				
							if ($feat_exist_images) 
				{
				foreach ($feat_exist_images as $attachment_id => $attachment) 
					{
					if (in_array($attachment_id, $used_image_ids) && !has_post_thumbnail($post_id)) 
						set_post_thumbnail($post_id, $attachment_id);
					}
				}
				
							if (!has_post_thumbnail($post_id))
				set_post_thumbnail($post_id, $used_image_ids [0]);
			}
		}
	}

// Use it to generate all featured images
add_action('the_post', 'rpscw_auto_featured_set');
add_action('save_post', 'rpscw_auto_featured_set');

function custom_excerpt_length( $length ) {
    return 120;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


function rpscw_recent_posts_shortcode($atts, $outputcontent = null)
	{
	wp_enqueue_style( 'rpscw_recentcss', plugin_dir_url( __FILE__ ) . 'css/style.css', false ); 

	
	$atts = shortcode_atts(array(
		'post_ids' => '',
		'numberofposts' => 3,
		'category' => '',
		'author' => '',
		'excerptlength' => '25',
		'excerpt_more' => '',
		'include_author' => false,
		'label' => '',
		'get_cat_name' => '',
		'post_type' => 'post',
		'image_size' => '',
		'date_query' => '',
		'date' => '',
		'after' => '',
		'before' => '',
		'featured-size' => true,
		'enable_excerpt' => '',
		'crop' => true,
		'meta_key' => '',
		'meta_value' => '',
		'tag' => '',
		'offset' => '',
		'order' => '',
		'orderby' => '',
		'show_image' => true,
	) , $atts, 'recentpostssc');



// add_action( 'dynamic_sidebar_params', 'rpscw_dynamic_sidebar_params_hook', 1, 1 );
// function rpscw_dynamic_sidebar_params_hook( $content )
//{

 //   $tag = 'recentposts-sc';
 //   if ( shortcode_exists( $tag ) )
//echo 'div';
// }  


	// Show posts based on post ids

	$postsids = explode(',', $atts['post_ids']);
	if ($postsids[0] == "")
		{
		$postsids = '';
		}

	$metaids = explode(',', $atts['meta_value']);
	if ($metaids[0] == "")
		{
		$metaids = '';
		}

	$post_type = explode(',', $atts['post_type']);
	if ($post_type[0] == "")
		{
		$metaids = '';
		}
		
$image_size = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) );
		
		
	$args = array(
		'post_type' => $post_type,
		'category_name' => $atts['category'],
		'meta_key' => $atts['meta_key'],
		'meta_value' => $metaids,
		'date_query' => array(
			array(
				'after' => $atts['after'],
				'before' => $atts['before'],
			) ,
		) ,
		'author_name' => $atts['author'],
		'post__in' => $postsids,
		'posts_per_page' => $atts['numberofposts'],
		'author' => $atts['author'],
		'offset' => $atts['offset'],
		'order' => $atts['order'],
		'orderby' => $atts['orderby'],
		'image_size' => $atts['image_size'],
		'tag' => $atts['tag'],
	);
	ob_start();
	$the_query = new WP_Query($args);
	echo ('<div class="rpscw-recentpostwrap">');
	while ($the_query->have_posts())
		{
		$the_query->the_post();
?>
       


        
         <div class="rpscw-col">
         <div class="rpscw-recentposts">




<div class="rpscw-widgetp">

<?php
		$attachments = get_posts(array(
			'post_type' => 'attachment',
			'numberposts' => 1,
			'post_status' => null,
			'post_parent' => get_the_ID() ,
			'order' => 'DESC',
			'orderby' => 'id',
		));

foreach ( $attachments as $attachment ) {
	
	$featured_size = rpscw_lazy_image_size( $attachment->ID, 380, 160, true );

if ( get_the_post_thumbnail( get_the_ID() ) != '' ) {
		?>
<!-- <a href="the_permalink();"><img src='<?php // echo esc_url($featured_size[0]); ?>' /></a>  -->
   


    <?php
} }

if ( $image_size && has_post_thumbnail() )  {
	
echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> ';
}

 if ($atts['show_image'] === 'false')
{	
echo '';
}



else if ( get_the_post_thumbnail( get_the_ID() ) != '' ) {
	
	echo '<a href="';
	esc_url(the_permalink());
	echo '" class="rpscw-thumbnail-wrapper">';
	
	    if (!empty( $args['image_size'] ) ) {
	 the_post_thumbnail( $atts['image_size'] );
	}
	
		else if(empty( $args['image_size'] ) ) {
 the_post_thumbnail( 'featured-size' );
	}

	
	else  if(isset($featured_size)){
 the_post_thumbnail( 'featured-size' );
	}

	// echo $featured_size[0];
	echo '</a>';
}




else {
	
	echo '<img src="' . esc_url(plugins_url( 'images/default.jpg', __FILE__ )) . '" > ';
	
}



?>

</div>
<br/>
<div class="rpscw-sidept"><a href="<?php
		esc_url(the_permalink()); ?>"><?php
		sanitize_text_field(the_title()); ?></a></div>
 <div class="rpscw-excerptsc">
        
<?php
		if ($atts['enable_excerpt'] == 'true')
        { 
        
 echo wp_trim_words(get_the_excerpt(), $atts['excerptlength']);
	
	}
	
else  if ($atts['enable_excerpt'] == '')

	   { 
        
 echo wp_trim_words(get_the_excerpt(), $atts['excerptlength']);
	
	}
		
else  if ($atts['enable_excerpt'] == 'false')
        { 
 echo '';
		
		}
 ?>

</div>
        
        

<div class="rpscw-postmeta">

        <?php
		if ($atts['excerpt_more'] === 'true')
			{ ?>

<div class="rpscw-readmore">
 
 

   <?php  echo '<a href="';
	esc_url(the_permalink());
	echo '">';
	echo sanitize_text_field($atts['label']);
		echo '</a>'; ?>
 
  </div> 

        <?php
			} ?>

<div class="rpscw-infoblock">

<?php
		if ($atts['include_author'] === 'true')
			{ ?>

<div class="rpscw-author">By <?php
			esc_url(the_author_posts_link()); ?> </div>

        <?php
			} ?>


<?php
		if ($atts['get_cat_name'] === 'true')
			{ ?>

<div class="rpscw-postedin">

Posted in: <?php
			esc_url(the_category(', ')); ?>
            
            </div>
        <?php
			} ?>
    
        
<div class="rpscw-datetime">

Posted On: <?php
		the_time('jS F Y'); ?>

</div>

  
  

  


</div>

</div>


            </div>
            </div>

     
            
        <?php
		}

	echo ('</div>');
	$outputcontent = ob_get_contents();
	ob_end_clean();
	return $outputcontent;
	wp_reset_postdata();
?>




        

<?php
	}
	
	
 function rpscw_dynamic_sidebar_params_hook( $content) {

  if( has_shortcode( $content, 'recentposts-sc' ) ) {
	    $content = '<div class="rpscw-sidebar">'.$content.'</div>';
return $content;
 }  
 
 else {
return $content;
	 
 }
 
 }
 add_filter('widget_text', 'rpscw_dynamic_sidebar_params_hook');

// function rpscw_widget_content_wrap($content) {
//    $content = '<div class="rpscw-sidebar">'.$content.'</div>';	
 //   return $content;
// }

// add_filter('widget_text', 'rpscw_widget_content_wrap');


add_shortcode('recentposts-sc', 'rpscw_recent_posts_shortcode');


?>