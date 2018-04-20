<?php

 /*
Template Name: Custom Page
Template Post Type: post, page
*/

 get_header(); ?>


<div class="section1">
<?php echo do_shortcode('[product_categories]'); ?>

</div>


<?php 

$image = get_field('background-image');

if( !empty($image) ): ?>

    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

<?php endif; ?>
<div class="col-md-6"></div>

<div class="col-md-6 box">
<?php echo do_shortcode('[testimonialrecent set="1]'); ?>

</div>
<div class="col-md-12 blgpost">
    <div class="col-md-2">
        
    </div><div class="col-md-8">
        <h2 class="Receipe">Receipe</h2>
        <p class="receipe">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
    </div>


    <div class="col-md-2"></div>
<?php echo do_shortcode('[recentposts-sc]'); ?>
</div>
<?php echo do_shortcode('[insta-gallery id="1"]'); ?>



<?php
get_footer();