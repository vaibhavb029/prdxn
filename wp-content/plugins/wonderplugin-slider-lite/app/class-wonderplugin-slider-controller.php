<?php 

require_once 'class-wonderplugin-slider-model.php';
require_once 'class-wonderplugin-slider-view.php';

class WonderPlugin_Slider_Controller {

	private $view, $model, $update;

	function __construct() {

		$this->model = new WonderPlugin_Slider_Model($this);	
		$this->view = new WonderPlugin_Slider_View($this);
				
		$this->init();
	}
	
	function add_metaboxes()
	{
		$this->view->add_metaboxes();
	}
	
	function show_overview() {
		
		$this->view->print_overview();
	}
	
	function show_items() {
	
		$this->view->print_items();
	}
	
	function add_new() {
		
		$this->view->print_add_new();
	}
	
	function show_item()
	{
		$this->view->print_item();
	}
	
	function edit_item()
	{
		$this->view->print_edit_item();
	}
	
	function edit_settings()
	{
		$this->view->print_edit_settings();
	}
	
	function save_settings($options)
	{
		$this->model->save_settings($options);
	}
	
	function get_settings()
	{
		return $this->model->get_settings();
	}
	
	function import_export()
	{
		$this->view->import_export();
	}
	
	function import_sliders($post, $files)
	{
		return $this->model->import_sliders($post, $files);
	}
	
	function search_replace_sliders($post)
	{
		return $this->model->search_replace_sliders($post);
	}
	
	function register()
	{
		$this->view->print_register();
	}
	
	function check_license($options)
	{
		return $this->model->check_license($options);
	}
	
	function deregister_license($options)
	{
		return $this->model->deregister_license($options);
	}
	
	function save_plugin_info($info)
	{
		return $this->model->save_plugin_info($info);
	}
	
	function get_plugin_info()
	{
		return $this->model->get_plugin_info();
	}
	
	function get_update_data($action, $key)
	{
		return $this->update->get_update_data($action, $key);
	}
	
	function generate_body_code($id, $has_wrapper) {
		
		return $this->model->generate_body_code($id, $has_wrapper);
	}
	
	function delete_item($id)
	{
		return $this->model->delete_item($id);
	}
	
	function trash_item($id)
	{
		return $this->model->trash_item($id);
	}
	
	function restore_item($id)
	{
		return $this->model->restore_item($id);
	}
	
	function clone_item($id)
	{
		return $this->model->clone_item($id);
	}
	
	function save_item($item)
	{
		return $this->model->save_item($item);	
	}
	
	function get_list_data($published_only = false) {
	
		return $this->model->get_list_data($published_only);
	}
	
	function init() {
	
		$engine = array("WordPress Slider", "WordPress Slideshow", "WordPress Image Slider", "WordPress Image Slideshow", "WordPress Slider Plugin", "WordPress Slideshow Plugin", "WordPress Image Slider Plugin", "WordPress Image Slideshow Plugin", "Responsive WordPress Slider", "Responsive WordPress Slideshow", "Responsive WordPress Image Slider", "Responsive WordPress Image Slideshow", "Responsive WordPress Slider Plugin", "Responsive WordPress Slideshow Plugin", "Responsive WordPress Image Slider Plugin", "Responsive WordPress Image Slideshow Plugin");
		$option_name = 'wonderplugin-slider-engine';
		if ( get_option( $option_name ) == false )
			update_option( $option_name, $engine[array_rand($engine)] );
	}
	
	function get_item_data($id) {
		
		return $this->model->get_item_data($id);
	}
	
	function export_sliders() {
		
		return $this->model->export_sliders();
	}
}
