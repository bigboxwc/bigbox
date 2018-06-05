<?php
/**
 * Products.
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

$accessories_name        = esc_attr__( 'Accessories', 'bigbox' );
$accessories_description = esc_attr__( 'A short category description', 'bigbox' );

$hoodies_name        = esc_attr__( 'Hoodies', 'bigbox' );
$hoodies_description = esc_attr__( 'A short category description', 'bigbox' );

$tshirts_name        = esc_attr__( 'Tshirts', 'bigbox' );
$tshirts_description = esc_attr__( 'A short category description', 'bigbox' );

return [
	'beanie'             => [
		'post_title'     => esc_attr__( 'Beanie', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{beanie-image}}',
		'product_data'   => [
			'regular_price' => '20',
			'price'         => '18',
			'sale_price'    => '18',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $accessories_name,
					'slug'        => 'accessories',
					'description' => $accessories_description,
				],
			],
		],
	],
	'belt'               => [
		'post_title'     => esc_attr__( 'Belt', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{belt-image}}',
		'product_data'   => [
			'regular_price' => '65',
			'price'         => '55',
			'sale_price'    => '55',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $accessories_name,
					'slug'        => 'accessories',
					'description' => $accessories_description,
				],
			],
		],
	],
	'cap'                => [
		'post_title'     => esc_attr__( 'Cap', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{cap-image}}',
		'product_data'   => [
			'regular_price' => '18',
			'price'         => '16',
			'sale_price'    => '16',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $accessories_name,
					'slug'        => 'accessories',
					'description' => $accessories_description,
				],
			],
		],
	],
	'sunglasses'         => [
		'post_title'     => esc_attr__( 'Sunglasses', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{sunglasses-image}}',
		'product_data'   => [
			'regular_price' => '90',
			'price'         => '90',
			'featured'      => true,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $accessories_name,
					'slug'        => 'accessories',
					'description' => $accessories_description,
				],
			],
		],
	],
	'hoodie-with-logo'   => [
		'post_title'     => esc_attr__( 'Hoodie with Logo', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{hoodie-with-logo-image}}',
		'product_data'   => [
			'regular_price' => '45',
			'price'         => '45',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $hoodies_name,
					'slug'        => 'hoodies',
					'description' => $hoodies_description,
				],
			],
		],
	],
	'hoodie-with-pocket' => [
		'post_title'     => esc_attr__( 'Hoodie with Pocket', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{hoodie-with-pocket-image}}',
		'product_data'   => [
			'regular_price' => '45',
			'price'         => '35',
			'sale_price'    => '35',
			'featured'      => true,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $hoodies_name,
					'slug'        => 'hoodies',
					'description' => $hoodies_description,
				],
			],
		],
	],
	'hoodie-with-zipper' => [
		'post_title'     => esc_attr__( 'Hoodie with Zipper', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{hoodie-with-zipper-image}}',
		'product_data'   => [
			'regular_price' => '45',
			'price'         => '45',
			'featured'      => true,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $hoodies_name,
					'slug'        => 'hoodies',
					'description' => $hoodies_description,
				],
			],
		],
	],
	'hoodie'             => [
		'post_title'     => esc_attr__( 'Hoodie', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{hoodie-image}}',
		'product_data'   => [
			'regular_price' => '45',
			'price'         => '42',
			'sale_price'    => '42',
			'featured'      => true,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $hoodies_name,
					'slug'        => 'hoodies',
					'description' => $hoodies_description,
				],
			],
		],
	],
	'long-sleeve-tee'    => [
		'post_title'     => esc_attr__( 'Long Sleeve Tee', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{long-sleeve-tee-image}}',
		'product_data'   => [
			'regular_price' => '25',
			'price'         => '25',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $tshirts_name,
					'slug'        => 'tshirts',
					'description' => $tshirts_description,
				],
			],
		],
	],
	'polo'               => [
		'post_title'     => esc_attr__( 'Polo', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{polo-image}}',
		'product_data'   => [
			'regular_price' => '20',
			'price'         => '20',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $tshirts_name,
					'slug'        => 'tshirts',
					'description' => $tshirts_description,
				],
			],
		],
	],
	'tshirt'             => [
		'post_title'     => esc_attr__( 'Tshirt', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{tshirt-image}}',
		'product_data'   => [
			'regular_price' => '18',
			'price'         => '18',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $tshirts_name,
					'slug'        => 'tshirts',
					'description' => $tshirts_description,
				],
			],
		],
	],
	'vneck-tee'          => [
		'post_title'     => esc_attr__( 'Vneck Tshirt', 'bigbox' ),
		'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
		'post_type'      => 'product',
		'comment_status' => 'open',
		'thumbnail'      => '{{vneck-tee-image}}',
		'product_data'   => [
			'regular_price' => '18',
			'price'         => '18',
			'featured'      => false,
		],
		'taxonomy'       => [
			'product_cat' => [
				[
					'term'        => $tshirts_name,
					'slug'        => 'tshirts',
					'description' => $tshirts_description,
				],
			],
		],
	],
];
