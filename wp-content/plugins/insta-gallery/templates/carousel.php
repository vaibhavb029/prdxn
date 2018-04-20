<?php
/**
 * The Template for displaying Carousel
 *
 * This template can be overridden by copying it to yourtheme/insta-gallery/carousel.php.
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

$JSICSelector = '#instagal-' . $IGItem['gid']; // Gallery selector
?>
<div class="swiper-container instacarousel" data-source="<?php echo $insta_source; ?>" id="instagal-<?php echo $IGItem['gid']; ?>">
	<div class="swiper-wrapper">
<?php
$i = 1;
foreach ($instaItems as $item) {
    if (! empty($item['img_low']) && ! empty($item['img_standard']) && ! empty($item['img_thumb'])) {
        $img_src = ($IGItem['insta_car-slidespv'] == 1) ? $item['img_standard'] : ((($IGItem['insta_car-slidespv'] > 10) || ($IGItem['insta_thumb-size'] == 'small')) ? $item['img_thumb'] : $item['img_low']);
        $link = 'https://www.instagram.com/p/'. $item['code'] .'/';
        if ($IGItem['insta_gal-popup']) {
            $link = $item['img_standard'];
        }
        $caption = '';
        if($IGItem['insta_popup-caption'] && $IGItem['insta_gal-popup']){
            $caption = $item['caption'];
        }
        ?>
        <div class="swiper-slide">
			<a href="<?php echo $link; ?>" target="blank" data-title="<?php echo $caption; ?>" class="nofancybox"> <img alt="instagram" class="instacarousel-image"
				src="<?php echo $img_src; ?>" />
        <?php
        if ($IGItem['insta_likes'] || $IGItem['insta_comments']) {
            echo '<span class="ic-likes-comments">';
            if ($IGItem['insta_likes'] && ((int)$item['likes'] != 0)) {
                echo '<span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><path d="M377.594 32c-53.815 0-100.129 43.777-121.582 89.5-21.469-45.722-67.789-89.5-121.608-89.5-74.191 0-134.404 60.22-134.404 134.416 0 150.923 152.25 190.497 256.011 339.709 98.077-148.288 255.989-193.603 255.989-339.709 0-74.196-60.215-134.416-134.406-134.416z" fill="#fff"></path>Likes </svg>' . $item['likes'] . '</span>';
            }
            if ($IGItem['insta_comments'] && ((int)$item['comments'] != 0)) {
                echo '<span><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><path d="M256 32c-141.385 0-256 93.125-256 208s114.615 208 256 208c13.578 0 26.905-0.867 39.912-2.522 54.989 54.989 120.625 64.85 184.088 66.298v-13.458c-34.268-16.789-64-47.37-64-82.318 0-4.877 0.379-9.665 1.082-14.348 57.898-38.132 94.918-96.377 94.918-161.652 0-114.875-114.615-208-256-208z" fill="#fff"></path>Comments </svg>' . $item['comments'] . '</span>';
            }
            echo '</span>';
        }
        ?>
        </a>
		</div>
    <?php
    }
    $i ++;
    if (($IGItem['insta_limit'] != 0) && ($i > $IGItem['insta_limit']))
        break;
}
?>
</div>
	<div class="swiper-pagination"></div>
<?php if ($IGItem['insta_car-navarrows']) { ?>
    <div class="swiper-button-prev"></div>
	<div class="swiper-button-next"></div>
<?php } ?>
</div>
<?php if($IGItem['insta_instalink']){ ?>
<div class="instagallery-actions">
	<a href="<?php echo $instaUrl; ?>" target="blank" class="igact-instalink"><?php echo $IGItem['insta_instalink-text']; ?></a>
</div>
<?php } ?>

<?php 
// resize images to square and
// activate carousel
?>
<script>
jQuery(document).ready(function ($) {
var mySwiper;
// resize images to square
var instacarouselImages = jQuery('<?php echo $JSICSelector; ?> img.instacarousel-image');
if(instacarouselImages.length){
var totalImages = instacarouselImages.length, imagesLoaded = 0,minHeight = 0;
instacarouselImages.load(function(){
imagesLoaded++;
if(minHeight == 0)minHeight = jQuery(this).height();
// if(minHeight > jQuery(this).height())minHeight = jQuery(this).height();
if((jQuery(this).width() == jQuery(this).height()))minHeight = jQuery(this).height();
if(imagesLoaded >= totalImages){
	jQuery('<?php echo $JSICSelector; ?> img.instacarousel-image').each(function(){
var i = jQuery(this);
var th = i.height();
if(minHeight < th){
var m = (th-minHeight)/2;
jQuery(this).css('margin-top','-'+m+'px');
jQuery(this).css('margin-bottom','-'+m+'px');
}
});
mySwiper.update();
}
});
}

mySwiper = new Swiper ('<?php echo $JSICSelector; ?>', {
loop: true,
autoHeight:true,
observer: true,
observeParents: true,
<?php

if ($IGItem['insta_car-autoplay']) {
    echo "autoplay: 3000,";
}
if ($IGItem['insta_car-dots']) {
    echo "pagination: '.swiper-pagination',";
}
if ($IGItem['insta_car-navarrows']) {
    echo "nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',paginationClickable: true,";
}
if ($IGItem['insta_car-spacing']) {
    echo "spaceBetween: 20,";
}
?>
slidesPerView: <?php echo $IGItem['insta_car-slidespv']; ?>,
breakpoints: {
<?php
if ($IGItem['insta_car-slidespv'] > 3) {
    echo "1023: {
        slidesPerView: 3,
        spaceBetween: 20
    },";
}
if ($IGItem['insta_car-slidespv'] > 2) {
    echo "767: {
        slidesPerView: 2,
        spaceBetween: 15
    },";
}
echo "420: {
        slidesPerView: 1
    }";
?>
}

});
<?php
if ($IGItem['insta_gal-popup']) {
    ?>
    
    jQuery('<?php echo $JSICSelector; ?> .swiper-slide>a').magnificPopup({
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
<?php } ?>
});
</script>
