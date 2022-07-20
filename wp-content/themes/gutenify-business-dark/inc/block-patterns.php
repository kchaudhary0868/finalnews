<?php
/**
 * Gutenify Business Dark: Block Patterns
 *
 * @since Gutenify Business Dark 1.0
 */

 /**
  * Get patterns content.
  *
  * @param string $file_name Filename.
  * @return string
  */
function gutenify_business_dark_get_pattern_content( $file_name ) {
	ob_start();
	include get_theme_file_path( '/inc/patterns/' . $file_name . '.php' );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/**
 * Registers block patterns and categories.
 *
 * @since Gutenify Business Dark 1.0
 *
 * @return void
 */
function gutenify_business_dark_register_block_patterns() {

	$patterns = array(
		'header-default' => array(
			'title'      => __( 'Default header', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-headers' ),
			'blockTypes' => array( 'core/template-part/header' ),
		),
		'header-two' => array(
			'title'      => __( 'Header Two ', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-headers' ),
			'blockTypes' => array( 'core/template-part/header' ),
		),
		'header-three' => array(
			'title'      => __( 'Header Three', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-headers' ),
			'blockTypes' => array( 'core/template-part/header' ),
		),
		'footer-default' => array(
			'title'      => __( 'Default footer', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-footers' ),
			'blockTypes' => array( 'core/template-part/footer' ),
		),
		'home-banner' => array(
			'title'      => __( 'Home Banner', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-banner' ),
		),
		'call-to-action' => array(
			'title'      => __( 'Call To Action', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-banner' ),
		),
		'gallery' => array(
			'title'      => __( 'Gallery', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-gallery' ),
		),
		'service-one' => array(
			'title'      => __( 'Service One', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-services' ),
		),
		'service-two' => array(
			'title'      => __( 'Service Two', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-services' ),
		),
		'hero-section' => array(
			'title'      => __( 'Hero Section', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-hero-section' ),
		),
		'primary-sidebar' => array(
			'title'    => __( 'Primary Sidebar', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-sidebars' ),
		),
		'hidden-404' => array(
			'title'    => __( '404 content', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-pages' ),
		),
		'post-listing-single-column' => array(
			'title'    => __( 'Post Single Column', 'gutenify-business-dark' ),
			//'inserter' => false,
			'categories' => array( 'gutenify-business-dark-query' ),
		),
		'post-listing-two-column' => array(
			'title'    => __( 'Post Two Column', 'gutenify-business-dark' ),
			//'inserter' => false,
			'categories' => array( 'gutenify-business-dark-query' ),
		),
		'post-listing-three-column' => array(
			'title'    => __( 'Post Three Column', 'gutenify-business-dark' ),
			//'inserter' => false,
			'categories' => array( 'gutenify-business-dark-query' ),
		),
		'post-listing-four-column' => array(
			'title'    => __( 'Post Four Column', 'gutenify-business-dark' ),
			//'inserter' => false,
			'categories' => array( 'gutenify-business-dark-query' ),
		),
		'feature-post-column' => array(
			'title'    => __( 'Feature Post Column', 'gutenify-business-dark' ),
			//'inserter' => false,
			'categories' => array( 'gutenify-business-dark-query' ),
		),
		'comment-section-1' => array(
			'title'    => __( 'Comment Section 1', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-comment-sections' ),
		),
		'cover-with-post-title' => array(
			'title'    => __( 'Cover With Post Title', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-banner-sections' ),
		),
		'cover-with-archive-title' => array(
			'title'    => __( 'Cover With Archive Title', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-banner-sections' ),
		),
		'section-title' => array(
			'title'    => __( 'Section Title', 'gutenify-business-dark' ),
			'categories' => array( 'gutenify-business-dark-section-title' ),
		),
	);

	$block_pattern_categories = array(
		'gutenify-business-dark-footers' => array( 'label' => __( 'Footers', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-headers' => array( 'label' => __( 'Headers', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-pages'   => array( 'label' => __( 'Pages', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-query'   => array( 'label' => __( 'Query', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-sidebars'   => array( 'label' => __( 'Sidebars', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-banner'   => array( 'label' => __( 'Banner Sections', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-hero-section'   => array( 'label' => __( 'Hero Sections', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-section-title'          => array( 'label' => __( 'Section Title', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-Services'   => array( 'label' => __( 'Services', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-gallery' => array( 'label' => __( 'Gallery', 'gutenify-business-dark' ) ),
		'gutenify-business-dark-comment-section'   => array( 'label' => __( 'Comment Sections', 'gutenify-business-dark' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since Gutenify Business Dark 1.0
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 *     @type array[] $properties {
	 *         An array of block category properties.
	 *
	 *         @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 */
	$block_pattern_categories = apply_filters( 'gutenify_business_dark_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	/**
	 * Filters the theme block patterns.
	 *
	 * @since Gutenify Business Dark 1.0
	 *
	 * @param array $block_patterns List of block patterns by name.
	 */
	$patterns = apply_filters( 'gutenify_business_dark_block_patterns', $patterns );

	foreach ( $patterns as $block_pattern => $pattern ) {
		$pattern['content'] = gutenify_business_dark_get_pattern_content( $block_pattern );
		register_block_pattern(
			'gutenify-business-dark/' . $block_pattern,
			$pattern
		);
	}
}
add_action( 'init', 'gutenify_business_dark_register_block_patterns', 9 );
