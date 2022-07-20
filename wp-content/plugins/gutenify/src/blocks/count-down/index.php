<?php
/**
 * Server-side rendering of the `gutenify/social` block.
 *
 * @package Gutenify
 */

/**
 * Map Block render
 *
 * @param array $attributes Map Attributes.
 * @return string
 */
function gutenify_render_count_down_block( $attributes ) {
	$client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$align     = ! empty( $attributes['align'] ) ? $attributes['align'] : 'full';
	$class     = ! empty( $attributes['className'] ) ? $attributes['className'] : '';
	$class     = 'wp-block-gutenify-map align' . $align . ' ' . $class;
	$location  = ! empty( $attributes['location'] ) ? $attributes['location'] : '';
	$language  = ! empty( $attributes['language'] ) ? $attributes['language'] : 'en';
	$zoom      = ! empty( $attributes['zoom'] ) ? $attributes['zoom'] : 12;
	$height    = ! empty( $attributes['height'] ) ? $attributes['height'] : 400;

	return '<div class="' . $class . '"><div id="gutenify-section-' . $client_id . '"><iframe title="Google Map" frameBorder="0" src="https://www.google.com/maps?q=' . $location . '&output=embed&hl=' . $language . '&z=' . $zoom . '" style="width:100%;min-height:' . $height . 'px"></iframe></div></div>';
}

/**
 * Registers the block on server.
 */
function gutenify_register_count_down_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include GUTENIFY_PLUGIN_DIR . 'src/blocks/count-down/block.json';
	$metadata = json_decode( ob_get_clean(), true );

	register_block_type(
		'gutenify/count-down',
		array(
			'editor_script'   => 'gutenify-editor',
			'editor_style'    => 'gutenify-editor',
			'style'           => 'gutenify-frontend',
			'attributes'      => $metadata['attributes'],
			'render_callback' => 'gutenify_render_count_down_block',
		)
	);
}
add_action( 'init', 'gutenify_register_count_down_block' );
