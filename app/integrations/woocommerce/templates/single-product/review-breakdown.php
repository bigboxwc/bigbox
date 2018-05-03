<?php
/**
 * Review breakdown.
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

$count   = $product->get_review_count();
$average = $product->get_average_rating();

if ( 0 === $count ) {
	return;
}
?>

<h3>
<?php
// Translators: %1$s Star count.
echo esc_html( sprintf( __( '%1$s out of 5 stars', 'bigbox' ), str_replace( '.0', '', number_format( $average, 1 ) ) ) );
?>
</h3>

<div class="review-breakdown">
	<?php
	for ( $i = 1; $i <= 5; $i++ ) :
		$percent = round( ( $product->get_rating_count( $i ) / $count ) * 100 );
	?>
	<div class="review-breakdown__item">
		<div class="review-breakdown__label">
		<?php
		// Translators: %1$d Number of stars.
		echo esc_html( sprintf( _n( '%1$d Star', '%1$d Stars', $i, 'bigbox' ), $i ) );
		?>
		</div>

		<div class="review-breakdown__count" >
			<span class="review-breakdown__count-label"><?php echo esc_html( $percent ); ?>%</span>
			<span class="review-breakdown__count-bar" style="width: <?php echo esc_attr( $percent ); ?>%"></span>
		</div>
	</div>
	<?php endfor; ?>
</div>
