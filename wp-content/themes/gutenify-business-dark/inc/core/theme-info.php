<?php
/**
 * Add theme page
 */
function gutenify_business_dark_menu() {
	add_theme_page( esc_html__( 'Gutenify Business Dark', 'gutenify-business-dark' ), esc_html__( 'Gutenify Theme', 'gutenify-business-dark' ), 'edit_theme_options', 'gutenify-business-dark-info', 'gutenify_business_dark_theme_page_display' );
}
add_action( 'admin_menu', 'gutenify_business_dark_menu' );

/**
 * Display About page
 */
function gutenify_business_dark_theme_page_display() {
	$theme = wp_get_theme();

	if ( is_child_theme() ) {
		$theme = wp_get_theme()->parent();
	}

	include_once 'templates/theme-info.php';
}
