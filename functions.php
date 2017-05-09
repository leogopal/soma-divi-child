<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'sera_enqueue_styles' );
function sera_enqueue_styles() {
	$parent_style = 'divi-style'; // This is the 'parent-style'.
	$parent_stylesheet = get_template_directory_uri() . '/style.css';
	$child_script = get_stylesheet_directory_uri() . '/assets/js/scripts.js';

	wp_enqueue_style(
		$parent_style,
		$parent_stylesheet,
		filemtime($parent_stylesheet)
	);

	wp_enqueue_style(
		'divi-child-style',
		get_stylesheet_uri(),
		array( $parent_style ),
		filemtime(get_stylesheet_uri())
	);

	wp_enqueue_script(
		'divi-child-js',
		$child_script,
		array( 'jquery' ),
		filemtime( $child_script ),
		true
	);
}

// Include the Divi modules used in this project as drop-ins.
include get_stylesheet_directory() . '/modules/init.php';

function my_et_builder_post_types( $post_types ) {
	$post_types[] = 'product';
	return $post_types;
}
add_filter( 'et_builder_post_types', 'my_et_builder_post_types' );

