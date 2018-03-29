<?php
/**
 * Global page header.
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
?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="initial-scale=1">

		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<?php bigbox_partial( 'navbar' ); ?>

		<div class="container">
			<div class="row">

<style>
<?php
$config = include get_template_directory() . '/app/theme/customize/config-css.php';
$scheme = include get_template_directory() . '/app/theme/customize/config-scheme.php';
$grays  = include get_template_directory() . '/app/theme/customize/config-grays.php';

$defaults = array_merge( $scheme, $grays );

foreach ( $config as $color => $properties ) {
	$color = get_theme_mod( "color-${color}", $defaults[ $color ]['default'] );

	foreach ( $properties as $property => $selectors ) {
		foreach ( $selectors as $selector ) {
			printf( '%s { %s: %s }', $selector, $property, $color );
		}
	}
}
?>
</style>
