<?php
/*
Plugin Name: WonderPlugin Slider Lite
Plugin URI: https://www.wonderplugin.com/wordpress-slider/
Description: WordPress Image and Video Slider Plugin
Version: 10.1
Author: Magic Hills Pty Ltd
Author URI: https://www.wonderplugin.com/
License: Copyright 2018 Magic Hills Pty Ltd, All Rights Reserved
*/

if (defined('WONDERPLUGIN_SLIDER_VERSION'))
	return;

define('WONDERPLUGIN_SLIDER_VERSION', '10.1');
define('WONDERPLUGIN_SLIDER_URL', plugin_dir_url( __FILE__ ));
define('WONDERPLUGIN_SLIDER_PATH', plugin_dir_path( __FILE__ ));
define('WONDERPLUGIN_SLIDER_PLUGIN', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
define('WONDERPLUGIN_SLIDER_PLUGIN_VERSION', '10.1');

require_once 'app/class-wonderplugin-slider-controller.php';

class WonderPlugin_Slider_Plugin {
	
	function __construct() {
	
		$this->init();
	}
	
	public function init() {
		
		// init controller
		$this->wonderplugin_slider_controller = new WonderPlugin_Slider_Controller();
		
		add_action( 'admin_menu', array($this, 'register_menu') );
		
		add_shortcode( 'wonderplugin_slider', array($this, 'shortcode_handler') );
		
		add_action( 'init', array($this, 'register_script') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script') );
		
		if ( is_admin() )
		{
			add_action( 'wp_ajax_wonderplugin_slider_save_config', array($this, 'wp_ajax_save_item') );
			add_action( 'admin_init', array($this, 'admin_init_hook') );
			add_action( 'admin_post_wonderplugin_slider_export', array($this, 'export_sliders') );
		}
		
		$supportwidget = get_option( 'wonderplugin_slider_supportwidget', 1 );
		if ( $supportwidget == 1 )
		{
			add_filter('widget_text', 'do_shortcode');
		}
	}
	
	function register_menu()
	{
		$settings = $this->get_settings();
		$userrole = $settings['userrole'];
		
		$menu = add_menu_page(
				__('WonderPlugin Slider', 'wonderplugin_slider'),
				__('WonderPlugin Slider', 'wonderplugin_slider'),
				$userrole,
				'wonderplugin_slider_overview',
				array($this, 'show_overview'),
				WONDERPLUGIN_SLIDER_URL . 'images/logo-16.png' );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_slider_overview',
				__('Overview', 'wonderplugin_slider'),
				__('Overview', 'wonderplugin_slider'),
				$userrole,
				'wonderplugin_slider_overview',
				array($this, 'show_overview' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_slider_overview',
				__('New Slider', 'wonderplugin_slider'),
				__('New Slider', 'wonderplugin_slider'),
				$userrole,
				'wonderplugin_slider_add_new',
				array($this, 'add_new' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_slider_overview',
				__('Manage Sliders', 'wonderplugin_slider'),
				__('Manage Sliders', 'wonderplugin_slider'),
				$userrole,
				'wonderplugin_slider_show_items',
				array($this, 'show_items' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_slider_overview',
				__('Import/Export', 'wonderplugin_slider'),
				__('Import/Export', 'wonderplugin_slider'),
				'manage_options',
				'wonderplugin_slider_import_export',
				array($this, 'import_export' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'wonderplugin_slider_overview',
				__('Settings', 'wonderplugin_slider'),
				__('Settings', 'wonderplugin_slider'),
				'manage_options',
				'wonderplugin_slider_edit_settings',
				array($this, 'edit_settings' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		
		$menu = add_submenu_page(
				null,
				__('View Slider', 'wonderplugin_slider'),
				__('View Slider', 'wonderplugin_slider'),	
				$userrole,	
				'wonderplugin_slider_show_item',	
				array($this, 'show_item' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				null,
				__('Edit Slider', 'wonderplugin_slider'),
				__('Edit Slider', 'wonderplugin_slider'),
				$userrole,
				'wonderplugin_slider_edit_item',
				array($this, 'edit_item' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
	}
	
	function register_script()
	{
		wp_register_script('wonderplugin-slider-skins-script', WONDERPLUGIN_SLIDER_URL . 'engine/wonderpluginsliderskins.js', array('jquery'), WONDERPLUGIN_SLIDER_VERSION, false);
		wp_register_script('wonderplugin-slider-script', WONDERPLUGIN_SLIDER_URL . 'engine/wonderpluginslider.js', array('jquery'), WONDERPLUGIN_SLIDER_VERSION, false);
		wp_register_script('wonderplugin-slider-creator-script', WONDERPLUGIN_SLIDER_URL . 'app/wonderplugin-slider-creator.js', array('jquery'), WONDERPLUGIN_SLIDER_VERSION, false);
		wp_register_style('wonderplugin-slider-css', WONDERPLUGIN_SLIDER_URL . 'engine/wonderpluginsliderengine.css');
		wp_register_style('wonderplugin-slider-admin-style', WONDERPLUGIN_SLIDER_URL . 'wonderpluginslider.css');
	}
	
	function enqueue_script()
	{
		wp_enqueue_style('wonderplugin-slider-css');
		
		$addjstofooter = get_option( 'wonderplugin_slider_addjstofooter', 0 );
		if ($addjstofooter == 1)
		{
			wp_enqueue_script('wonderplugin-slider-skins-script', false, array(), false, true);
			wp_enqueue_script('wonderplugin-slider-script', false, array(), false, true);
		}
		else
		{
			wp_enqueue_script('wonderplugin-slider-skins-script');
			wp_enqueue_script('wonderplugin-slider-script');
		}
	}
	
	function enqueue_admin_script($hook)
	{
		wp_enqueue_script('post');
		if (function_exists("wp_enqueue_media"))
		{
			wp_enqueue_media();
		}
		else
		{
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
		}
		wp_enqueue_script('wonderplugin-slider-skins-script');
		wp_enqueue_script('wonderplugin-slider-script');
		wp_enqueue_script('wonderplugin-slider-creator-script');
		wp_enqueue_style('wonderplugin-slider-css');
		wp_enqueue_style('wonderplugin-slider-admin-style');
	}

	function admin_init_hook()
	{
		$settings = $this->get_settings();
		$userrole = $settings['userrole'];
		if ( !current_user_can($userrole) )
			return;
		
		// change text of history media uploader
		if (!function_exists("wp_enqueue_media"))
		{
			global $pagenow;
			
			if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
				add_filter( 'gettext', array($this, 'replace_thickbox_text' ), 1, 3 );
			}
		}
		
		// add meta boxes
		$this->wonderplugin_slider_controller->add_metaboxes();
	}
	
	function replace_thickbox_text($translated_text, $text, $domain) {
		
		if ('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'wonderplugin-slider' );
			if ( $referer != '' ) {
				return __('Insert into slider', 'wonderplugin_slider' );
			}
		}
		return $translated_text;
	}
	
	function show_overview() {
		
		$this->wonderplugin_slider_controller->show_overview();
	}
	
	function show_items() {
		
		$this->wonderplugin_slider_controller->show_items();
	}
	
	function add_new() {
		
		$this->wonderplugin_slider_controller->add_new();
	}
	
	function show_item() {
		
		$this->wonderplugin_slider_controller->show_item();
	}
	
	function edit_item() {
	
		$this->wonderplugin_slider_controller->edit_item();
	}
	
	function edit_settings() {
	
		$this->wonderplugin_slider_controller->edit_settings();
	}
	
	function import_export() {
		
		$this->wonderplugin_slider_controller->import_export();
	}
	
	function register() {
	
		$this->wonderplugin_slider_controller->register();
	}
	
	function get_settings() {
	
		return $this->wonderplugin_slider_controller->get_settings();
	}
	
	function shortcode_handler($atts) {
		
		if ( !isset($atts['id']) )
			return __('Please specify a slider id', 'wonderplugin_slider');
		
		$id = ( isset($atts['mobileid']) && $this->is_mobile() ) ? $atts['mobileid'] : $atts['id'];
		
		return $this->wonderplugin_slider_controller->generate_body_code( $id, false);
	}
	
	function is_mobile() {
		
		if (!isset($_SERVER['HTTP_USER_AGENT']))
			return false;
		
		return (strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
				|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false);
	}
	
	function wp_ajax_save_item() {
		
		check_ajax_referer( 'wonderplugin-slider-ajaxnonce', 'nonce' );
		
		$settings = $this->get_settings();
		$userrole = $settings['userrole'];
		if ( !current_user_can($userrole) )
			return;
		
		$jsonstripcslash = get_option( 'wonderplugin_slider_jsonstripcslash', 1 );
		if ($jsonstripcslash == 1)
			$json_post = trim(stripcslashes($_POST["item"]));
		else
			$json_post = trim($_POST["item"]);
		
		$items = json_decode($json_post, true);
				
		if ( empty($items) )
		{
			$json_error = "json_decode error";
			if ( function_exists('json_last_error_msg') )
				$json_error .= ' - ' . json_last_error_msg();
			else if ( function_exists('json_last_error') )
				$json_error .= 'code - ' . json_last_error();
				
			header('Content-Type: application/json');
			echo json_encode(array(
					"success" => false,
					"id" => -1,
					"message" => $json_error
			));
			wp_die();
		}
		
		add_filter('safe_style_css', 'wonderplugin_slider_css_allow');
		add_filter('wp_kses_allowed_html', 'wonderplugin_slider_tags_allow', 'post');
		
		foreach ($items as $key => &$value)
		{
			if ($key == 'customjs' && current_user_can('manage_options'))
				continue;
			
			if ($value === true)
				$value = "true";
			else if ($value === false)
				$value = "false";
			else if ( is_string($value) )
				$value = wp_kses_post($value);
		}
		
		if (isset($items["slides"]) && count($items["slides"]) > 0)
		{
			foreach ($items["slides"] as $key => &$slide)
			{
				foreach ($slide as $key => &$value)
				{
					if ($value === true)
						$value = "true";
					else if ($value === false)
						$value = "false";
					else if ( is_string($value) )
						$value = wp_kses_post($value);
				}
			}
		}
		
		remove_filter('wp_kses_allowed_html', 'wonderplugin_slider_tags_allow', 'post');
		remove_filter('safe_style_css', 'wonderplugin_slider_css_allow');
		
		header('Content-Type: application/json');
		echo json_encode($this->wonderplugin_slider_controller->save_item($items));
		wp_die();
	}
	
	function export_sliders() {
		
		check_admin_referer('wonderplugin-slider', 'wonderplugin-slider-export');
		
		if ( !current_user_can('manage_options') )
			return;
	
		$this->wonderplugin_slider_controller->export_sliders();
	}
}

/**
 * Init the plugin
 */
$wonderplugin_slider_plugin = new WonderPlugin_Slider_Plugin();

/**
 * Uninstallation
 */
function wonderplugin_slider_lite_uninstall() {

	if ( ! current_user_can( 'activate_plugins' ) )
		return;
	
	global $wpdb;
	
	$keepdata = get_option( 'wonderplugin_slider_keepdata', 1 );
	if ( $keepdata == 0 )
	{
		$table_name = $wpdb->prefix . "wonderplugin_slider";
		$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}
	
}

if ( function_exists('register_uninstall_hook') )
{
	register_uninstall_hook( __FILE__, 'wonderplugin_slider_lite_uninstall' );
}

define('WONDERPLUGIN_SLIDER_VERSION_TYPE', 'L');
