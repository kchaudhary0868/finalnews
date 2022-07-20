<?php
/**
 * Server-side rendering of the `posts` block.
 *
 * @package WordPress
 */

function gutenify_render_wc_product_carousel_block( $attributes, $content, $props ) {
	if ( ! class_exists( 'woocommerce' ) ) {
		return '';
	}
	$query = $attributes['query'];
	$args  = array(
		'post_status' => 'publish',
		'post_type'   => 'product',
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
			'wp-block-gutenify-wc-product-carousel',
			'gutenify--wc-product-carousel-' . $attributes['layout'],
			'gutenify--wc-product-carousel-col-' . $attributes['columns'],
		);
		if ( isset( $attributes['className'] ) ) {
			array_push( $wrapper_class, $attributes['className'] );
		}
		$wrapper_class = apply_filters( 'gutenify--slider--wrapper-class', $wrapper_class, $props );
		echo sprintf( '<div class="%s">', implode( ' ', $wrapper_class ) );
		echo '<div class="swiper-container">';
		echo '<div class="swiper-wrapper">';
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$product   = get_product( get_the_ID() );
			$permalink = get_the_permalink( $product->get_id() );
			echo '<div class="gutenify--wc-product--item has-no-hover-shadow-dark swiper-slide">';
			echo '<div class="gutenify--wc-product--item-wrapper">';

			echo '<div class="gutenify--wc-product--thumb">';
			echo '<a class="image-hover-zoom" href="' . $permalink . '" tabindex="-1">';
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
			echo '</div>'; // .gutenify--wc-product--item-content

			echo '</div>'; // Product individual wrapper
			echo '</div>'; // Product individual wrapper
		}

		echo '</div>'; // .swiper-wrapper
		$has_navigation = ! empty( $attributes['hasNavigation'] ) && true === $attributes['hasNavigation'];
		$has_pagination = ! empty( $attributes['hasPagination'] ) && true === $attributes['hasPagination'];
		if ( $has_navigation ) {
			echo '<div class="swiper-button-next"></div>';
			echo '<div class="swiper-button-prev"></div>';
		}
		if ( $has_pagination ) {
			echo '<div class="swiper-pagination"></div>';
		}
		echo '</div>'; // .swiper-container
		echo '</div>'; // Product carousels wrapper
		wp_reset_postdata();
	}
	wp_enqueue_script( 'gutenify-swiper' );

	$columns       = ! empty( $attributes['columns'] ) ? $attributes['columns'] : 1;
	$space_between = ! empty( $attributes['spaceBetween'] ) ? $attributes['spaceBetween'] : 0;
	$swiper_config = array(
		'loop'          => 'true',
		'slidesPerView' => $columns,
		'breakpoints'   => array(
			'320'  => array(
				'slidesPerView' => 1,
				'spaceBetween'  => 20,
			),
			// when window width is >= 640px
			'640'  => array(
				'slidesPerView' => 2,
				'spaceBetween'  => 15,
			),
			'1024' => array(
				'slidesPerView' => $columns,
				'spaceBetween'  => $space_between,
			),
		),
		'spaceBetween'  => $space_between,
		'scrollbar'     => array( 'draggable' => true ),
	);

	if ( $has_navigation ) {
		$swiper_config['navigation'] = array(
			'nextEl' => '.swiper-button-next',
			'prevEl' => '.swiper-button-prev',
		);
	}

	if ( $has_pagination ) {
		$swiper_config['pagination'] = array(
			'el'        => '.swiper-pagination',
			'clickable' => true,
		);
	}

	$block_client_id      = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : 1;
	$slider_var           = 'slider_' . str_replace( '-', '_', $block_client_id );
	$slider_function_name = 'reinitSlider_' . $slider_var;
	?>
	<script>
		jQuery(function($){
			var sliderConfig = <?php echo json_encode( $swiper_config ); ?>;
			console.log( sliderConfig );
			function <?php echo $slider_function_name; ?>() {
				var swiperWrapper = $(".gutenify-section-<?php echo $block_client_id; ?> .swiper-wrapper");
				var newSlides = swiperWrapper.children(".swiper-slide").clone(true);
				' . $slider_var . '.destroy();
				swiperWrapper.empty().append(newSlides);
				swiperWrapper.attr("style", "");
				mySwiper = new Swiper(".gutenify-section-<?php echo $block_client_id; ?> .swiper-container", sliderConfig);
			}

			var <?php echo $slider_var; ?> = new Swiper(".gutenify-section-<?php echo $block_client_id; ?> .swiper-container", sliderConfig);
			$(window).on("resize", function(){
				' . $slider_function_name . '();
			});
			$(document).on("containerStretched", function(){
				' . $slider_function_name . '();
			});
		});
	</script>
	<?php
	$result = ob_get_clean();
	return $result;
}

/**
 * Registers the `posts` block on server.
 */
function gutenify_register_wc_product_carousel_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include GUTENIFY_PLUGIN_DIR . 'src/blocks/wc-product-carousel/block.json';
	$metadata = json_decode( ob_get_clean(), true );

	register_block_type(
		'gutenify/wc-product-carousel',
		array(
			'attributes'      => $metadata['attributes'],
			'render_callback' => 'gutenify_render_wc_product_carousel_block',
		)
	);
}
add_action( 'init', 'gutenify_register_wc_product_carousel_block' );
