<?php
/**
 * Avant functions and definitions
 *
 * @package Avant
 */
define( 'AVANT_THEME_VERSION' , '1.1.04' );

// Include Avant Upgrade page
require get_template_directory() . '/upgrade/upgrade.php';

// Load WP included scripts
require get_template_directory() . '/includes/inc/template-tags.php';
require get_template_directory() . '/includes/inc/extras.php';
require get_template_directory() . '/includes/inc/jetpack.php';

// Load Customizer Library scripts
require get_template_directory() . '/customizer/customizer-options.php';
require get_template_directory() . '/customizer/customizer-library/customizer-library.php';
require get_template_directory() . '/customizer/styles.php';
require get_template_directory() . '/customizer/mods.php';

// Load TGM plugin class
require_once get_template_directory() . '/includes/inc/class-tgm-plugin-activation.php';
 // Add customizer Upgrade class
require_once( get_template_directory() . '/includes/avant-pro/class-customize.php' );

if ( ! function_exists( 'avant_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function avant_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 900; /* pixels */
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on avant, use a find and replace
	 * to change 'avant' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'avant', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
        'top-bar-menu' => esc_html__( 'Top Bar Menu', 'avant' ),
		'primary' => esc_html__( 'Primary Menu', 'avant' ),
        'footer-bar' => esc_html__( 'Footer Bar Menu', 'avant' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// The custom logo
	add_theme_support( 'custom-logo', array(
		'width'       => 280,
		'height'      => 145,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'avant_custom_background_args', array(
		'default-color' => 'F9F9F9',
	) ) );
	
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
endif; // avant_setup
add_action( 'after_setup_theme', 'avant_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function avant_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'avant' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar(array(
		'name' => __( 'Avant Footer Standard', 'avant' ),
		'id' => 'avant-site-footer-standard',
        'description' => __( 'The footer will divide into however many widgets are placed here.', 'avant' )
	));
}
add_action( 'widgets_init', 'avant_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function avant_scripts() {
	wp_enqueue_style( 'avant-title-font', '//fonts.googleapis.com/css?family=Parisienne', array(), AVANT_THEME_VERSION );
	wp_enqueue_style( 'avant-body-font-default', '//fonts.googleapis.com/css?family=Open+Sans', array(), AVANT_THEME_VERSION );
	wp_enqueue_style( 'avant-heading-font-default', 'https://fonts.googleapis.com/css?family=Poppins', array(), AVANT_THEME_VERSION );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/includes/font-awesome/css/font-awesome.css', array(), '4.7.0' );
	wp_enqueue_style( 'avant-style', get_stylesheet_uri(), array(), AVANT_THEME_VERSION );

	if ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-seven' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-seven.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-six.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-five' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-five.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-four' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-four.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-three' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-three.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-two' ) :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-two.css", array(), AVANT_THEME_VERSION );
	else :
		wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-one.css", array(), AVANT_THEME_VERSION );
	endif;
	
	if ( avant_is_woocommerce_activated() ) :
		wp_enqueue_style( 'avant-woocommerce-style', get_template_directory_uri()."/includes/css/woocommerce.css", array(), AVANT_THEME_VERSION );
	endif;

	if ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-custom' ) :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-custom.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-social' ) :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-social.css", array(), AVANT_THEME_VERSION );
	elseif ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-none' ) :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-none.css", array(), AVANT_THEME_VERSION );
	else :
		wp_enqueue_style( 'avant-footer-style', get_template_directory_uri()."/templates/footer/css/footer-standard.css", array(), AVANT_THEME_VERSION );
	endif;
	
	wp_enqueue_script( 'avant-custom-js', get_template_directory_uri() . "/js/custom.js", array('jquery'), AVANT_THEME_VERSION, true );
	
	wp_enqueue_script( 'caroufredsel-js', get_template_directory_uri() . "/js/caroufredsel/jquery.carouFredSel-6.2.1-packed.js", array('jquery'), AVANT_THEME_VERSION, true );
    wp_enqueue_script( 'avant-home-slider', get_template_directory_uri() . '/js/home-slider.js', array('jquery'), AVANT_THEME_VERSION, true );
	
	if ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) :
		wp_enqueue_script( 'jquery-masonry' );
        wp_enqueue_script( 'avant-masonry-custom', get_template_directory_uri() . '/js/layout-blocks.js', array('jquery'), AVANT_THEME_VERSION, true );
	endif;

	wp_enqueue_script( 'avant-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), AVANT_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'avant_scripts' );

/**
 * To maintain backwards compatibility with older versions of WordPress
 */
function avant_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/**
 * Add theme stying to the theme content editor
 */
function avant_add_editor_styles() {
    add_editor_style( 'style-theme-editor.css' );
}
add_action( 'admin_init', 'avant_add_editor_styles' );

/**
 * Enqueue admin styling.
 */
function avant_load_admin_script() {
    wp_enqueue_style( 'avant-admin-css', get_template_directory_uri() . '/upgrade/css/admin-css.css', array(), AVANT_THEME_VERSION );
}
add_action( 'admin_enqueue_scripts', 'avant_load_admin_script' );

/**
 * Enqueue avant custom customizer styling.
 */
function avant_load_customizer_script() {
	wp_enqueue_script( 'avant-customizer-js', get_template_directory_uri() . "/customizer/customizer-library/js/customizer-custom.js", array('jquery'), AVANT_THEME_VERSION, true );
    wp_enqueue_style( 'avant-customizer-css', get_template_directory_uri() . "/customizer/customizer-library/css/customizer.css", array(), AVANT_THEME_VERSION );
}
add_action( 'customize_controls_enqueue_scripts', 'avant_load_customizer_script' );

/**
 * Check if WooCommerce exists.
 */
if ( ! function_exists( 'avant_is_woocommerce_activated' ) ) :
	function avant_is_woocommerce_activated() {
	    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
endif; // avant_is_woocommerce_activated

// If WooCommerce exists include ajax cart
if ( avant_is_woocommerce_activated() ) {
	require get_template_directory() . '/includes/inc/woocommerce-header-inc.php';
}

/**
 * Add classed to the body tag from settings
 */
function avant_add_body_class( $classes ) {
	if ( get_theme_mod( 'avant-page-remove-titlebar' ) ) {
		$classes[] = 'avant-shop-remove-titlebar';
	}
	if ( get_theme_mod( 'avant-remove-wc-page-titles' ) ) {
		$classes[] = 'avant-onlyshop-remove-titlebar';
	}
	
	if ( get_theme_mod( 'avant-remove-blog-title' ) ) {
		$classes[] = 'avant-blog-remove-titlebar';
	}

	return $classes;
}
add_filter( 'body_class', 'avant_add_body_class' );

/**
 * Add classes to the blog list for styling.
 */
function avant_add_blog_post_classes ( $classes ) {
	global $current_class;

	if ( is_home() || is_archive() || is_search() ) :
		$avant_blog_layout = sanitize_html_class( 'blog-left-layout' );
		if ( get_theme_mod( 'avant-blog-layout' ) ) :
		    $avant_blog_layout = sanitize_html_class( get_theme_mod( 'avant-blog-layout' ) );
		endif;
		$classes[] = $avant_blog_layout;

		$avant_blog_style = sanitize_html_class( 'blog-style-postblock' );
		if ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) :
			if ( get_theme_mod( 'avant-blog-blocks-style' ) ) :
			    $avant_blog_style = sanitize_html_class( get_theme_mod( 'avant-blog-blocks-style' ) );
			endif;
		endif;
		$classes[] = $avant_blog_style;

		$avant_blog_img = sanitize_html_class( 'blog-post-noimg' );
		if ( has_post_thumbnail() ) :
		    $avant_blog_img = sanitize_html_class( 'blog-post-hasimg' );
		endif;
		$classes[] = $avant_blog_img;

		$classes[] = $current_class;
		$current_class = ( $current_class == 'blog-alt-odd' ) ? sanitize_html_class( 'blog-alt-even' ) : sanitize_html_class( 'blog-alt-odd' );
	endif;

	return $classes;
}
global $current_class;
$current_class = 'blog-alt-odd';
add_filter ( 'post_class' , 'avant_add_blog_post_classes' );

/**
 * Adjust is_home query if avant-blog-cats is set
 */
function avant_set_blog_queries( $query ) {
    $blog_query_set = '';
    if ( get_theme_mod( 'avant-blog-cats' ) ) {
        $blog_query_set = get_theme_mod( 'avant-blog-cats' );
    }

    if ( $blog_query_set ) {
        // do not alter the query on wp-admin pages and only alter it if it's the main query
        if ( !is_admin() && $query->is_main_query() ){
            if ( is_home() ){
                $query->set( 'cat', $blog_query_set );
            }
        }
    }
}
add_action( 'pre_get_posts', 'avant_set_blog_queries' );

/**
 * Display recommended plugins with the TGM class
 */
function avant_register_required_plugins() {
	$plugins = array(
		// The recommended WordPress.org plugins.
		array(
			'name'      => __( 'WooCommerce', 'avant' ),
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => __( 'Elementor Page Builder', 'avant' ),
			'slug'      => 'elementor',
			'required'  => false,
		),
		array(
			'name'      => __( 'Breadcrumb NavXT', 'avant' ),
			'slug'      => 'breadcrumb-navxt',
			'required'  => false,
		),
		array(
			'name'      => __( 'Meta Slider', 'avant' ),
			'slug'      => 'ml-slider',
			'required'  => false,
		)
	);
	$config = array(
		'id'           => 'avant',
		'menu'         => 'tgmpa-install-plugins',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'avant_register_required_plugins' );

/**
 * Elementor Check
 */
if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
	define( 'ELEMENTOR_PARTNER_ID', 2118 );
}

/**
 * Add classes to the admin body class
 */
function avant_add_admin_body_class() {
	$avant_admin_class = '';

	if ( get_theme_mod( 'avant-footer-layout' ) ) {
		$avant_admin_class = sanitize_html_class( get_theme_mod( 'avant-footer-layout' ) );
	} else {
		$avant_admin_class = sanitize_html_class( 'avant-footer-layout-standard' );
	}
	return $avant_admin_class;
}
add_filter( 'admin_body_class', 'avant_add_admin_body_class' );

/**
 * Function to remove Category pre-title text
 */
function avant_cat_title_remove_pretext( $avant_cat_title ) {
	if ( is_category() ) {
        $avant_cat_title = the_archive_title( '', false );
    } elseif ( is_post_type_archive() ) {
		$avant_cat_title = post_type_archive_title( '', false );
    } elseif ( is_tag() ) {
        $avant_cat_title = the_archive_title( '', false );
    } elseif ( is_author() ) {
        $avant_cat_title = '<span class="vcard">' . get_the_author() . '</span>' ;
    }
    return $avant_cat_title;
}
if ( get_theme_mod( 'avant-remove-cat-pre-title' ) ) :
	add_filter( 'get_the_archive_title', 'avant_cat_title_remove_pretext' );
endif;

/**
 * Register a custom Post Categories ID column
 */
function avant_edit_cat_columns( $avant_cat_columns ) {
    $avant_cat_in = array( 'cat_id' => 'Category ID <span class="cat_id_note">For the Default Slider</span>' );
    $avant_cat_columns = avant_cat_columns_array_push_after( $avant_cat_columns, $avant_cat_in, 0 );
    return $avant_cat_columns;
}
add_filter( 'manage_edit-category_columns', 'avant_edit_cat_columns' );

/**
 * Print the ID column
 */
function avant_cat_custom_columns( $value, $name, $cat_id ) {
    if( 'cat_id' == $name )
        echo $cat_id;
}
add_filter( 'manage_category_custom_column', 'avant_cat_custom_columns', 10, 3 );

/**
 * Insert an element at the beggining of the array
 */
function avant_cat_columns_array_push_after( $src, $avant_cat_in, $pos ) {
    if ( is_int( $pos ) ) {
        $R = array_merge( array_slice( $src, 0, $pos + 1 ), $avant_cat_in, array_slice( $src, $pos + 1 ) );
    } else {
        foreach ( $src as $k => $v ) {
            $R[$k] = $v;
            if ( $k == $pos )
                $R = array_merge( $R, $avant_cat_in );
        }
    }
    return $R;
}