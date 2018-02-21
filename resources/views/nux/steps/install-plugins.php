<?php
/**
 * Install recommended plugins.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$plugins = [
	'facetwp'  => [
		'label' => 'FacetWP',
		'buy'   => 'https://facetwp.com/buy/',
		'more'  => 'https://facetwp.com',
		'info'  => 'Users find what they&#39;re looking for faster. This leads to happier customers and increased sales.',
	],
	'searchwp' => [
		'label' => 'SearchWP',
		'buy'   => 'https://searchwp.com/buy/',
		'more'  => 'https://searchwp.com',
		'info'  => 'Search your product details, Custom Fields content, Shortcode output, and more!',
	],
];
?>

<p><?php echo wp_kses_post( 'Below is a list of recommended plugins to help optimize your WooCommerce website. You can read about theses suggestions and find more great information <a href="https://bigboxwc.com/blog">on our blog</a>.', 'bigbox' ); ?></p>

<div class="plugin-list">
	<?php
	foreach ( $plugins as $slug => $data ) :
		$i18n = [
			// Translators: %s Plugin name.
			'get'  => sprintf( __( 'Get %s', 'bigbox' ), $data['label'] ),
			// Translators: %s Plugin name.
			'more' => sprintf( __( 'More information about %s', 'bigbox' ), $data['label'] ),
		];
	?>

	<div class="plugin-card">
		<div class="plugin-card-top">
			<div class="name column-name">
				<h3>
					<a href="<?php echo esc_url( $data['more'] ); ?>">
						<?php echo esc_html( $data['label'] ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/public/images/nux/<?php echo esc_attr( $slug ); ?>.png" class="plugin-icon" alt="" />
					</a>
				</h3>
			</div>

			<div class="action-links">
				<ul class="plugin-action-buttons">
					<li>
						<a class="button" href="<?php echo esc_url( $data['buy'] ); ?>" aria-label="<?php esc_attr( $i18n['get'] ); ?>">
							<?php echo esc_html( $i18n['get'] ); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( $data['more'] ); ?>" aria-label="<?php esc_attr( $i18n['more'] ); ?>">
							<?php esc_html_e( 'More Details', 'bigbox' ); ?>
						</a>
					</li>
				</ul>
			</div>

			<div class="desc column-description">
				<p><?php echo esc_html( $data['info'] ); ?></p>
			</div>
		</div>
	</div>

	<?php endforeach; ?>

</div>

<div class="nux-panel-cta">
	<a href="https://bigboxwc.com/blog/" class="button button-primary button-large"><?php esc_html_e( 'Read More on the Blog', 'bigbox' ); ?></a>
</div>
