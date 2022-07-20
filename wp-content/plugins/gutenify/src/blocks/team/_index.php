<?php
/**
 * Server-side rendering of the `gutenify/social` block.
 *
 * @package Gutenify
 */

/**
 * Registers the block on server.
 */
function gutenify_register_team_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include GUTENIFY_PLUGIN_DIR . 'src/blocks/team/block.json';
	$metadata = json_decode( ob_get_clean(), true );

	register_block_type(
		'gutenify/team',
		array(
			'editor_script' => 'gutenify-editor',
			'editor_style'  => 'gutenify-editor',
			'style'         => 'gutenify-frontend',
		)
	);
}
add_action( 'init', 'gutenify_register_team_block' );
