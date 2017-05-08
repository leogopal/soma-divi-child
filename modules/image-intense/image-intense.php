<?php
/**
 * Created by PhpStorm.
 * User: leogopal
 * Date: 5/8/17
 * Time: 8:14 PM
 */

//  Prepare for custom modules and hook in an action if appropriate
function Gird_N10S_Custom_Modules() {
	global $pagenow;

	$is_admin    = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	// list of admin pages where we need to load builder files
	$required_admin_pages         = array(
		'edit.php',
		'post.php',
		'post-new.php',
		'admin.php',
		'customize.php',
		'edit-tags.php',
		'admin-ajax.php',
		'export.php'
	);
	$specific_filter_pages        = array( 'edit.php', 'admin.php', 'edit-tags.php' );
	$is_edit_library_page         = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page          = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page               = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import'];
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action( $action_hook, 'N10S_Custom_Modules', 9789 );
	}
}

Gird_N10S_Custom_Modules();

// This function will be hooked as an action given the correct admin rights
function N10S_Custom_Modules() {
	if ( class_exists( "ET_Builder_Module" ) ) {
		include 'class-et-builder-module-image-n10s.php';

		// new ET_Builder_Module_Image_N10S;
		$et_builder_module_image_n10s = new ET_Builder_Module_Image_N10S();
		add_shortcode( 'et_pb_image_n10s', array($et_builder_module_image_n10s, '_shortcode_callback') );
	}
}