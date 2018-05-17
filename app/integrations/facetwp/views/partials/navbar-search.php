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

$dropdown = FWP()->helper->get_facet_by_name( apply_filters( 'navbar_dropdown_facet_source', get_theme_mod( 'navbar-dropdown-source', 'category' ), get_post() ) );
$search   = FWP()->helper->get_facet_by_name( apply_filters( 'navbar_search_facet_source', get_theme_mod( 'navbar-search-source', 'keyword' ), get_post() ) );

if ( ! ( $search || $dropdown ) ) :
	return;
endif;
?>

<form id="<?php echo esc_attr( is_shop() ? 'facetwp-' : '' ); ?>primary-search" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" method="GET" class="navbar-search">

	<?php
	$taxonomy = get_taxonomy( str_replace( 'tax/', '', $dropdown['source'] ) );

	if ( $taxonomy ) :
		$name = FWP()->helper->get_setting( 'prefix' ) . $dropdown['name'];
		$all  = esc_html( isset( $dropdown['label_any'] ) ? $dropdown['label_any'] : esc_html__( 'All', 'bigbox' ) );
	?>

	<div id="navbar-search__category" class="navbar-search__category">
		<label for="<?php echo esc_attr( $name ); ?>" class="screen-reader-text">
			<?php echo esc_html( $dropdown['label'] ); ?>:
		</label>

		<div id="search-dropdown-real">
		<?php
		if ( bigbox_is_shop() && ! is_customize_preview() ) :
			echo facetwp_display( 'facet', $dropdown['name'] ); // WPCS: XSS okay.
		else :
			wp_dropdown_categories(
				apply_filters(
					'bigbox_navbar_search_dropdown', [
						'show_option_all'   => false,
						'show_option_none'  => $all,
						'option_none_value' => '',
						'name'              => $name,
						'taxonomy'          => $taxonomy->name,
						'hierarchical'      => 'no' !== $dropdown['hierarchical'],
						'value_field'       => 'slug',
						'show_count'        => true,
						'orderby'           => $dropdown['orderby'],
						'order'             => 'ASC',
						'number'            => $dropdown['count'],
					]
				)
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

	if ( $search ) :
		$name = FWP()->helper->get_setting( 'prefix' ) . $search['name'];
	?>

	<div class="navbar-search__keywords">
		<label for="<?php echo esc_attr( $name ); ?>" class="screen-reader-text">
			<?php echo esc_html( $dropdown['label'] ); ?>:
		</label>

		<?php
		if ( bigbox_is_shop() && ! is_customize_preview() ) :
			echo facetwp_display( 'facet', $search['name'] ); // WPCS: XSS okay.
		else :
		?>
			<input type="search" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" class="form-input" placeholder="<?php echo esc_attr( $search['placeholder'] ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" />
		<?php endif; ?>
	</div>

	<?php endif; ?>

	<div class="navbar-search__submit">
		<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'bigbox' ); ?>">
			<?php bigbox_svg( 'search' ); ?>
		</button>
	</div>

</form>
