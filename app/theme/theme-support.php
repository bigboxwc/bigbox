<?php
/**
 * WordPress features.
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
 * Declare view support for various built in WordPress features.
 *
 * @since 1.0.0
 */
function bigbox_add_theme_support() {
	// Set the default content width.
	$GLOBALS['content_width'] = 801;

	// Add gettext support.
	load_theme_textdomain( 'bigbox', get_template_directory() . '/resources/languages' );

	// Dynamic <title> tags.
	add_theme_support( 'title-tag' );

	// Adds RSS feed links to HTML <head>.
	add_theme_support( 'automatic-feed-links' );

	// Use HTML markup for WordPress-generated markup.
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'commentlist',
			'gallery',
			'caption',
		]
	);

	// Allow featured images to be used.
	add_theme_support( 'post-thumbnails' );

	// Custom logo support.
	add_theme_support(
		'custom-logo',
		[
			'flex-width'  => true,
			'header-text' => true,
		]
	);

	// Background.
	add_theme_support(
		'custom-background',
		[
			'default-color' => 'ffffff',
		]
	);
}
add_action( 'after_setup_theme', 'bigbox_add_theme_support' );
