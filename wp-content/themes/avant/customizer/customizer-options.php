<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library Avant
 */

function customizer_library_avant_options() {

	$primary_color = '#de7158';
	$secondary_color = '#ab3d3a';

    $header_bg_color = '#FFFFFF';
    $header_font_color = '#AAAAAA';

	$body_font_color = '#636161';
	$heading_font_color = '#3a3a3a';

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;


    // Header Image
    $section = 'title_tagline';
    
    $sections[] = array(
        'id' => $section,
        'title' => __( 'Site Identity', 'avant' ),
        'priority' => '10',
        'description' => 'Change/edit the <a href="#avant-site-layout-section-header" rel="tc-section">Header</a> & <a href="#avant-site-layout-section-footer" rel="tc-section">Footer</a> Layouts<br />Edit/Change <a href="#avant-panel-colors" rel="tc-panel">Theme Colors</a><br />Add a <a href="#avant-site-layout-section-slider" rel="tc-section">Home Page Slider</a><br />Change/edit the <a href="#avant-blog-section-blog" rel="tc-section">Blog Layout</a><br />Add/edit <a href="#avant-site-layout-section-page" rel="tc-section">Pages Featured Image</a><br />Add/edit <a href="#avant-blog-section-post" rel="tc-section">Single Posts featured image</a><br />Add <a href="#avant-social-section" rel="tc-section">Social Links</a> to your site',
    );

    $options['avant-branding-top-pad'] = array(
        'id' => 'avant-branding-top-pad',
        'label'   => __( 'Site Title top padding', 'avant' ),
        'section' => $section,
        'type'    => 'number',
        'default' => 40,
    );
    $options['avant-branding-bottom-pad'] = array(
        'id' => 'avant-branding-bottom-pad',
        'label'   => __( 'Site Title bottom padding', 'avant' ),
        'section' => $section,
        'type'    => 'number',
        'default' => 60,
    );
    $options['avant-logo-max-width'] = array(
        'id' => 'avant-logo-max-width',
        'label'   => __( 'Set a max-width for the logo', 'avant' ),
        'section' => $section,
        'type'    => 'number',
        'description' => __( 'This only applies if a logo image is uploaded', 'avant' ),
    );
    $options['avant-site-tagline-case-normal'] = array(
        'id' => 'avant-site-tagline-case-normal',
        'label'   => __( 'Site Tagline - Normal Case', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
    );

    $panel = 'avant-panel-layout';

    $panels[] = array(
        'id' => $panel,
        'title' => __( 'Avant Theme Settings', 'avant' ),
        'priority' => '30'
    );

	$section = 'avant-site-layout-section-site';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Site Layout', 'avant' ),
		'priority' => '10',
        'description' => 'Change/edit the <a href="#avant-site-layout-section-header" rel="tc-section">Header</a> & <a href="#avant-site-layout-section-footer" rel="tc-section">Footer</a> Layouts<br />Edit/Change <a href="#avant-panel-colors" rel="tc-panel">Theme Colors</a><br />Add a <a href="#avant-site-layout-section-slider" rel="tc-section">Home Page Slider</a><br />Change/edit the <a href="#avant-blog-section-blog" rel="tc-section">Blog Layout</a><br />Add/edit <a href="#avant-site-layout-section-page" rel="tc-section">Pages Featured Image</a><br />Add/edit <a href="#avant-blog-section-post" rel="tc-section">Single Posts featured image</a><br />Add <a href="#avant-social-section" rel="tc-section">Social Links</a> to your site',
        'panel' => $panel
	);
    
    $options['avant-remove-topborder'] = array(
        'id' => 'avant-remove-topborder',
        'label'   => __( 'Remove Top Border', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $choices = array(
        'avant-site-boxed' => __( 'Boxed Layout', 'avant' ),
        'avant-site-full-width' => __( 'Full Width Layout', 'avant' )
    );
    $options['avant-site-layout'] = array(
        'id' => 'avant-site-layout',
        'label'   => __( 'Site Layout', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-site-full-width'
    );
    $options['avant-remove-content-bgborder'] = array(
        'id' => 'avant-remove-content-bgborder',
        'label'   => __( 'Remove Content Background & Borders', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-add-sidebar-line'] = array(
        'id' => 'avant-add-sidebar-line',
        'label'   => __( 'Add Sidebar divider line', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-site-add-side-social'] = array(
        'id' => 'avant-site-add-side-social',
        'label'   => __( 'Add Side Aligned Social Icons', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Add <a href="#avant-social-section" rel="tc-section">Social Icons</a> for this to show', 'avant' ),
        'default' => 0,
    );
    $options['avant-noteon-layout'] = array(
        'id' => 'avant-noteon-layout',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Add Title & Tagline with uploaded logo and adjust<br />- Set custom website container width<br />- Set custom Sidebar width<br />- Change Side Social Links design<br />- Change Site Attribution text', 'avant' )
    );


    $section = 'avant-site-layout-section-header';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Header', 'avant' ),
        'priority' => '20',
        'description' => 'Customize the <a href="#avant-panel-colors" rel="tc-panel">Header Colors</a>, add <a href="#avant-social-section" rel="tc-section">Social links</a> and edit <a href="#avant-website-section-text-header" rel="tc-section">Header text</a> or <a href="#avant-panel-font-settings" rel="tc-panel">Site Fonts</a>',
        'panel' => $panel
    );

    $options['avant-header-remove-topbar'] = array(
        'id' => 'avant-header-remove-topbar',
        'label'   => __( 'Remove Top Bar', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-header-topbar-switch'] = array(
        'id' => 'avant-header-topbar-switch',
        'label'   => __( 'Switch Top Bar', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $choices = array(
        'avant-header-layout-one' => __( 'Default Header', 'avant' ),
        'avant-header-layout-two' => __( 'Centered Header', 'avant' ),
        'avant-header-layout-three' => __( 'Centered Header Social', 'avant' ),
        'avant-header-layout-four' => __( 'Standard Header', 'avant' ),
        'avant-header-layout-five' => __( 'Standard Header Social', 'avant' ),
        'avant-header-layout-six' => __( 'Side Layout Header', 'avant' ),
        'avant-header-layout-seven' => __( 'Transparent Header', 'avant' )
    );
    $options['avant-header-layout'] = array(
        'id' => 'avant-header-layout',
        'label'   => __( 'Header Layout', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-header-layout-one'
    );
    $options['avant-header-nav-case-normal'] = array(
        'id' => 'avant-header-nav-case-normal',
        'label'   => __( 'Navigation - Normal Case', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
    );
    $options['avant-noteon-nav-style'] = array(
        'id' => 'avant-noteon-nav-style',
        'section' => $section,
        'type'    => 'help',
        'description' => __( '<a href="https://kairaweb.com/documentation/change-navigation-drop-direction-custom-css-class/" target="_blank">Switch the direction</a> of the navigation dropdown', 'avant' )
    );
    $options['avant-header-switch'] = array(
        'id' => 'avant-header-switch',
        'label'   => __( 'Switch Header', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-header-remove-slider-space'] = array(
        'id' => 'avant-header-remove-slider-space',
        'label'   => __( 'Remove Slider Top Space', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $choices = array(
        'avant-nav-align-right' => __( 'Align Right', 'avant' ),
        'avant-nav-align-left' => __( 'Align Left', 'avant' ),
        'avant-nav-align-center' => __( 'Align Center', 'avant' )
    );
    $options['avant-header-nav-align'] = array(
        'id' => 'avant-header-nav-align',
        'label'   => __( 'Navigation Alignment', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-nav-align-right'
    );
    $options['avant-header-menu-text'] = array(
        'id' => 'avant-header-menu-text',
        'label'   => __( 'Menu Button Text', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'default' => 'menu',
        'description' => __( 'This is the text for the mobile menu button', 'avant' )
    );
    $options['avant-header-search'] = array(
        'id' => 'avant-header-search',
        'label'   => __( 'Remove Search', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-header-remove-no'] = array(
        'id' => 'avant-header-remove-no',
        'label'   => __( 'Remove Phone Number', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-header-remove-add'] = array(
        'id' => 'avant-header-remove-add',
        'label'   => __( 'Remove Address', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-header-remove-social'] = array(
        'id' => 'avant-header-remove-social',
        'label'   => __( 'Remove Social Icons', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    if ( avant_is_woocommerce_activated() ) :
        $options['avant-header-remove-cart'] = array(
            'id' => 'avant-header-remove-cart',
            'label'   => __( 'Remove WooCommerce Cart', 'avant' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'fa-shopping-cart' => __( 'Shopping Cart', 'avant' ),
            'fa-shopping-basket' => __( 'Shopping Basket', 'avant' ),
            'fa-shopping-bag' => __( 'Shopping Bag', 'avant' )
        );
        $options['avant-cart-icon'] = array(
            'id' => 'avant-cart-icon',
            'label'   => __( 'Cart Icon', 'avant' ),
            'section' => $section,
            'type'    => 'select',
            'description' => __( 'Due to the AJAX, This will only change when you open the site again in a new tab', 'avant' ),
            'choices' => $choices,
            'default' => 'fa-shopping-cart'
        );
    endif;
    $options['avant-noteon-header'] = array(
        'id' => 'avant-noteon-header',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Sticky Navigation<br />- Change Navigation Styling<br />- Add extra text to the header<br />- Option to replace default search with Shortcode', 'avant' )
    );
    

    $section = 'avant-site-layout-section-slider';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Home Page Slider', 'avant' ),
        'priority' => '30',
        'panel' => $panel
    );

    $choices = array(
        'avant-slider-default' => __( 'Default Slider', 'avant' ),
        'avant-shortcode-slider' => __( 'Slider Shortcode', 'avant' ),
        'avant-home-featured-image' => __( 'Featured Image', 'avant' ),
        'avant-no-slider' => __( 'None', 'avant' )
    );
    $options['avant-slider-type'] = array(
        'id' => 'avant-slider-type',
        'label'   => __( 'Choose a Slider', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-slider-default'
    );
    $options['avant-slider-cats'] = array(
        'id' => 'avant-slider-cats',
        'label'   => __( 'Slider Categories', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the ID\'s of the post categories you want to display in the slider. Eg: "13,17,19" (no spaces and only comma\'s)<br /><br />Get the ID at <b>Posts -> Categories</b>.<br /><br />Or <a href="https://kairaweb.com/documentation/setting-up-the-default-slider/" target="_blank"><b>See more instructions here</b></a>', 'avant' )
    );
    $options['avant-slider-shortcode'] = array(
        'id' => 'avant-slider-shortcode',
        'label'   => __( 'Slider Shortcode', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the shortcode give by the slider.', 'avant' )
    );
    $options['avant-slider-full-width'] = array(
        'id' => 'avant-slider-full-width',
        'label'   => __( 'Set slider to full width', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $choices = array(
        'avant-slider-size-small' => __( 'Small Slider', 'avant' ),
        'avant-slider-size-medium' => __( 'Medium Slider', 'avant' ),
        'avant-slider-size-large' => __( 'Large Slider', 'avant' )
    );
    $options['avant-slider-size'] = array(
        'id' => 'avant-slider-size',
        'label'   => __( 'Slider Size', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-slider-size-medium'
    );
    $choices = array(
        'crossfade' => __( 'Fade', 'avant' ),
        'cover-fade' => __( 'Cover Fade', 'avant' ),
        'uncover-fade' => __( 'Uncover Fade', 'avant' ),
        'cover' => __( 'Cover', 'avant' ),
        'scroll' => __( 'Scroll', 'avant' )
    );
    $options['avant-slider-scroll-effect'] = array(
        'id' => 'avant-slider-scroll-effect',
        'label'   => __( 'Slider Scroll Effect', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'crossfade'
    );
    $options['avant-slider-linkto-post'] = array(
        'id' => 'avant-slider-linkto-post',
        'label'   => __( 'Link Slide to post', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-slider-remove-title'] = array(
        'id' => 'avant-slider-remove-title',
        'label'   => __( 'Remove Slider Title & Text', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-slider-remove-sub-title'] = array(
        'id' => 'avant-slider-remove-sub-title',
        'label'   => __( 'Remove Slider Excerpt Only', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-slider-remove-pagination'] = array(
        'id' => 'avant-slider-remove-pagination',
        'label'   => __( 'Remove Slider Pagination', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-slider-auto-scroll'] = array(
        'id' => 'avant-slider-auto-scroll',
        'label'   => __( 'Stop Auto Scroll', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    
    $choices = array(
        'avant-slidermage-size-extra-small' => __( 'Extra Small Image', 'avant' ),
        'avant-slidermage-size-small' => __( 'Small Image', 'avant' ),
        'avant-slidermage-size-medium' => __( 'Medium Image', 'avant' ),
        'avant-slidermage-size-large' => __( 'Large Image', 'avant' ),
        'avant-slidermage-size-actual' => __( 'Use Full Image', 'avant' )
    );
    $options['avant-slidermage-size'] = array(
        'id' => 'avant-slidermage-size',
        'label'   => __( 'Image Size', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-slidermage-size-medium'
    );
    $options['avant-slidermage-fullwidth'] = array(
        'id' => 'avant-slidermage-fullwidth',
        'label'   => __( 'Make Full Width', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );


    $section = 'avant-blog-section-blog';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Blog List', 'avant' ),
        'priority' => '40',
        'panel' => $panel
    );

    $options['avant-blog-break-blocks'] = array(
        'id' => 'avant-blog-break-blocks',
        'label'   => __( 'Break into Blocks', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $choices = array(
        'blog-left-layout' => __( 'Left Layout', 'avant' ),
        'blog-right-layout' => __( 'Right Layout', 'avant' ),
        'blog-alt-layout' => __( 'Alternate Layout', 'avant' ),
        'blog-top-layout' => __( 'Top Layout', 'avant' ),
        'blog-blocks-layout' => __( 'Blocks Layout', 'avant' )
    );
    $options['avant-blog-layout'] = array(
        'id' => 'avant-blog-layout',
        'label'   => __( 'Blog Posts Layout', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'blog-left-layout'
    );
    $choices = array(
        'blog-post-shape-square' => __( 'All Images Square', 'avant' ),
        'blog-post-shape-round' => __( 'All Images Round', 'avant' ),
        'blog-post-shape-img' => __( 'Actual Image Shape', 'avant' )
    );
    $options['avant-blog-post-shape'] = array(
        'id' => 'avant-blog-post-shape',
        'label'   => __( 'Blog Post Image Shape', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'blog-post-shape-square'
    );
    $options['avant-blog-list-img-cut'] = array(
        'id' => 'avant-blog-list-img-cut',
        'label'   => __( 'Blog Image Cut', 'avant' ),
        'section' => $section,
        'type'    => 'imageselect',
        'description' => __( 'Select which cut the Blog list uses<br />Recommended: Optimize images before upload', 'avant' ),
        'default' => 'large'
    );
    $options['avant-blog-blocks-remove-border'] = array(
        'id' => 'avant-blog-blocks-remove-border',
        'label'   => __( 'Remove Blocks Border', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-blog-blocks-remove-meta'] = array(
        'id' => 'avant-blog-blocks-remove-meta',
        'label'   => __( 'Remove Meta Info', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-blog-blocks-remove-content'] = array(
        'id' => 'avant-blog-blocks-remove-content',
        'label'   => __( 'Remove Content', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-blog-blocks-remove-tagcats'] = array(
        'id' => 'avant-blog-blocks-remove-tagcats',
        'label'   => __( 'Remove Tags & Categories', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-blog-cats'] = array(
        'id' => 'avant-blog-cats',
        'label'   => __( 'Exclude Blog Categories', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the ID\'s of the post categories you\'d like to EXCLUDE from the Blog, enter only the ID\'s with a minus sign (-) before them, separated by a comma (,)<br />Eg: "-13, -17, -19"<br /><br />If you enter the ID\'s without the minus then it\'ll show ONLY posts in those categories.<br /><br />Get the ID at <b>Posts -> Categories</b>.', 'avant' )
    );

    $options['avant-remove-blog-title'] = array(
        'id' => 'avant-remove-blog-title',
        'label'   => __( 'Remove Blog & Archive Page Titles', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-remove-cat-pre-title'] = array(
        'id' => 'avant-remove-cat-pre-title',
        'label'   => __( 'Remove text before Archive Title', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'This will not update in the Customizer. Exit the Customizer to view the change', 'avant' ),
        'default' => 0,
    );
    $options['avant-noteon-blog'] = array(
        'id' => 'avant-noteon-blog',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Set Blog, Archives and Single pages to Left Sidebar<br />- Set Blog, Archives and Single pages to Full Width<br />- Set Blog list & archives to use post summary<br />- Extra summary settings<br />- Set custom Blocks layout columns<br />- Set spacing of Blocks layout<br />- Change Blocks styling (Image or Post layouts)', 'avant' )
    );

    $section = 'avant-blog-section-post';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Blog Single Posts', 'avant' ),
        'priority' => '50',
        'panel' => $panel
    );

    $choices = array(
        'avant-single-page-fimage-layout-none' => __( 'None', 'avant' ),
        'avant-single-page-fimage-layout-standard' => __( 'Standard', 'avant' ),
        'avant-single-page-fimage-layout-banner' => __( 'Page Banner', 'avant' )
    );
    $options['avant-single-page-fimage-layout'] = array(
        'id' => 'avant-single-page-fimage-layout',
        'label'   => __( 'Featured Image Layout', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-single-page-fimage-layout-none'
    );
    $choices = array(
        'avant-single-page-fimage-size-extra-small' => __( 'Extra Small Banner', 'avant' ),
        'avant-single-page-fimage-size-small' => __( 'Small Banner', 'avant' ),
        'avant-single-page-fimage-size-medium' => __( 'Medium Banner', 'avant' ),
        'avant-single-page-fimage-size-large' => __( 'Large Banner', 'avant' ),
        'avant-single-page-fimage-size-actual' => __( 'Use Proper Image', 'avant' )
    );
    $options['avant-single-page-fimage-size'] = array(
        'id' => 'avant-single-page-fimage-size',
        'label'   => __( 'Page Banner Size', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-single-page-fimage-size-medium'
    );

    $options['avant-single-remove-meta'] = array(
        'id' => 'avant-single-remove-meta',
        'label'   => __( 'Remove Meta Info', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-single-remove-cattags'] = array(
        'id' => 'avant-single-remove-cattags',
        'label'   => __( 'Remove Tags & Categories', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-noteon-blog-single'] = array(
        'id' => 'avant-noteon-blog-single',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Set Featured Image banner to Full Width', 'avant' )
    );


    $section = 'avant-site-layout-section-page';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Pages', 'avant' ),
        'priority' => '70',
        'panel' => $panel
    );
    
    $options['avant-page-sidebar-blocks'] = array(
        'id' => 'avant-page-sidebar-blocks',
        'label'   => __( 'Break Sidebar into Blocks', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-page-remove-titlebar'] = array(
        'id' => 'avant-page-remove-titlebar',
        'label'   => __( 'Remove all Page Titles', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-page-widget-spacing'] = array(
        'id' => 'avant-page-widget-spacing',
        'label'   => __( 'Sidebar Widget Spacing', 'avant' ),
        'section' => $section,
        'type'    => 'range',
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'step'  => 2,
        ),
        'default' => 50
    );
    $options['avant-blog-widget-title-size'] = array(
        'id' => 'avant-blog-widget-title-size',
        'label'   => __( 'Sidebar Title Size', 'avant' ),
        'section' => $section,
        'type'    => 'number',
        'default' => 12,
    );
    $options['avant-blog-widget-title-leftalign'] = array(
        'id' => 'avant-blog-widget-title-leftalign',
        'label'   => __( 'Left Align Title', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $choices = array(
        'widget-title-style-plain' => __( 'Plain', 'avant' ),
        'widget-title-style-underline-dots' => __( 'Underlined Dots', 'avant' ),
        'widget-title-style-underline-solid' => __( 'Underlined Solid', 'avant' ),
        'widget-title-style-underline-short' => __( 'Short Underline', 'avant' )
    );
    $options['avant-blog-widget-title-style'] = array(
        'id' => 'avant-blog-widget-title-style',
        'label'   => __( 'Widget Title Styling', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'widget-title-style-plain'
    );

    $choices = array(
        'avant-page-fimage-layout-none' => __( 'None', 'avant' ),
        'avant-page-fimage-layout-standard' => __( 'Standard', 'avant' ),
        'avant-page-fimage-layout-banner' => __( 'Page Banner', 'avant' )
    );
    $options['avant-page-fimage-layout'] = array(
        'id' => 'avant-page-fimage-layout',
        'label'   => __( 'Featured Image Layout', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-page-fimage-layout-none'
    );
    $choices = array(
        'avant-page-fimage-size-extra-small' => __( 'Extra Small Banner', 'avant' ),
        'avant-page-fimage-size-small' => __( 'Small Banner', 'avant' ),
        'avant-page-fimage-size-medium' => __( 'Medium Banner', 'avant' ),
        'avant-page-fimage-size-large' => __( 'Large Banner', 'avant' ),
        'avant-page-fimage-size-actual' => __( 'Use Proper Image', 'avant' )
    );
    $options['avant-page-fimage-size'] = array(
        'id' => 'avant-page-fimage-size',
        'label'   => __( 'Page Banner Size', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-page-fimage-size-medium'
    );
    $options['avant-page-content-spacing'] = array(
        'id' => 'avant-page-content-spacing',
        'label'   => __( 'Content Border Radius', 'avant' ),
        'section' => $section,
        'type'    => 'range',
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 40,
            'step'  => 2,
        ),
        'default' => 0
    );
    $options['avant-noteon-pages'] = array(
        'id' => 'avant-noteon-pages',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Set Featured Image banner to Full Width', 'avant' )
    );


    $section = 'avant-site-layout-section-footer';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Footer', 'avant' ),
        'priority' => '80',
        'description' => 'Customize the <a href="#avant-panel-colors" rel="tc-panel">Footer Colors</a>, add <a href="#avant-social-section" rel="tc-section">Social links</a> or <a href="#avant-panel-font-settings" rel="tc-panel">Site Fonts</a>',
        'panel' => $panel
    );

    $choices = array(
        'avant-footer-layout-standard' => __( 'Standard Layout', 'avant' ),
        'avant-footer-layout-social' => __( 'Social Layout', 'avant' ),
        'avant-footer-layout-none' => __( 'None', 'avant' )
    );
    $options['avant-footer-layout'] = array(
        'id' => 'avant-footer-layout',
        'label'   => __( 'Footer Layout', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'avant-footer-layout-standard'
    );
    $options['avant-noteon-footer-standard'] = array(
        'id' => 'avant-noteon-footer-standard',
        'section' => $section,
        'type'    => 'help',
        'description' => __( 'The Standard Footer is divided into columns by the amount of widgets that are added under<br /><i>Dashboard -> Appearance -> <a href="#widgets" rel="tc-panel">Widgets</a></i>', 'avant' )
    );
    $options['avant-noteon-footer-social'] = array(
        'id' => 'avant-noteon-footer-social',
        'section' => $section,
        'type'    => 'help',
        'description' => __( 'Add your <a href="#avant-social-section" rel="tc-section">Social links</a> to the footer', 'avant' )
    );
    
    $options['avant-footer-side-fullwidth'] = array(
        'id' => 'avant-footer-side-fullwidth',
        'label'   => __( 'Set Footer to Full Width', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-bottombar-switch'] = array(
        'id' => 'avant-bottombar-switch',
        'label'   => __( 'Switch Bottom Bar', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-noteon-footer'] = array(
        'id' => 'avant-noteon-footer',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Change Site Attribution text<br />- New Custom Footer layout<br />- Edit Custom Columns amount and Custom Widths<br />- Remove Social Icons<br />- Remove Footer bottom bar<br />- Adjust Footer top & bottom padding', 'avant' )
    );


    // WooCommerce style Layout
    if ( avant_is_woocommerce_activated() ) :

        $section = 'avant-site-layout-section-woocommerce';

        $sections[] = array(
            'id' => $section,
            'title' => __( 'WooCommerce', 'avant' ),
            'priority' => '90',
            'panel' => $panel
        );
        
        $options['avant-remove-wc-page-titles'] = array(
            'id' => 'avant-remove-wc-page-titles',
            'label'   => __( 'Remove Shop Page Titles', 'avant' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['avant-remove-product-border'] = array(
            'id' => 'avant-remove-product-border',
            'label'   => __( 'Remove Product Border', 'avant' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['avant-remove-wc-results-sorting'] = array(
            'id' => 'avant-remove-wc-results-sorting',
            'label'   => __( 'Remove Shop Results & Sorting', 'avant' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['avant-remove-cats-count'] = array(
            'id' => 'avant-remove-cats-count',
            'label'   => __( 'Remove Categories Count', 'avant' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['avant-align-product-titles'] = array(
            'id' => 'avant-align-product-titles',
            'label'   => __( 'Align Product Titles', 'avant' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Try keep titles to 2 lines, if more then you can <a href="https://kairaweb.com/documentation/add-custom-css-to-align-the-woocommerce-titles/" target="_blank">add CSS to align the titles</a>', 'avant' ),
            'default' => 0,
        );
        $options['avant-wc-mobile-prod-full-width'] = array(
            'id' => 'avant-wc-mobile-prod-full-width',
            'label'   => __( 'Products Full Width on Mobile', 'avant' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['avant-noteon-woocommerce'] = array(
            'id' => 'avant-noteon-woocommerce',
            'section' => $section,
            'type'    => 'note',
            'description' => __( '<b>Premium Extra Features:</b><br />- Set Products Per Page<br />- Set Products Per Row<br />- Set Shop, Archives and Product pages to Left Sidebar<br />- Set Shop, Archives and Product pages to Full Width', 'avant' )
        );

    endif;


    $panel = 'avant-panel-font-settings';

    $panels[] = array(
        'id' => $panel,
        'title' => __( 'Avant Font Settings', 'avant' ),
        'priority' => '40'
    );

    // Font Options
    $section = 'avant-typography-section';
    $font_choices = customizer_library_get_font_choices();

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Title/Tagline Fonts', 'avant' ),
        'priority' => '20',
        'panel' => $panel
    );

    $options['avant-site-title-uc'] = array(
        'id' => 'avant-site-title-uc',
        'label'   => __( 'Site Title - Uppercase', 'avant' ),
        'section' => $section,
        'type'    => 'checkbox',
        'default' => 0,
    );
    $options['avant-title-font'] = array(
        'id' => 'avant-title-font',
        'label'   => __( 'Site Title Font', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $font_choices,
        'default' => 'Parisienne'
    );
    $options['avant-title-font-size'] = array(
        'id' => 'avant-title-font-size',
        'label'   => __( 'Site Title Size', 'avant' ),
        'section' => $section,
        'type'    => 'number',
        'default' => 94,
    );
    $options['avant-tagline-font'] = array(
        'id' => 'avant-tagline-font',
        'label'   => __( 'Site Tagline Font', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $font_choices,
        'default' => 'Lato'
    );
    $options['avant-tagline-font-size'] = array(
        'id' => 'avant-tagline-font-size',
        'label'   => __( 'Site Tagline Size', 'avant' ),
        'section' => $section,
        'type'    => 'number',
        'default' => 12,
    );
    $options['avant-title-bottom-margin'] = array(
        'id' => 'avant-title-bottom-margin',
        'label'   => __( 'Site Title Bottom Margin', 'avant' ),
        'section' => $section,
        'type'    => 'number',
        'description' => __( 'This will set the space between the site title and the site tagline', 'avant' ),
        'default' => 0,
    );
    $options['avant-noteon-fonts-title'] = array(
            'id' => 'avant-noteon-fonts-title',
            'section' => $section,
            'type'    => 'note',
            'description' => __( '<b>Premium Extra Features:</b><br />- Set custom Title & Tagline colors', 'avant' )
        );

    $section = 'avant-typography-section-default';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Site Fonts', 'avant' ),
        'priority' => '20',
        'panel' => $panel
    );

    $options['avant-body-font'] = array(
        'id' => 'avant-body-font',
        'label'   => __( 'Body Font', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $font_choices,
        'default' => 'Open Sans'
    );
    $options['avant-body-font-color'] = array(
        'id' => 'avant-body-font-color',
        'label'   => __( 'Body Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $body_font_color,
    );

    $options['avant-heading-font'] = array(
        'id' => 'avant-heading-font',
        'label'   => __( 'Heading Font', 'avant' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $font_choices,
        'default' => 'Lato'
    );
    $options['avant-heading-font-color'] = array(
        'id' => 'avant-heading-font-color',
        'label'   => __( 'Heading Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $heading_font_color,
    );
    $options['avant-page-title-font-color'] = array(
        'id' => 'avant-page-title-font-color',
        'label'   => __( 'Page Title Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $heading_font_color,
    );
    $options['avant-bloglist-title-color'] = array(
        'id' => 'avant-bloglist-title-color',
        'label'   => __( 'Blog List Title Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $heading_font_color,
    );
    $options['avant-sidebar-widget-title-color'] = array(
        'id' => 'avant-sidebar-widget-title-color',
        'label'   => __( 'Sidebar Widget Title Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $heading_font_color,
    );
    // WooCommerce style Layout
    if ( avant_is_woocommerce_activated() ) :
        $options['avant-wc-product-title-size'] = array(
            'id' => 'avant-wc-product-title-size',
            'label'   => __( 'WooCommerce Product Title Size', 'avant' ),
            'section' => $section,
            'type'    => 'number',
            'default' => 18,
        );
        $options['avant-wc-product-title-color'] = array(
            'id' => 'avant-wc-product-title-color',
            'label'   => __( 'WooCommerce Product Title Color', 'avant' ),
            'section' => $section,
            'type'    => 'color',
            'default' => $heading_font_color,
        );
    endif;


    $panel = 'avant-panel-colors';

    $panels[] = array(
        'id' => $panel,
        'title' => __( 'Avant Layout Colors', 'avant' ),
        'priority' => '40'
    );
    
    // Colors
    $section = 'colors';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Default Colors', 'avant' ),
        'priority' => '10',
        'panel' => $panel
    );

    $options['avant-boxed-bg-color'] = array(
        'id' => 'avant-boxed-bg-color',
        'label'   => __( 'Site Boxed Background Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => '#FFFFFF',
    );
    
    $options['avant-primary-color'] = array(
        'id' => 'avant-primary-color',
        'label'   => __( 'Primary Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $primary_color,
    );

    $options['avant-secondary-color'] = array(
        'id' => 'avant-secondary-color',
        'label'   => __( 'Secondary Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $secondary_color,
    );

    $section = 'avant-panel-colors-section-header';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Header', 'avant' ),
        'priority' => '10',
        'panel' => $panel
    );
    
    $options['avant-topbar-bg-color'] = array(
        'id' => 'avant-topbar-bg-color',
        'label'   => __( 'Top Bar Background Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_bg_color,
    );
    $options['avant-topbar-font-color'] = array(
        'id' => 'avant-topbar-font-color',
        'label'   => __( 'Top Bar Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );
    $options['avant-header-bg-color'] = array(
        'id' => 'avant-header-bg-color',
        'label'   => __( 'Background Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_bg_color,
    );
    $options['avant-header-font-color'] = array(
        'id' => 'avant-header-font-color',
        'label'   => __( 'Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );
    $options['avant-header-bg-opacity'] = array(
        'id' => 'avant-header-bg-opacity',
        'label'   => __( 'Header Opacity', 'avant' ),
        'section' => $section,
        'type'    => 'range',
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 99,
            'step'  => 1,
        ),
        'default' => 30
    );
    

    $section = 'avant-panel-colors-section-nav';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Navigation', 'avant' ),
        'priority' => '10',
        'panel' => $panel
    );
    
    $options['avant-navi-bg-color'] = array(
        'id' => 'avant-navi-bg-color',
        'label'   => __( 'Background Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_bg_color,
    );
    $options['avant-navi-font-color'] = array(
        'id' => 'avant-navi-font-color',
        'label'   => __( 'Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );
    $options['avant-nav-drop-bg-color'] = array(
        'id' => 'avant-nav-drop-bg-color',
        'label'   => __( 'Drop Down Bg Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_bg_color,
    );
    $options['avant-nav-drop-font-color'] = array(
        'id' => 'avant-nav-drop-font-color',
        'label'   => __( 'Drop Down Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );
    $options['avant-nav-drop-opacity'] = array(
        'id' => 'avant-nav-drop-opacity',
        'label'   => __( 'Drop Down Opacity', 'avant' ),
        'section' => $section,
        'type'    => 'range',
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 99,
            'step'  => 1,
        ),
        'default' => 30
    );
    $options['avant-navi-selected-color'] = array(
        'id' => 'avant-navi-selected-color',
        'label'   => __( 'Selected/Active Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $primary_color,
    );
    
    $section = 'avant-panel-colors-section-pages';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Pages', 'avant' ),
        'priority' => '10',
        'panel' => $panel
    );
    
    $options['avant-content-bg-color'] = array(
        'id' => 'avant-content-bg-color',
        'label'   => __( 'Content Background Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => '#FFFFFF',
    );
    
    $section = 'avant-panel-colors-section-footer';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Footer', 'avant' ),
        'priority' => '10',
        'panel' => $panel
    );

    $options['avant-footer-bg-color'] = array(
        'id' => 'avant-footer-bg-color',
        'label'   => __( 'Background Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_bg_color,
    );
    $options['avant-footer-heading-font-color'] = array(
        'id' => 'avant-footer-heading-font-color',
        'label'   => __( 'Heading Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );
    $options['avant-footer-font-color'] = array(
        'id' => 'avant-footer-font-color',
        'label'   => __( 'Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );

    $options['avant-footer-bottombar-bg-color'] = array(
        'id' => 'avant-footer-bottombar-bg-color',
        'label'   => __( 'Bottom Bar Bg Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_bg_color,
    );
    $options['avant-footer-bottombar-font-color'] = array(
        'id' => 'avant-footer-bottombar-font-color',
        'label'   => __( 'Bottom Bar Font Color', 'avant' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $header_font_color,
    );
    

    $panel = 'avant-panel-text';

    $panels[] = array(
        'id' => $panel,
        'title' => __( 'Avant Theme Text', 'avant' ),
        'priority' => '40'
    );

    $section = 'avant-website-section-text-header';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Header', 'avant' ),
        'priority' => '20',
        'panel' => $panel
    );

    $options['avant-website-head-no-icon'] = array(
        'id' => 'avant-website-head-no-icon',
        'label'   => __( 'Phone Number Icon', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Add your own custom icon by pasting the corrent <a href="http://fontawesome.io/icons/#brand" target="_blank">Font Awesome</a> class here<br />Eg: "fa-phone"<br />Or enter a space to remove the icon', 'avant' ),
        'default' => __( 'fa-phone', 'avant')
    );
    $options['avant-website-head-no'] = array(
        'id' => 'avant-website-head-no',
        'label'   => __( 'Phone Number', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Call Us: +2782 444 YEAH', 'avant' )
    );
    $options['avant-website-site-add-icon'] = array(
        'id' => 'avant-website-site-add-icon',
        'label'   => __( 'Address Icon', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Add your custom icon from <a href="http://fontawesome.io/icons/#brand" target="_blank">Font Awesome</a>', 'avant' ),
        'default' => __( 'fa-map-marker', 'avant')
    );
    $options['avant-website-site-add'] = array(
        'id' => 'avant-website-site-add',
        'label'   => __( 'Address', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Cape Town, South Africa', 'avant' )
    );
    $options['avant-noteon-text-header'] = array(
        'id' => 'avant-noteon-text-header',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Add extra text to Header', 'avant' )
    );

    $section = 'avant-website-section-text-extra';
    
    $sections[] = array(
        'id' => $section,
        'title' => __( '404 Error / No Results', 'avant' ),
        'priority' => '30',
        'panel' => $panel
    );

    $options['avant-website-error-head'] = array(
        'id' => 'avant-website-error-head',
        'label'   => __( '404 Error Page Heading', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Oops! <span>404</span>', 'avant')
    );
    $options['avant-website-error-msg'] = array(
        'id' => 'avant-website-error-msg',
        'label'   => __( 'Error 404 Message', 'avant' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'It looks like that page does not exist. <br />Return home or try a search', 'avant')
    );
    $options['avant-website-nosearch-head'] = array(
        'id' => 'avant-website-nosearch-head',
        'label'   => __( 'No Search Results Heading', 'avant' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Nothing Found', 'avant')
    );
    $options['avant-website-nosearch-msg'] = array(
        'id' => 'avant-website-nosearch-msg',
        'label'   => __( 'No Search Results', 'avant' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'avant')
    );


	// Social Settings
    $section = 'avant-social-section';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Avant Social Links', 'avant' ),
        'priority' => '70'
    );

    $options['avant-social-email'] = array(
        'id' => 'avant-social-email',
        'label'   => __( 'Email Address', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-skype'] = array(
        'id' => 'avant-social-skype',
        'label'   => __( 'Skype Name', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-facebook'] = array(
        'id' => 'avant-social-facebook',
        'label'   => __( 'Facebook', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-twitter'] = array(
        'id' => 'avant-social-twitter',
        'label'   => __( 'Twitter', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-pinterest'] = array(
        'id' => 'avant-social-pinterest',
        'label'   => __( 'Pinterest', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-linkedin'] = array(
        'id' => 'avant-social-linkedin',
        'label'   => __( 'LinkedIn', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-tumblr'] = array(
        'id' => 'avant-social-tumblr',
        'label'   => __( 'Tumblr', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-flickr'] = array(
        'id' => 'avant-social-flickr',
        'label'   => __( 'Flickr', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-vk'] = array(
        'id' => 'avant-social-vk',
        'label'   => __( 'VK', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-social-github'] = array(
        'id' => 'avant-social-github',
        'label'   => __( 'GitHub', 'avant' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['avant-noteon-social-links'] = array(
        'id' => 'avant-noteon-social-links',
        'section' => $section,
        'type'    => 'note',
        'description' => __( '<b>Premium Extra Features:</b><br />- Premium offers a bunch of extra Social Links<br />- Plus 2 custom inputs for your own links', 'avant' )
    );


	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Adds the panels to the $options array
	$options['panels'] = $panels;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'customizer_library_avant_options' );
