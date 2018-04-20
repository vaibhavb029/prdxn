<?php 
//This plugin creates an entry in the options database. When the plugin will be deleted, this code will automatically delete the database entry from the options Wordpress table.
delete_option('testimonial_db_version');
if( !defined( 'RICH_TESTIMONIALS_PLUGIN_BASENAME' ) ) {
	delete_option('testimonial_slider_options'); 
	//This plugin creates its own database tables to save the post ids for the posts and pages added to Testimonial Slider. When the plugin will be deleted, the database tables will also get deleted.
	global $wpdb, $table_prefix;
	$slider_table = $table_prefix.'testimonial_slider';
	$slider_meta = $table_prefix.'testimonial_slider_meta';
	$slider_postmeta = $table_prefix.'testimonial_slider_postmeta';
	$sql = "DROP TABLE $slider_table;";
	$wpdb->query($sql);
	$sql = "DROP TABLE $slider_meta;";
	$wpdb->query($sql);
	$sql = "DROP TABLE $slider_postmeta;";
	$wpdb->query($sql);
}
?>
