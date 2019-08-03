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

/**
 * Filters the URL the search form is sent to.
 *
 * @since 1.0.0
 *
 * @param string $url The URL to send to.
 */
$form_url = apply_filters( 'bigbox_navbar_search_form_url', wc_get_page_permalink( 'shop' ) );
?>

<form id="primary-search" action="<?php echo esc_url( $form_url ); ?>" method="GET" class="navbar-search" role="search">

	<?php
	$search_taxonomy = get_taxonomy( bigbox_get_navbar_search_source( 'dropdown', 'product_cat' ) );

	if ( $search_taxonomy ) :
		$selected = isset( $_GET[ $search_taxonomy->name ] ) ? esc_attr( $_GET[ $search_taxonomy->name ] ) : null; // @codingStandardsIgnoreLine

		/* translators: %s Header dropdown "All" label. */
		$all = esc_html( sprintf( __( 'All %s', 'bigbox' ), strtolower( $search_taxonomy->labels->name ) ) );
		?>

	<div id="navbar-search__category" class="navbar-search__category">
		<label for="<?php echo esc_attr( $search_taxonomy->name ); ?>" class="screen-reader-text">
			<?php
			/* translators: %s Header dropdown search_taxonomy name. */
			echo esc_html( sprintf( __( 'Choose a %s', 'bigbox' ), strtolower( $search_taxonomy->labels->singular_name ) ) );
			?>
			:
		</label>

		<div id="search-dropdown-real">
			<?php
			$navbar_search_dropdown = [
				'show_option_all' => $all,
				'selected'        => $selected,
				'name'            => $search_taxonomy->name,
				'taxonomy'        => $search_taxonomy->name,
				'hierarchical'    => true,
				'value_field'     => 'slug',
				'show_count'      => true,
				'orderby'         => 'name',
				'order'           => 'ASC',
				'hide_empty'      => false,
			];

			wp_dropdown_categories(
				/**
				 * Filters the output of wp_dropdown_categories() in the navbar.
				 *
				 * @since 1.0.0
				 *
				 * @param array $args The arguments used in wp_dropdown_categories().
				 */
				apply_filters( 'bigbox_navbar_search_dropdown', $navbar_search_dropdown )
			);
			?>
		</div>

		<select id="search-dropdown-placeholder">
			<?php echo '<option>' . ( $selected ? $selected : $all ) . '</option>'; // WPCS: XSS okay. ?>
		</select>
	</div>

	<?php endif; ?>

	<div class="navbar-search__keywords">
		<label for="s" class="screen-reader-text"><?php esc_html_e( 'Find a product:', 'bigbox' ); ?></label>
		<input type="search" id="s" name="s" class="form-input" value="<?php echo esc_attr( get_search_query() ); ?>" />
	</div>

	<div class="navbar-search__submit">
		<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'bigbox' ); ?>">
			<?php bigbox_svg( 'search' ); ?>
		</button>

		<input type="hidden" name="post_type" value="product" />
	</div>

</form>
