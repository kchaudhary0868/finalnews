<?php
/**
 * Server-side rendering of the `gutenify/section-title` block.
 *
 * @package WordPress
 */

/**
 * Renders the `gutenify/section-title` block on the server.
 *
 * @param array $attributes Block attributes.
 *
 * @return string Returns the filtered post title for the current post wrapped inside "h1" tags.
 */
function gutenify_render_block_navigation_menu( $attributes ) {
	$content_justification = ! empty( $attributes['contentJustification'] ) ? 'is-content-justification-' . $attributes['contentJustification'] : '';
	ob_start();
	if ( has_nav_menu( 'primary' ) ) : ?>
	<div class="wp-block-gutenify-navitation-menu <?php echo esc_attr( $content_justification ); ?>">
		<div class="gutenify-navitation-menu-section">
			<nav id="site-navigation" class="primary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'hello-gutenify' ); ?>">
				<div class="menu-button-container">
					<button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list" aria-expanded="false">
						<span class="dropdown-icon open">
							<i class="ion-navicon-round"></i>
						</span>
						<span class="dropdown-icon close">
							<i class="ion-close"></i>
						</span>
					</button><!-- #primary-mobile-menu -->
				</div><!-- .menu-button-container -->
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'menu_class'      => 'menu-wrapper',
						'container_class' => 'primary-menu-container',
						'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
						'fallback_cb'     => false,
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div>
	</div>
		<?php
	endif;
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/**
 * Registers the `gutenify/section-title` block on the server.
 */
function gutenify_register_block_navigation_menu() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include GUTENIFY_PLUGIN_DIR . 'src/blocks/section-title/block.json';
	$metadata = json_decode( ob_get_clean(), true );
	register_block_type(
		'gutenify/navigation-menu',
		array(
			'render_callback' => 'gutenify_render_block_navigation_menu',
			'editor_script'   => 'gutenify-editor',
			'editor_style'    => 'gutenify-editor',
			'style'           => 'gutenify-frontend',
			'attributes'      => $metadata['attributes'],
		)
	);
}
add_action( 'init', 'gutenify_register_block_navigation_menu' );
