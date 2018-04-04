<?php
/**
 * Searching in the nav bar.
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

if ( ! bigbox_is_integration_active( 'woocommerce' ) ) :
	return;
endif;
?>

<form id="primary-search" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" method="GET" class="navbar-search">

	<?php
	$categories = get_terms( apply_filters( 'bigbox_navbar_search_dropdown',
		[
			'taxonomy' => 'product_cat',
		]
	) );

	if ( $categories && ! is_wp_error( $categories ) && ! empty( $categories ) ) :
		$selected = isset( $_GET['product_cat'] ) ? esc_attr( $_GET['product_cat'] ) : null;
	?>

	<div id="navbar-search__category" class="navbar-search__category">
		<label for="product_cat" class="screen-reader-text"><?php esc_html_e( 'Choose a category', 'bigbox' ); ?>:</label>

		<select name="product_cat">
			<option value=""><?php esc_html_e( 'All Categories', 'bigbox' ); ?></option>
			<?php foreach ( $categories as $category ) : ?>
			<option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( $selected, $category->slug ); ?>><?php echo esc_html( $category->name ); ?></option>
			<?php endforeach; ?>
		</select>

		<select>
			<option value=""><?php esc_html_e( 'All Categories', 'bigbox' ); ?></option>
		</select>
	</div>

	<?php endif; ?>

	<div class="navbar-search__keywords">
		<label for="s" class="screen-reader-text"><?php esc_html_e( 'Find a product', 'bigbox' ); ?>:</label>
		<input type="search" name="s" class="form-input" placeholder="<?php esc_html_e( 'Find a product...', 'bigbox' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" />
	</div>

	<div class="navbar-search__submit">
		<button type="submit" aria-title="<?php esc_attr_e( 'Search', 'bigbox' ); ?>">
			<?php bigbox_svg( 'search' ); ?>
		</button>

		<input type="hidden" name="post_type" value="product" />
	</div>

</form>
