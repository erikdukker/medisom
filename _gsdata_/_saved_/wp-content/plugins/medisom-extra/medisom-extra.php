<?php
/*
 * Plugin Name: medisom extra
 * Version: 1.0.0
 * Description: brug naar eigen ontwikkeling
 * Author: Erik Dukker
 * Author URI: http://edisom.nle
 * Plugin URI: 
 * Text Domain: medisom
 * Domain Path: /languages
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
*/
function sys( ) {
	echo 'Hi';
	$post_data = get_post(null, ARRAY_A);
	$slug = $post_data['post_name'];
	include  ABSPATH .'wp-content\plugins\medisom-extra\sm\wp_'.$slug.'.php';	
}
add_shortcode( 'sys', 'sys' );
?>