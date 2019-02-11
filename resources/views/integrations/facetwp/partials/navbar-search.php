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

$dropdown_facet = FWP()->helper->get_facet_by_name( bigbox_get_navbar_search_source( 'dropdown', 'categories' ) );
$search_facet   = FWP()->helper->get_facet_by_name( bigbox_get_navbar_search_source( 'search', 'keyword' ) );

if (
	! ( $search_facet || $dropdown_facet ) ||
	(
		! in_array( $search_facet['type'], bigbox_facetwp_get_search_whitelist(), true ) &&
		! in_array( $dropdown_facet['type'], bigbox_facetwp_get_dropdown_whitelist(), true )
	)
) :
	return;
endif;
?>

<form id="<?php echo esc_attr( bigbox_is_shop() ? 'facetwp-' : '' ); ?>primary-search" action="<?php echo esc_url( $form_url ); ?>" method="GET" class="navbar-search" role="search">

	<?php
	$search_taxonomy = get_taxonomy( str_replace( 'tax/', '', $dropdown_facet['source'] ) );

	if ( $search_taxonomy && in_array( $dropdown_facet['type'], bigbox_facetwp_get_dropdown_whitelist(), true ) ) :
		$name = FWP()->helper->get_setting( 'prefix' ) . $dropdown_facet['name'];
		$all  = esc_html( isset( $dropdown['label_any'] ) ? $dropdown_facet['label_any'] : __( 'All', 'bigbox' ) );
		?>

	<div id="navbar-search__category" class="navbar-search__category">
		<label for="<?php echo esc_attr( $name ); ?>" class="screen-reader-text">
			<?php echo esc_html( $dropdown_facet['label'] ); ?>:
		</label>

		<div id="search-dropdown-real">
		<?php
		if ( bigbox_is_shop() && ! is_customize_preview() ) :
			echo facetwp_display( 'facet', $dropdown_facet['name'] ); // WPCS: XSS okay.
		else :
			$navbar_search_dropdown = [
				'show_option_all' => $all,
				'name'            => $name,
				'taxonomy'        => $search_taxonomy->name,
				'hierarchical'    => 'no' !== $dropdown_facet['hierarchical'],
				'value_field'     => 'slug',
				'show_count'      => true,
				'orderby'         => $dropdown_facet['orderby'],
				'order'           => 'ASC',
				'number'          => $dropdown_facet['count'],
			];

			wp_dropdown_categories(
				/**
				 * This filter is documented in app/integrations/template/global/navbar-search.php
				 *
				 * @since 1.0.0
				 *
				 * @param array $bigbox_navbar_search_dropdown wp_dropdown_categories() arguments.
				 */
				apply_filters( 'bigbox_navbar_search_dropdown', $navbar_search_dropdown )
			);
		endif;
		?>
		</div>

		<select id="search-dropdown-placeholder">
			<?php echo '<option>' . $all . '</option>'; // WPCS: XSS okay. ?>
		</select>
	</div>

		<?php
	endif;

	if ( $search_facet && in_array( $search_facet['type'], bigbox_facetwp_get_search_whitelist(), true ) ) :
		$name = FWP()->helper->get_setting( 'prefix' ) . $search_facet['name'];
		?>

	<div class="navbar-search__keywords">
		<label for="<?php echo esc_attr( $name ); ?>" class="screen-reader-text">
			<?php echo esc_html( $dropdown_facet['label'] ); ?>:
		</label>

		<?php
		if ( bigbox_is_shop() && ! is_customize_preview() ) :
			echo facetwp_display( 'facet', $search_facet['name'] ); // WPCS: XSS okay.
		else :
			?>
			<input type="search" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" class="form-input" placeholder="<?php echo esc_attr( $search_facet['placeholder'] ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" />
		<?php endif; ?>
	</div>

	<?php endif; ?>

	<div class="navbar-search__submit">
		<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'bigbox' ); ?>">
			<?php bigbox_svg( 'search' ); ?>
		</button>
	</div>

</form>
