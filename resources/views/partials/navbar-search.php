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
		<input type="search" name="s" class="form-input" />
	</div>

	<div class="navbar-search__category">
		<label for="s" class="screen-reader-text"><?php esc_html_e( 'Choose a category:', 'bigbox' ); ?></label>
		<select>
			<option selected="selected">All</option>
		</select>
	</div>

	<div class="navbar-search__submit">
		<input type="submit" name="submit" value="<?php esc_attr_e( 'Search', 'bigbox' ); ?>" />
	</div>

</form>
