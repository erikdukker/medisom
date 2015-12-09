<?
/*
Plugin Name: Medisom Functies
Plugin URI: http://medisom.nl
Description: extra functions
Author: Erik Dukker
Version: 0.0.1
Requires at least: 4.0
Author URI: http://medisom.nl
License: GPL v3
Text Domain: medisom-Functies
Domain Path: /languages
Copyright (C) 2015, Erik Dukker
*/
// de Shortcode
function sys( $atts ) {
	$post_data = get_post(null, ARRAY_A);
	$slug = $post_data['post_name'];
	include  ABSPATH .'wp-content/plugins/medisom-extra/sm/wp_'.$slug.'.php';	
}
add_shortcode( 'sys', 'sys' );
?>