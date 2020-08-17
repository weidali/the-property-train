<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
	'/woocommerce.php',                     // Load WooCommerce functions.
	'/editor.php',                          // Load Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);

foreach ( $understrap_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

add_theme_support( 'custom-logo' );
// Изменени длины выводимого текста функцией excerpt()
add_filter( 'excerpt_length', function(){
	return 9;
} );
// Создание дополнительных превью
add_image_size( 'oblect-preview', 500, 500, array( 'center', 'top' ) );
add_image_size( 'main-preview', 200, 200, array( 'center', 'top' ) );

// Start: Добавление колонки in admin panel ( 'nedvizhimost', 'object_cost' )
add_filter( 'manage_edit-nedvizhimost_columns', 'true_add_nedvizhimost_columns_2', 10, 1 ); // manage_edit-{тип поста}_columns
add_action( 'manage_posts_custom_column', 'true_fill_nedvizhimost_columns_2', 10, 1 );

/* добавление колонки Просмотры */
function true_add_nedvizhimost_columns_2( $my_columns ){
	$my_columns['prosmort'] = 'Просмотры';
	return $my_columns;
}
 
/* заполнение колонки Просмотры */
function true_fill_nedvizhimost_columns_2( $column ) {
	global $post;
	switch ( $column ) {
		case 'prosmort':
			echo ( $x = get_post_meta($post->ID, 'prosmort', true) ) ? $x : 0; // это простое условие, если произвольного поля не существует, то выводим 0
			break;
	}
}

// ID posts columns
function true_id($args){
	$args['post_page_id'] = 'ID';
	return $args;
}
function true_custom($column, $id){
	if($column === 'post_page_id'){
		echo $id;
	}
}
 
add_filter('manage_pages_columns', 'true_id', 5);
add_action('manage_pages_custom_column', 'true_custom', 5, 2);
add_filter('manage_posts_columns', 'true_id', 5);
add_action('manage_posts_custom_column', 'true_custom', 5, 2);

// End: Добавление колонки


// Связь  типов постов Недвижимость и Города








