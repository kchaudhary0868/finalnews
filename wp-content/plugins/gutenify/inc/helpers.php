<?php
/**
 * Helpers file.
 *
 * @package Gutenify
 */

/**
 * Gutenify Settings.
 *
 * @return array
 */
function gutenify_settings() {
	$default_settings = array(
		'active_post_types'        => array( 'post', 'page' ),
		'skip_gutenburg_post_type' => apply_filters( 'gutenify_skip_gutenburg_post_type', array() ),
	);
	$current_settings = get_option( 'gutenify_settings', array() );
	$settings         = wp_parse_args( $current_settings, $default_settings );
	return $settings;
}

/**
 * Update settings.
 *
 * @param array $new_settings New settings.
 * @return array
 */
function gutenify_update_settings( $new_settings ) {
	$settings = gutenify_settings();
	$settings = wp_parse_args( $new_settings, $settings );
	update_option( 'gutenify_settings', $settings );
	return $settings;
}

add_filter(
	'block_editor_settings_all',
	function( $args ) {
		$args['__experimentalFeatures']['typography']['fontFamilies']['theme'][] = array(
			'fontFamily' => '"Gilda Display", serif 1',
			'name'       => 'Gilda Display1',
			'slug'       => 'gilda-display1',
		);
		// error_log( print_r( $args['__experimentalFeatures']['typography']['fontFamilies']['theme'], true )) ;

		return $args;
	},
	9
);

/**
 * Minify Css.
 * https://datayze.com/howto/minify-css-with-php
 *
 * @param string $css Css styles.
 * @return String Minified css.
 */
function gutenify_minimize_css_simple($input) {
    if(trim($input) === "") return $input;
    return preg_replace(
        array(
            // Remove comment(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            // Remove unused white-space(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            // Replace `:0 0 0 0` with `:0`
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            // Replace `background-position:0` with `background-position:0 0`
            '#(background-position):0(?=[;\}])#si',
            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            // Minify string value
            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            // Minify HEX color code
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            // Replace `(border|outline):none` with `(border|outline):0`
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            // Remove empty selector(s)
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ),
        array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ),
    $input);
}
