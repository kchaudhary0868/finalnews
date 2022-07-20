<?php
/**
 * Load assets for our blocks.
 *
 * @package Gutenify
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load general assets for our blocks.
 *
 * @since 1.0.0
 */
class Gutenify_Block_Assets {
	/**
	 * This plugin's instance.
	 *
	 * @var Gutenify_Block_Assets
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 *
	 * @return Gutenify_Block_Assets
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Gutenify_Block_Assets();
		}

		return self::$instance;
	}

	/**
	 * The Constructor.
	 */
	public function __construct() {
		add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );
		add_action( 'init', array( $this, 'editor_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_block_inline_css' ), 200 );
		add_action( 'admin_footer', array( $this, 'add_admin_global_inline_css' ), 200 );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ), 9 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'editor_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Loads the asset file for the given script or style.
	 * Returns a default if the asset file is not found.
	 *
	 * @param string $filepath The name of the file without the extension.
	 *
	 * @return array The asset file contents.
	 */
	public function get_asset_file( $filepath ) {
		$asset_path = GUTENIFY_PLUGIN_DIR . $filepath . '.asset.php';

		return file_exists( $asset_path )
			? include $asset_path
			: array(
				'dependencies' => array(),
				'version'      => GUTENIFY_VERSION,
			);
	}

	/**
	 * Enqueue block assets for use within Gutenberg.
	 *
	 * @access public
	 */
	public function block_assets() {
		if ( is_admin() ) {
			return false;
		}
		global $post;

		// Only load the front end CSS if a Gutenify is in use.
		$has_gutenify = ! is_singular();

		if ( ! is_admin() && is_singular() ) {
			$wp_post = get_post( $post );

			// This is similar to has_block() in core, but will match anything
			// in the gutenify/* namespace.
			if ( $wp_post instanceof WP_Post ) {
				$has_gutenify = ! empty(
					array_filter(
						array(
							false !== strpos( $wp_post->post_content, '<!-- wp:gutenify/' ),
							has_block( 'core/block', $wp_post ),
							has_block( 'core/button', $wp_post ),
							has_block( 'core/cover', $wp_post ),
							has_block( 'core/heading', $wp_post ),
							has_block( 'core/image', $wp_post ),
							has_block( 'core/gallery', $wp_post ),
							has_block( 'core/list', $wp_post ),
							has_block( 'core/paragraph', $wp_post ),
							has_block( 'core/pullquote', $wp_post ),
							has_block( 'core/quote', $wp_post ),
						)
					)
				);
			}
		}

		// if ( ! $has_gutenify && ! $this->is_page_gutenberg() ) {
		// return;
		// }

		$fonts_url = gutenify_fonts_url();
		wp_enqueue_style( 'gutenify-fonts', $fonts_url, array(), null );

		// Styles.
		$name       = 'gutenify-style';
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );
		$rtl        = ! is_rtl() ? '' : '-rtl';

		$deps = array( 'gutenify-fontawesome-style' );

		if ( $fonts_url ) {
			$deps[] = 'gutenify-fonts';
		}

		global $wp_styles;
		if ( in_array( 'global-styles', $wp_styles->queue ) ) {
			$deps[] = 'global-styles';
		}
		if ( in_array( 'woocommerce-layout', $wp_styles->queue ) ) {
			$deps[] = 'woocommerce-layout';
		}

		wp_enqueue_style( 'gutenify-frontend', GUTENIFY_PLUGIN_URL . $filepath . $rtl . '.css', $deps, $asset_file['version'] );

	}

	/**
	 * Enqueue block assets for use within Gutenberg.
	 *
	 * @access public
	 */
	public function editor_assets() {

		// Styles.
		$name       = 'gutenify-editor';
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );
		$rtl        = ! is_rtl() ? '' : '-rtl';

		wp_register_style( 'gutenify-fontawesome-style', GUTENIFY_PLUGIN_URL . '/assets/fontawesome/css/all.css', array(), 'v4' );

		$fonts_url = gutenify_fonts_url();
		wp_enqueue_style( 'gutenify-fonts', $fonts_url, array(), null );

		$deps = array( 'gutenify-fontawesome-style' );

		if ( $fonts_url ) {
			$deps[] = 'gutenify-fonts';
		}

		if ( class_exists( 'woocommerce' ) ) {
			$deps[] = 'wc-blocks-editor-style';
		}

		wp_register_style(
			'gutenify-editor',
			GUTENIFY_PLUGIN_URL . $filepath . $rtl . '.css',
			$deps,
			$asset_file['version']
		);

		// Scripts.
		$name       = 'gutenify'; // gutenify.js.
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );

		wp_register_script(
			'gutenify-editor',
			GUTENIFY_PLUGIN_URL . $filepath . '.js',
			array_merge( $asset_file['dependencies'], array( 'wp-api', 'gutenify-global' ) ),
			$asset_file['version'],
			true
		);

		$post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );

		wp_localize_script(
			'gutenify-editor',
			'gutenify_block_data',
			array(
				'plugin_directory_url'     => esc_url( GUTENIFY_PLUGIN_URL ),
				'site_url'                 => esc_url( site_url() ),
				'settings_url'             => esc_url( admin_url( 'edit.php?post_type=gutenify_template&page=gutenify-settings' ) ),
				'add_template_url'         => esc_url( admin_url( 'post-new.php?post_type=gutenify_template' ) ),
				'is_woocommerce_activated' => class_exists( 'woocommerce' ),
			)
		);

		$localized_values = array(
			'font_families'        => gutenify_font_families(),
			'plugin_directory_url' => esc_url( GUTENIFY_PLUGIN_URL ),
			'site_url'             => esc_url( site_url() ),
		);
		wp_localize_script(
			'gutenify-editor',
			'_gutenify',
			apply_filters( 'gutenify-admin-localized-values', $localized_values ),
		);

		wp_localize_script(
			'gutenify-editor',
			'_gutenify_vars',
			array(
				'site_url'             => esc_url( site_url() ),
				'plugin_directory_url' => esc_url( GUTENIFY_PLUGIN_URL ),
				'gutenify_version'     => GUTENIFY_VERSION,
				'pro_license_status'   => apply_filters( 'gutenify_pro_license_status', false ),
				'is_pro_activated'     => apply_filters( 'gutenify_pro_activation_status', false ),
			)
		);
	}

	/**
	 * Enqueue front-end assets for blocks.
	 *
	 * @access public
	 * @since 1.9.5
	 */
	public function frontend_scripts() {

		// Scripts.
		$name     = 'swiper-bundle'; // swiper.js.
		$filepath = 'assets/js/lib/' . $name;

		wp_register_script(
			'gutenify-swiper',
			GUTENIFY_PLUGIN_URL . $filepath . '.js',
			array( 'jquery' ),
			'6.8.2',
			false
		);

		// Scripts.
		$name       = 'gutenify-frontend'; // gutenify.js.
		$filepath   = 'dist/js/' . $name;
		$asset_file = $this->get_asset_file( $filepath );

		$deps = array( 'jquery', 'gutenify-swiper' );

		// Enqueue for gutenify animations.
		wp_enqueue_script(
			'gutenify-frontend',
			GUTENIFY_PLUGIN_URL . $filepath . '.js',
			$deps,
			GUTENIFY_VERSION,
			false
		);


		/**
		 * Add: Isotope JS
		 */

		// Scripts.
		$name     = 'gutenify-isotope'; // swiper.js.
		$filepath = 'assets/js/lib/isotope.pkgd';
		wp_register_script( $name, GUTENIFY_PLUGIN_URL . $filepath . '.js', array( 'jquery' ), '3.0.6', false );

		/**
		 * END: Isotope JS
		 */


		/**
		 * Add: marquee JS
		 */

		// Scripts.
		$name     = 'jquery-marquee';
		$filepath = 'assets/js/lib/jquery.marquee';
		wp_register_script( $name, GUTENIFY_PLUGIN_URL . $filepath . '.js', array( 'jquery' ), '1.6.0', false );

		/**
		 * END: marquee JS
		 */

		// Styles.
		$name       = 'swiper-bundle.min'; // swiper.js.
		$filepath   = 'assets/css/lib/' . $name;
		$asset_file = $this->get_asset_file( $filepath );
		wp_enqueue_style(
			'gutenify-swiper-style',
			GUTENIFY_PLUGIN_URL . $filepath . '.css',
			array(),
			'6.8.2'
		);

	}

	/**
	 * Enqueue editor scripts for blocks.
	 *
	 * @access public
	 * @since 1.9.5
	 */
	public function editor_scripts() {
	}

	/**
	 * Return whether a post type should display the Block Editor.
	 *
	 * @param string $post_type The post_type slug to check.
	 */
	protected function is_post_type_gutenberg( $post_type ) {
		return use_block_editor_for_post_type( $post_type );
	}

	/**
	 * Return whether the page we are on is loading the Block Editor.
	 */
	protected function is_page_gutenberg() {
		if ( ! is_admin() ) {
			return false;
		}

		$admin_page = wp_basename( esc_url( $_SERVER['REQUEST_URI'] ) );

		if ( false !== strpos( $admin_page, 'post-new.php' ) && empty( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		if ( false !== strpos( $admin_page, 'post-new.php' ) && isset( $_GET['post_type'] ) && $this->is_post_type_gutenberg( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		if ( false !== strpos( $admin_page, 'post.php' ) ) {
			$wp_post = get_post( $_GET['post'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( isset( $wp_post ) && isset( $wp_post->post_type ) && $this->is_post_type_gutenberg( $wp_post->post_type ) ) {
				return true;
			}
		}

		if ( false !== strpos( $admin_page, 'revision.php' ) ) {
			$wp_post     = get_post( $_GET['revision'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$post_parent = get_post( $wp_post->post_parent );
			if ( isset( $post_parent ) && isset( $post_parent->post_type ) && $this->is_post_type_gutenberg( $post_parent->post_type ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Add inline css
	 *
	 * @return void
	 */
	public static function add_block_inline_css() {
		if ( is_singular() ) {
			global $post;
			// $style_file = trailingslashit( wp_upload_dir()['basedir'] ) . 'gutenify/styles/style-' . 'post-' . $post->ID . '.css';

			// if ( file_exists( $style_file ) ) {
			// $style_file_url = trailingslashit( wp_upload_dir()['baseurl'] ) . 'gutenify/styles/style-' . 'post-' . $post->ID . '.css';

			// wp_enqueue_style( 'gutenify-frontend-post', $style_file_url, array( 'gutenify-frontend' ), GUTENIFY_VERSION );
			// } else {
			// }
			$post_meta           = get_post_meta( $post->ID );
			$gutenify_custom_css = ! empty( $post_meta['gutenify_custom_css'][0] ) ? $post_meta['gutenify_custom_css'][0] : '';
			wp_add_inline_style( 'gutenify-frontend', $gutenify_custom_css );
		}
		$gutenify_global_style = get_option( 'gutenify_global_style' );

		$deps = array();
		wp_register_style( 'gutenify-global-inline-handle', false, $deps );
		wp_enqueue_style( 'gutenify-global-inline-handle' );

		if ( $gutenify_global_style ) {
			$handle = 'gutenify-global-inline-handle';
			wp_add_inline_style( $handle, $gutenify_global_style );
		}
	}

	/**
	 * Add Global inline css
	 *
	 * @return void
	 */
	public static function add_admin_global_inline_css() {

		$gutenify_admin_global_style = get_option( 'gutenify_admin_global_style' );
		$deps                        = array();
		wp_register_style( 'gutenify-global-inline-handle', false, $deps );
		wp_enqueue_style( 'gutenify-global-inline-handle' );

		if ( $gutenify_admin_global_style ) {
			wp_add_inline_style( 'gutenify-global-inline-handle', $gutenify_admin_global_style );
		}
	}

	/**
	 * Admin scripts.
	 *
	 * @return mixed
	 */
	public function admin_scripts() {
		// Scripts.
		$name       = 'gutenify-global'; // gutenify.js.
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );

		// Enqueue for gutenify animations.
		wp_register_script(
			$name,
			GUTENIFY_PLUGIN_URL . $filepath . '.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		// Getting Started.
		if ( ( ! empty( $_GET['page'] ) && 'gutenify' === $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			// Scripts.
			$name       = 'gutenify-getting-started-admin'; // gutenify.js.
			$filepath   = 'dist/' . $name;
			$asset_file = $this->get_asset_file( $filepath );

			// Enqueue for gutenify animations.
			wp_enqueue_script(
				'gutenify-getting-started-admin',
				GUTENIFY_PLUGIN_URL . $filepath . '.js',
				$asset_file['dependencies'],
				$asset_file['version'],
				true
			);

			// Styles.
			$name       = 'gutenify-getting-started-admin-style';
			$filepath   = 'dist/' . $name;
			$asset_file = $this->get_asset_file( $filepath );
			$rtl        = ! is_rtl() ? '' : '-rtl';

			wp_enqueue_style(
				$name,
				GUTENIFY_PLUGIN_URL . $filepath . $rtl . '.css',
				array( 'gutenify-fontawesome-style', 'wp-components' ),
				$asset_file['version']
			);

			wp_localize_script(
				'gutenify-getting-started-admin',
				'_gutenify_vars',
				array(
					'site_url'             => esc_url( site_url() ),
					'plugin_directory_url' => esc_url( GUTENIFY_PLUGIN_URL ),
					'gutenify_version'     => GUTENIFY_VERSION,
					// 'gutenify_com_server_url'  => defined( 'GUTENIFY_COM_SERVER_URL' ) ? trailingslashit( GUTENIFY_COM_SERVER_URL ) : trailingslashit( 'https://api.gutenify.com/' ),
					// 'is_block_theme'           => function_exists( 'wp_get_theme' ) && ! empty( wp_get_theme()->is_block_theme() ),
					// 'is_woocommerce_activated' => class_exists( 'woocommerce' ),
					'pro_license_status'   => apply_filters( 'gutenify_pro_license_status', false ),
					'is_pro_activated'     => apply_filters( 'gutenify_pro_activation_status', false ),
				)
			);
		}

		// Site options
		if ( ( ! empty( $_GET['page'] ) && 'gutenify-site-options' === $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			// Scripts.
			$name       = 'gutenify-site-options-admin'; // gutenify.js.
			$filepath   = 'dist/' . $name;
			$asset_file = $this->get_asset_file( $filepath );

			// Enqueue for gutenify animations.
			wp_enqueue_script(
				'gutenify-site-options-admin',
				GUTENIFY_PLUGIN_URL . $filepath . '.js',
				$asset_file['dependencies'],
				$asset_file['version'],
				true
			);

			// Styles.
			$name       = 'gutenify-site-options-admin-style';
			$filepath   = 'dist/' . $name;
			$asset_file = $this->get_asset_file( $filepath );
			$rtl        = ! is_rtl() ? '' : '-rtl';

			wp_enqueue_style(
				$name,
				GUTENIFY_PLUGIN_URL . $filepath . $rtl . '.css',
				array( 'gutenify-fontawesome-style', 'wp-components' ),
				$asset_file['version']
			);

			wp_localize_script(
				'gutenify-site-options-admin',
				'_gutenify_site_options',
				array(
					'site_url'                 => esc_url( site_url() ),
					'gutenify_com_server_url'  => defined( 'GUTENIFY_COM_SERVER_URL' ) ? trailingslashit( GUTENIFY_COM_SERVER_URL ) : trailingslashit( 'https://api.gutenify.com/' ),
					'is_block_theme'           => function_exists( 'wp_get_theme' ) && ! empty( wp_get_theme()->is_block_theme() ),
					'is_woocommerce_activated' => class_exists( 'woocommerce' ),
					'pro_license_status'       => apply_filters( 'gutenify_pro_license_status', false ),
				)
			);
		}

		// if ( ! empty( $_GET['post_type'] ) && 'gutenify_kit' === $_GET['post_type'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ( ! empty( $_GET['page'] ) && 'gutenify-template-kits' === $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			// Scripts.
			$name       = 'gutenify-kit-admin'; // gutenify.js.
			$filepath   = 'dist/' . $name;
			$asset_file = $this->get_asset_file( $filepath );

			// Enqueue for gutenify animations.
			wp_enqueue_script(
				'gutenify-kit-admin',
				GUTENIFY_PLUGIN_URL . $filepath . '.js',
				$asset_file['dependencies'],
				$asset_file['version'],
				true
			);

			// Styles.
			$name       = 'gutenify-kit-admin-style';
			$filepath   = 'dist/' . $name;
			$asset_file = $this->get_asset_file( $filepath );
			$rtl        = ! is_rtl() ? '' : '-rtl';

			wp_enqueue_style(
				$name,
				GUTENIFY_PLUGIN_URL . $filepath . $rtl . '.css',
				array( 'gutenify-fontawesome-style', 'wp-components' ),
				$asset_file['version']
			);

			wp_localize_script(
				'gutenify-kit-admin',
				'_gutenify_kit',
				array(
					'plugin_directory_url'     => esc_url( GUTENIFY_PLUGIN_URL ),
					'site_url'                 => esc_url( site_url() ),
					'gutenify_com_server_url'  => defined( 'GUTENIFY_COM_SERVER_URL' ) ? trailingslashit( GUTENIFY_COM_SERVER_URL ) : trailingslashit( 'https://api.gutenify.com/' ),
					'is_block_theme'           => wp_is_block_theme(), // function_exists( 'wp_get_theme' ) && ! empty( wp_get_theme()->is_block_theme() ),
					'is_woocommerce_activated' => class_exists( 'woocommerce' ),
					'pro_license_status'       => apply_filters( 'gutenify_pro_license_status', false ),
				)
			);

			wp_localize_script(
				'gutenify-kit-admin',
				'_gutenify_vars',
				array(
					'plugin_directory_url'     => esc_url( GUTENIFY_PLUGIN_URL ),
					'site_url'                 => esc_url( site_url() ),
					'gutenify_com_server_url'  => defined( 'GUTENIFY_COM_SERVER_URL' ) ? trailingslashit( GUTENIFY_COM_SERVER_URL ) : trailingslashit( 'https://api.gutenify.com/' ),
					'is_block_theme'           => wp_is_block_theme(), // function_exists( 'wp_get_theme' ) && ! empty( wp_get_theme()->is_block_theme() ),
					'is_woocommerce_activated' => class_exists( 'woocommerce' ),
					'pro_license_status'       => apply_filters( 'gutenify_pro_license_status', false ),
					'font_families'           => gutenify_font_families(),
					'is_pro_activated'     => apply_filters( 'gutenify_pro_activation_status', false ),
				)
			);
		}

		if ( ( ! empty( $_GET['page'] ) && 'gutenify-settings' !== $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return false;
		}
		// Scripts.
		$name       = 'gutenify-admin-settings'; // gutenify.js.
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );

		$asset_file['dependencies'][] = 'gutenify-global';

		// Enqueue for gutenify animations.
		wp_enqueue_script(
			'gutenify-admin-settings',
			GUTENIFY_PLUGIN_URL . $filepath . '.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_localize_script(
			'gutenify-admin-settings',
			'_gutenify',
			array(
				'site_url'                => esc_url( site_url() ),
				'pro_account_url'         => esc_url( admin_url( 'admin.php?page=gutenify-pro-license' ) ),
				'gutenify_com_server_url' => defined( 'GUTENIFY_COM_SERVER_URL' ) ? trailingslashit( GUTENIFY_COM_SERVER_URL ) : trailingslashit( 'https://api.gutenify.com/' ),
				'gutenify_hub_server_url' => defined( 'GUTENIFY_HUB_SERVER_URL' ) ? trailingslashit( GUTENIFY_COM_SERVER_URL ) : trailingslashit( 'https://hub.gutenify.com/' ),
				'pro_license_status'      => apply_filters( 'gutenify_pro_license_status', false ),
				'font_families'           => gutenify_font_families(),
				'global_settings'         => wp_get_global_settings(),
			)
		);

		wp_localize_script(
			'gutenify-admin-settings',
			'_gutenify_vars',
			array(
				'plugin_directory_url'     => esc_url( GUTENIFY_PLUGIN_URL ),
				'site_url'                 => esc_url( site_url() ),
				'gutenify_com_server_url'  => defined( 'GUTENIFY_COM_SERVER_URL' ) ? trailingslashit( GUTENIFY_COM_SERVER_URL ) : trailingslashit( 'https://api.gutenify.com/' ),
				'is_block_theme'           => wp_is_block_theme(), // function_exists( 'wp_get_theme' ) && ! empty( wp_get_theme()->is_block_theme() ),
				'is_woocommerce_activated' => class_exists( 'woocommerce' ),
				'pro_license_status'       => apply_filters( 'gutenify_pro_license_status', false ),
				'font_families'           => gutenify_font_families(),
				'is_pro_activated'     => apply_filters( 'gutenify_pro_activation_status', false ),
			)
		);

		// Styles.
		$name       = 'gutenify-admin-settings-style';
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );
		$rtl        = ! is_rtl() ? '' : '-rtl';

		wp_enqueue_style(
			$name,
			GUTENIFY_PLUGIN_URL . $filepath . $rtl . '.css',
			array( 'gutenify-fontawesome-style', 'wp-components' ),
			$asset_file['version']
		);
	}
}

Gutenify_Block_Assets::register();
