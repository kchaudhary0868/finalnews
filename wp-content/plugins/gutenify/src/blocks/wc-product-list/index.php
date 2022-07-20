<?php

/**
 * Server-side rendering of the `posts` block.
 *
 * @package WordPress
 */

function gutenify_wc_get_add_to_cart( $product ) {
	$attributes = array(
		'aria-label'       => $product->add_to_cart_description(),
		'data-quantity'    => '1',
		'data-product_id'  => $product->get_id(),
		'data-product_sku' => $product->get_sku(),
		'rel'              => 'nofollow',
		'class'            => 'wp-block-button__link add_to_cart_button',
	);

	if (
		$product->supports( 'ajax_add_to_cart' ) &&
		$product->is_purchasable() &&
		( $product->is_in_stock() || $product->backorders_allowed() )
	) {
		$attributes['class'] .= ' ajax_add_to_cart';
	}

	return sprintf(
		'<a href="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		wc_implode_html_attributes( $attributes ),
		esc_html( $product->add_to_cart_text() )
	);
}

function gutenify_render_wc_product_list_block( $attributes ) {
	if ( ! class_exists( 'woocommerce' ) ) {
		return '';
	}
	$query = $attributes['query'];
	$args  = array(
		'post_status' => 'publish',
		'post_type' => 'product',
	);

	if ( ! empty( $query['numberOfItems'] ) ) {
		$args['posts_per_page'] = $query['numberOfItems'];
	}
	if ( ! empty( $query['orderBy'] ) ) {
		$args['orderby'] = $query['orderBy'];
	}
	if ( ! empty( $query['order'] ) ) {
		$args['order'] = strtoupper( $query['order'] );
	}


	if ( ! empty( $query['tax']['product_cat'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $query['tax']['product_cat'],
		);
	}
	if ( ! empty( $query['tax']['product_tag'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_tag',
			'field'    => 'id',
			'terms'    => $query['tax']['product_tag'],
		);
	}
	$posts = new WP_Query( $args );

	ob_start();
	if ( $posts->have_posts() ) {
		$wrapper_class = array(
			'gutenify-section-' . $attributes['blockClientId'],
			'wp-block-gutenify-wc-product-list',
			'gutenify--wc-product-list-' . $attributes['layout'],
			'gutenify--wc-product-list-col-' . $attributes['columns'],
		);
		if ( isset( $attributes['className'] ) ) {
			array_push( $wrapper_class, $attributes['className'] );
		}
		echo sprintf( '<div class="%s">', implode( ' ', $wrapper_class ) );
		while( $posts->have_posts() ) {
			$posts->the_post();
			$product = get_product( get_the_ID() );
			$permalink = get_the_permalink( $product->get_id() );
			echo '<div class="gutenify--wc-product--item has-no-hover-shadow-dark">';
			echo '<div class="gutenify--wc-product--item-wrapper">';


			echo '<div class="gutenify--wc-product--thumb">';
			echo '<a class="image-zoom-hover" href="' . $permalink . '" tabindex="-1">';
			echo woocommerce_get_product_thumbnail();
			echo '</a>'; // Product thumb link
			echo $product->is_on_sale() ? '<div class="gutenify--wc-product--onsale"><span aria-hidden="true">Sale</span><span class="screen-reader-text">Product on sale</span></div>' : '';

			echo '</div>'; // Product thumb
			echo '<div class="gutenify--wc-product--item-content">';

			echo '<h3 class="gutenify--wc-product--title">';
			echo '<a rel="bookmark" href="' . $permalink . '" tabindex="-1">';
			echo $product->get_name();
			echo '</a>'; // Product title link
			echo '</h3>'; // Product title

			echo '<div class="gutenify--wc-product--price">';
			echo $product->get_price_html();
			echo '</div>'; // Product price

			echo '<div class="wp-block-button wc-block-grid__product-add-to-cart">';
			echo gutenify_wc_get_add_to_cart( $product );
			// var_dump( $product );
			echo '</div>'; // Product add to cart wrapper
			echo '</div>'; // Product individual wrapper
			echo '</div>'; // Product individual wrapper
			echo '</div>'; // Product individual wrapper
		}
		echo '</div>'; // Product lists wrapper
		wp_reset_postdata();
	}
	// $products = wc_get_products( $args );
	// var_dump( $query );
	// var_dump( $args );
	// var_dump( $products );



	$result = ob_get_clean();
	return $result;
}

/**
 * Registers the `posts` block on server.
 */
function gutenify_register_wc_product_list_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include GUTENIFY_PLUGIN_DIR . 'src/blocks/wc-product-list/block.json';
	$metadata = json_decode( ob_get_clean(), true );

	register_block_type(
		'gutenify/wc-product-list',
		array(
			'attributes' => $metadata['attributes'],
			'render_callback' => 'gutenify_render_wc_product_list_block',
		)
	);
}
add_action( 'init', 'gutenify_register_wc_product_list_block' );


// add_filter( 'render_block', 'gutenify_add_data_attributes', 10, 2 );

function gutenify_add_data_attributes( $content, $block ) {
	$block_name          = $block['blockName'];
	$block_namespace = strtok( $block_name ?? '', '/' );

	/**
	 * Filters the list of allowed block namespaces.
	 *
	 * This hook defines which block namespaces should have block name and attribute `data-` attributes appended on render.
	 *
	 * @param array $allowed_namespaces List of namespaces.
	 */
	$allowed_namespaces = array_merge( array( 'gutenify' )  );
	$allowed_blocks = array_merge( array( 'gutenify/wc-product-list' )  );
	if ( ! in_array( $block_namespace, $allowed_namespaces, true ) && ! in_array( $block_name, $allowed_blocks, true ) ) {
		return $content;
	}

	if ( ! class_exists( 'ProductQuery' ) ) {
		return __return_false();
	}
	return 'test';
}
