<?php
// If accessed directly, exit.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues (always have to check that spelling)
 * all the relevant theme styles and scripts
 * and versions them based on the last modified time
 * we do this for cache-busting purposes.
 */
function sera_frontend_enqueues() {
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
add_action( 'wp_enqueue_scripts', 'sera_frontend_enqueues' );

/**
 * Includes the file for custom modules
 * to behave as theme drop-ins not plugins
 */
include get_stylesheet_directory() . '/modules/init.php';

/**
 * Enables the divi builder on specific CPTs
 * in this case it will be 'product'
 * by adding it to the $post_types array filter.
 *
 * @param $post_types
 *
 * @return array
 */
function sera_et_builder_post_types( $post_types ) {
	$post_types[] = 'product';
	return $post_types;
}
add_filter( 'et_builder_post_types', 'sera_et_builder_post_types' );

add_shortcode( 'woo_product_family' , 'sera_product_family' );
function sera_product_family() {
	global $post;
	$product_category_id = '';
	$products_output = '';
	$terms = get_the_terms( $post->ID, 'product_cat' );
	foreach ( $terms as $term ) {
		$product_category_id = $term->id;
		break;
	}
	$args = array(
		'posts_per_page' => 100,
		'category'       => $product_category_id,
		'post_type'      => 'product',
		'orderby'        => 'title'
	);
	$products = get_posts( $args );
	ob_start();
	?>
	<section class="products-selector-menu">
		<ul class="menu-secend clearfix">
			<?php foreach ( $products as $product ) { ?>
				<li class="<?php echo $product->post_name; ?>">
					<a href="<?php echo get_permalink( $product ) ?>">
						<?php echo get_the_post_thumbnail($product, array(40, 131)); ?><?php echo $product->post_title; ?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</section>
	<?php
	$products_output = ob_get_clean();
	return $products_output;
}

