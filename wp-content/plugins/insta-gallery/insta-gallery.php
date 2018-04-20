<?php
/*
 * Plugin Name: Instagram Gallery
 * Description: Display Gallery on the website from Instagram.
 * Author: Karan Singh
 * Author URI: https://www.karansingh.ml/
 * Requires at least: 3.8
 * Requires PHP: 5.3
 * Tested up to: 4.9
 * Text Domain: insta-gallery
 * Domain Path: /languages/
 * Version: 1.5.9
 */
if (! defined('ABSPATH')) {
    exit(); // Exit if accessed directly.
}

// plugin global constants
define('INSGALLERY_VER', '1.5.9');
define('INSGALLERY_PRODUCTION', true); // ******  ******  ***** ******   ***** ******  ENV, CSS/JS min ******  *****

define('INSGALLERY_PATH', plugin_dir_path(__FILE__));
define('INSGALLERY_URL', plugins_url('', __FILE__));
define('INSGALLERY_PLUGIN_DIR', plugin_basename(dirname(__FILE__)));

class INSGALLERY
{

    public function __construct()
    {
        register_activation_hook(__FILE__, array(
            $this,
            'activate'
        ));
        register_deactivation_hook(__FILE__, array(
            $this,
            'deactivate'
        ));
        
        if (is_admin()) {
            add_action('admin_menu', array(
                $this,
                'loadMenus'
            ));
            // add setting link
            add_filter('plugin_action_links', array(
                $this,
                'insgal_add_action_plugin'
            ), 10, 5);
        }
        
        add_action('admin_enqueue_scripts', array(
            $this,
            'load_admin_scripts'
        ));
        
        include_once (INSGALLERY_PATH . 'app/wp-front.php');
        include_once (INSGALLERY_PATH . 'app/wp-widget.php');
        
        // save ig adv. setting
        add_action('wp_ajax_save_igadvs', array(
            $this,
            'save_igadvs'
        ));
        
        // load Translations
        add_action('plugins_loaded', array(
            $this,
            'load_translations_instagal'
        ));
    }

    public function activate()
    {}

    public function deactivate()
    {}

    public function save_igadvs()
    {
        if (! isset($_POST['igadvs_nonce']) || ! wp_verify_nonce($_POST['igadvs_nonce'], 'igadvs_nonce_key')) {
            wp_send_json_error('Invalid Request.');
        }
        $igs_spinner_image_id = '';
        $igs_flush = (isset($_POST['igs_flush']) && $_POST['igs_flush']) ? true : false;
        if (! empty($_POST['igs_spinner_image_id'])) {
            $igs_spinner_image_id = (int) $_POST['igs_spinner_image_id'];
        }
        $insta_gallery_setting = array(
            'igs_flush' => $igs_flush,
            'igs_spinner_image_id' => $igs_spinner_image_id
        );
        update_option('insta_gallery_setting', $insta_gallery_setting, false);
        
        wp_send_json_success(__('settings updated successfully', 'insta-gallery'));
    }

    function load_translations_instagal()
    {
        load_plugin_textdomain('insta-gallery', false, INSGALLERY_PLUGIN_DIR . '/languages/');
    }

    function load_admin_scripts($hook)
    {
        // Load only on plugin page
        if ($hook != 'settings_page_insta_gallery') {
            return;
        }
        wp_enqueue_style('insta-gallery-admin', INSGALLERY_URL . '/assets/admin-style.css', array(), INSGALLERY_VER);
        
        // Enqueue WordPress media scripts
        wp_enqueue_media();
    }

    function loadMenus()
    {
        add_options_page(__('Instagram Gallery', 'insta-gallery'), __('Instagram Gallery', 'insta-gallery'), 'manage_options', 'insta_gallery', array(
            $this,
            'loadPanel'
        ));
        // add_menu_page();
    }

    function loadPanel()
    {
        require_once (INSGALLERY_PATH . 'app/wp-panel.php');
    }

    function insgal_add_action_plugin($actions, $plugin_file)
    {
        static $plugin;
        
        if (! isset($plugin))
            $plugin = plugin_basename(__FILE__);
        if ($plugin == $plugin_file) {
            
            $settings = array(
                'settings' => '<a href="options-general.php?page=insta_gallery">' . __('Settings', 'insta-gallery') . '</a>'
            );
            
            $actions = array_merge($settings, $actions);
        }
        
        return $actions;
    }
}
new INSGALLERY();
