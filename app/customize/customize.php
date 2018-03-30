<?php
/**
 * WordPress customize enhancements.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get color configs.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_get_theme_colors() {
	$scheme = include get_template_directory() . '/app/customize/config-scheme.php';
	$grays  = include get_template_directory() . '/app/customize/config-grays.php';

	$defaults = array_merge( $scheme, $grays );

	return [
		'scheme' => $scheme,
		'grays'  => $grays,
	];
}

/**
 * Get a color.
 *
 * @since 1.0.0
 *
 * @param string $key Color key
 * @return mixed String or false on no value.
 */
function bigbox_get_theme_color( $key ) {
	return get_theme_mod( "color-{$key}", bigbox_get_theme_default_color( $key ) );
}

/**
 * Get a default color.
 *
 * @since 1.0.0
 *
 * @param  string $key Color key.
 * @return mixed String or false on no default.
 */
function bigbox_get_theme_default_color( $key ) {
	$colors = bigbox_get_theme_colors();
	$all    = array_merge( $colors['scheme'], $colors['grays'] );

	if ( isset( $all[ $key ] ) ) {
		return $all[ $key ]['default'];
	}

	return false;
}

/**
 * Build inline CSS.
 *
 * @since 1.0.0
 */
function bigbox_customize_css() {
	$css = new \BigBox\Customize\Build_Inline_CSS();

	$colors = bigbox_get_theme_colors();
	$colors = array_merge( $colors['scheme'], $colors['grays'] );

	foreach ( $colors as $key => $data ) {
		$file = get_template_directory() . '/app/customize/output/' . $key . '.php';

		if ( ! file_exists( $file ) ) {
			continue;
		}

		$config = include $file;

		foreach ( $config as $data ) {
			$css->add( $data );
		}
	}

	return $css->build();
}

/**
 * Enqueue customizer scripts.
 *
 * @since 1.0.0
 */
function bigbox_customize_preview_init() {
	wp_enqueue_script(
		'bigbox-customize-preview',
		get_template_directory_uri() . '/public/js/customize-preview.min.js',
		[ 'customize-preview' ],
		bigbox_get_theme_version(),
		true
	);
}
add_action( 'customize_preview_init', 'bigbox_customize_preview_init', 99 );

/**
 * Return filtered inline CSS for live previews.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_preview_css() {
	$customized = json_decode( wp_unslash( $_POST['customized'] ), true );

	// Filter `get_theme_mod()` calls for customized settings.
	foreach ( $customized as $setting_id => $value ) {
		add_filter(
			'theme_mod_' . sanitize_key( $setting_id ), function( $value ) {
				if ( isset( $customized[ $setting_id ] ) ) {
					return $customized[ $setting_id ];
				}

				return $value;
			}
		);
	}

	return wp_send_json_success( bigbox_customize_css() );
}
add_action( 'wp_ajax_bigbox-preview-css', 'bigbox_preview_css' );

/**
 * Adds postMessage support for site title and adds a note about description not being output.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register( $wp_customize ) {
	// postMessage some settings.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'header_text' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Update title of Tagline.
	$wp_customize->get_control( 'blogdescription' )->description = esc_html__( 'Not output but used for SEO', 'bigbox' );

	// Update label of Header Text
	$wp_customize->get_control( 'header_text' )->label = esc_html__( 'Display Site Title', 'bigbox' );

	// Update branding partial when Site Title or text changes.
	foreach ( [ 'blogname', 'header_text' ] as $setting ) {
		$wp_customize->selective_refresh->add_partial(
			$setting, [
				'selector'            => '.branding',
				'container_inclusive' => false,
				'render_callback'     => function() {
					bigbox_partial( 'branding' );
				},
			]
		);
	}
}
add_action( 'customize_register', 'bigbox_customize_register', 11 );

/**
 * Color controls.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_colors( $wp_customize ) {
	// Create panel.
	$wp_customize->add_panel(
		'colors', [
			'title'    => _x( 'Colors', 'customizer panel title', 'bigbox' ),
			'priority' => 25,
		]
	);

	// Create "Scheme" and "Grays" sections.
	$wp_customize->add_section(
		'colors-scheme', [
			'title'    => _x( 'Scheme', 'customizer section title (colors)', 'bigbox' ),
			'panel'    => 'colors',
			'priority' => 10,
		]
	);

	$wp_customize->add_section(
		'colors-grays', [
			'title'    => _x( 'Grays', 'customizer section title (colors)', 'bigbox' ),
			'panel'    => 'colors',
			'priority' => 20,
		]
	);

	// Add colors.
	$controls = bigbox_get_theme_colors();

	foreach ( $controls as $section => $colors ) {

		foreach ( $colors as $theme_color => $color ) {
			$key = "color-${theme_color}";

			$wp_customize->add_setting(
				$key, [
					'default'           => $color['default'],
					'transport'         => 'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				]
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$key,
					[
						'label'   => $color['label'],
						'section' => 'colors-' . $section,
					]
				)
			);
		}
	}
}
add_action( 'customize_register', 'bigbox_customize_register_colors', 11 );

/**
 * Convert a HEX value to RGBA.
 *
 * @since 1.0.0
 *
 * @param string $color HEX value.
 * @param int    $opacity Opacity to use.
 * @return string
 */
function bigbox_hex_to_rgba( $color, $opacity = false ) {
	if ( '#' === $color[0] ) {
		$color = substr( $color, 1 );
	}

	if ( 6 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] ];
	} elseif ( 3 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] ];
	} else {
		return $default;
	}

	$rgb = array_map( 'hexdec', $hex );

	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}

		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}

	return $output;
}
