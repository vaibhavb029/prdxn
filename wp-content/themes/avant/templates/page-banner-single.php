<?php
$single_page_id = get_the_ID(); ?>

<?php if ( has_post_thumbnail( $single_page_id ) && get_theme_mod( 'avant-single-page-fimage-layout' ) == 'avant-single-page-fimage-layout-banner' ) : ?>
    
    <div class="page-fimage-banner <?php echo ( get_theme_mod( 'avant-single-page-fimage-size' ) == 'avant-single-page-fimage-size-actual' ) ? sanitize_html_class( 'page-fimage-banner-actual' ) : ''; ?>" <?php echo ( get_theme_mod( 'avant-single-page-fimage-size' ) != 'avant-single-page-fimage-size-actual' ) ? 'style="background-image: url(' . esc_url( get_the_post_thumbnail_url( $single_page_id ) ) . ');"' : ''; ?>>
        
        <?php if ( get_theme_mod( 'avant-single-page-fimage-size' ) == 'avant-single-page-fimage-size-actual' ) : ?>
            <?php the_post_thumbnail( 'full', $single_page_id ); ?>
        <?php elseif ( get_theme_mod( 'avant-single-page-fimage-size' ) == 'avant-single-page-fimage-size-extra-small' ) : ?>
            <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_extra_small.gif" />
        <?php elseif ( get_theme_mod( 'avant-single-page-fimage-size' ) == 'avant-single-page-fimage-size-small' ) : ?>
            <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_small.gif" />
        <?php elseif ( get_theme_mod( 'avant-single-page-fimage-size' ) == 'avant-single-page-fimage-size-large' ) : ?>
            <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_large.gif" />
        <?php else : ?>
            <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_medium.gif" />
        <?php endif; ?>
        
    </div> <!-- .page-fimage-banner -->
    
<?php endif; ?>