<?php
/**
 * Advanced searching in the nav bar.
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

<form action="" method="GET" class="navbar-search">

	<div class="navbar-search__keywords">
		<label for="s" class="screen-reader-text"><?php esc_html_e( 'Find a product:', 'bigbox' ); ?></label>
		<input type="search" name="s" class="form-input" placeholder="<?php esc_html_e( 'Find a product...', 'bigbox' ); ?>" />
	</div>

	<div class="navbar-search__category">
		<label for="s" class="screen-reader-text"><?php esc_html_e( 'Choose a category:', 'bigbox' ); ?></label>

		<select>
			<option>All Categories</option>
			<option selected="selected">Home &amp; Grocery</option>
		</select>
	</div>

	<div class="navbar-search__submit">
		<button type="submit" name="submit" aria-title="<?php esc_attr_e( 'Search', 'bigbox' ); ?>">
			<?php bigbox_svg( 'search' ); ?>
		</button>

		<input type="hidden" name="post_type" value="product" />
	</div>

</form>
