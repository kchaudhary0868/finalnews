<?php
/**
 * Templates
 *
 * @package Gutenify
 */

/**
 * Gutenify_Admin_Menu
 */
class Gutenify_Admin_Menu {
	/**
	 * Gutenify_Admin_Menu constructor.
	 */
	public function __construct() {
		// Register custom post type.
		add_action( 'admin_menu', array( $this, 'register_sub_menu' ) );
	}

	/**
	 * Register Admin menu.
	 */
	public function register_sub_menu() {
		add_menu_page(
			__( 'Gutenify: Getting Started' ),
			'Gutenify',
			'manage_options',
			'gutenify',
			array( &$this, 'getting_started_page_callback' ),
			'data:image/svg+xml;base64,' . base64_encode( file_get_contents( GUTENIFY_PLUGIN_DIR . 'assets/images/gutenify-logo.svg' ) ),
			90
		);
		add_submenu_page(
			'gutenify',
			__( 'Gutenify Template Kits' ),
			__( 'Template Kits' ),
			'manage_options',
			'gutenify-template-kits',
			array( &$this, 'template_kits_page_callback' )
		);
		// add_submenu_page( 'gutenify', __( 'Gutenify Templates' ), __( 'Templates' ), 'manage_options', 'edit.php?post_type=gutenify_template' );
		add_submenu_page(
			'gutenify',
			__( 'Gutenify Settings' ),
			__( 'Settings' ),
			'manage_options',
			'gutenify-settings',
			array( &$this, 'settings_page_callback' )
		);
		// add_submenu_page(
		// 'themes.php', __( 'Gutenify Site Options' ), __( 'Site Options' ), 'manage_options', 'gutenify-site-options', array(&$this, 'site_options_page_callback')
		// );
		// add_submenu_page('edit.php?post_type=entertainment', 'Genre', 'Genre', 'manage_options', 'edit-tags.php?taxonomy=genre&post_type=entertainment');
	}

	/**
	 * Render submenu.
	 *
	 * @return void
	 */
	public function settings_page_callback() {
		echo '<div class="wrap">';
		echo '<div id="gutenify-settings-app">Loading...</div>';
		echo '</div>';
	}

	/**
	 * Render submenu.
	 *
	 * @return void
	 */
	public function template_kits_page_callback() {
		echo '<div class="wrap">';
		echo '<div id="gutenify-template-kit-app">Loading...</div>';
		echo '</div>';
	}

	/**
	 * Render getting started page..
	 *
	 * @return void
	 */
	public function getting_started_page_callback() {
		echo '<div class="wrap">';
		echo '<div id="gutenify-getting-started-app">Loading...</div>';
		echo '</div>';
	}

	/**
	 * Render submenu.
	 *
	 * @return void
	 */
	public function site_options_page_callback() {
		echo '<div class="wrap">';
		echo '<div id="gutenify-site-options-app">Loading...</div>';
		echo '</div>';
	}

}

new Gutenify_Admin_Menu();
