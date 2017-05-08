<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	$parent_style = 'divi-style'; // This is the 'parent-style'.
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( 'divi-child-style', get_stylesheet_uri(), array( $parent_style ) );

	wp_enqueue_script( 'divi', plugin_dir_url( __FILE__ ) . 'assets/js/scripts.js', array(
		'jquery',
		'divi-custom-script'
	), '0.0.1', true );
}
