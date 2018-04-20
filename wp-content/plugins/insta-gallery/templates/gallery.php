<?php
/**
 * The Template for displaying Gallery
 *
 * This template can be overridden by copying it to yourtheme/insta-gallery/gallery.php.
 *
 * HOWEVER, on occasion will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 *
 * @package 	insta-gallery/templates
 * @version     1.1.1
 */
if (! defined('ABSPATH')) {
    exit();
}

// $insta_source : gallery source like user or tag
// $IGItem : array of gallery item setting
// $instaItems : array of gallery items

$JSIGSelector = '#instagal-' . $IGItem['gid']; // Gallery selector
?>
<div class="instagallery-items instagallery" data-source="<?php echo $insta_source; ?>" id="instagal-<?php echo $IGItem['gid']; ?>">
<?php
$i = 1;
foreach ($instaItems as $item) {
    
    $img_src = ($IGItem['insta_gal-cols'] == 1) ? $item['img_standard'] : ((($IGItem['insta_gal-cols'] > 9) || ($IGItem['insta_thumb-size'] == 'small')) ? $item['img_thumb'] : $item['img_low']);
    $hovered = $IGItem['insta_gal-hover'] ? 'ighover' : '';
    $spacing = $IGItem['insta_gal-spacing'] ? '' : 'no-spacing';
    $link = 'https://www.instagram.com/p/'. $item['code'] .'/';
    if ($IGItem['insta_gal-popup']) {
        $link = $item['img_standard'];
    }
    $caption = '';
    if($IGItem['insta_popup-caption'] && $IGItem['insta_gal-popup']){
        $caption = $item['caption'];
    }
    ?>
    <div class="ig-item <?php echo $hovered.' '. $spacing; ?> cols-<?php echo $IGItem['insta_gal-cols']; ?>" style="width: <?php echo (100 / $IGItem['insta_gal-cols']); ?>%;">
		<a href="<?php echo $link; ?>" target="blank" data-title="<?php echo $caption; ?>" class="nofancybox"> <img
			src="<?php echo $img_src; ?>" alt="instagram" class="instagallery-image" />
	<?php
    if ($IGItem['insta_likes'] || $IGItem['insta_comments']) {
        echo '<span class="ig-likes-comments">';
        if ($IGItem['insta_likes']) {
            echo '<span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><path d="M377.594 32c-53.815 0-100.129 43.777-121.582 89.5-21.469-45.722-67.789-89.5-121.608-89.5-74.191 0-134.404 60.22-134.404 134.416 0 150.923 152.25 190.497 256.011 339.709 98.077-148.288 255.989-193.603 255.989-339.709 0-74.196-60.215-134.416-134.406-134.416z" fill="#fff"></path>Likes </svg>' . $item['likes'] . '</span>';
        }
        if ($IGItem['insta_comments']) {
            echo '<span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><path d="M256 32c-141.385 0-256 93.125-256 208s114.615 208 256 208c13.578 0 26.905-0.867 39.912-2.522 54.989 54.989 120.625 64.85 184.088 66.298v-13.458c-34.268-16.789-64-47.37-64-82.318 0-4.877 0.379-9.665 1.082-14.348 57.898-38.132 94.918-96.377 94.918-161.652 0-114.875-114.615-208-256-208z" fill="#fff"></path>Comments </svg>' . $item['comments'] . '</span>';
        }
        echo '</span>';
    }
    ?>
    </a>
	</div>
	<?php
    $i ++;
    if (($IGItem['insta_limit'] != 0) && ($i > $IGItem['insta_limit']))
        break;
}
?>
</div>
<?php
if ($IGItem['insta_instalink']) {
    ?>
<div class="instagallery-actions">
	<a href="<?php echo $instaUrl; ?>" target="blank" class="igact-instalink"><?php echo $IGItem['insta_instalink-text']; ?></a>
</div>
<?php } ?>


<?php

// resize images to square and
// activate popup
if ($IGItem['insta_gal-popup']) {
    ?>
<script>
    jQuery(document).ready(function ($) {

        // resize images to square
    	var instagalleryImages = jQuery('<?php echo $JSIGSelector; ?> .ig-item img.instagallery-image');
    	if(instagalleryImages.length){
    		var totalImages = instagalleryImages.length, imagesLoaded = 0,minHeight = 0;
    		instagalleryImages.load(function(){
    		    imagesLoaded++;
    		    if(minHeight == 0)minHeight = jQuery(this).height();
    		    // if(minHeight > jQuery(this).height())minHeight = jQuery(this).height();
                if((jQuery(this).width() == jQuery(this).height()))minHeight = jQuery(this).height();
    		    if(imagesLoaded >= totalImages){
    		    jQuery('<?php echo $JSIGSelector; ?> .ig-item img.instagallery-image').each(function(){
                        var i = jQuery(this);
                        var th = i.height();
    		   	 		if(minHeight < th){
                            var m = (th-minHeight)/2;
    		   	 			jQuery(this).css('margin-top','-'+m+'px');
    		   	 			jQuery(this).css('margin-bottom','-'+m+'px');
    		   	 		}
    		   	 	});
    		    }
    		});
    	}
      jQuery('<?php echo $JSIGSelector; ?> .ig-item a').magnificPopup({
        type: 'image',
        mainClass: 'mfp-with-zoom',
        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function(openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        },
        gallery: {
            enabled: true
        },
        image: {
            titleSrc: function(item) {
              return item.el.attr('data-title');
            }
          }
      });
    });
    </script>
<?php
}
