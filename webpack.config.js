/**
 * WordPress dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );/**

 * External dependencies
 */
const webpack = require( 'webpack' );
const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const SpritePlugin = require( 'svg-sprite-loader/plugin' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );

const cssFiles = [
	'app',
	'nux',
	'gutenberg',
	'customize-controls',
	'facetwp',
	'woocommerce-bookings',
	'woocommerce-brands',
	'woocommerce-product-vendors',
];

const config = {
	...defaultConfig,
	devtool: 'source-map',
	mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
	entry: Object.assign(
		cssFiles.reduce( ( memo, name ) => {
			memo[ `${ name }-css` ] = `./resources/assets/scss/${ name }.scss`;
			return memo;
		}, {} ),
		{
			app: './resources/assets/js',
			lazyload: './resources/assets/js/app/lazyload.js', // Separate because it can be removed.
			'skip-link-focus-fix': './resources/assets/js/app/skip-link-focus-fix.js', // Source is manually inlined.
			woocommerce: './resources/assets/js/woocommerce',
			facetwp: './resources/assets/js/facetwp',
			'license-manager': './resources/assets/js/license-manager',
			'customize-preview': './resources/assets/js/customize/preview.js',
			'customize-controls': './resources/assets/js/customize/controls.js',
		},
	),
	output: {
		filename: 'public/js/[name].min.js',
		path: __dirname,
	},
	module: {
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.svg$/,
				use: [
					{
						loader: 'svg-sprite-loader',
						options: {
							extract: true,
							spriteFilename: './public/images/sprite.svg',
						},
					},
					'svgo-loader',
				],
			},
			{
				test: /\.(png|jp(e*)g)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							limit: 8000, // Convert images < 8kb to base64 strings
							name: '[name].[ext]',
							outputPath: ( url, resourcePath, context ) => {
								return `./public/${ path.relative( context, resourcePath ).replace( 'resources/assets', '' ) }`;
							},
						},
					},
				],
			},
			{
				test: /\.(scss|css)$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							url: false,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							plugins: [
								require( 'autoprefixer' ),
								require( 'postcss-focus-within' ),
							],
						},
					},
					{
						loader: 'sass-loader',
					},
				],
				exclude: /node_modules/,
				include: /scss/,
			},
		],
	},
	externals: {
		jquery: 'jQuery',
		$: 'jQuery',
		'@wordpress/element': 'wp.element',
		simplebar: 'window.SimpleBar',
	},
	plugins: [
		new SpritePlugin(),
		new CopyWebpackPlugin( [
			{
				from: 'resources/assets/images/icons',
				to: 'public/images/icons',
			},
			{
				from: './node_modules/simplebar/dist/simplebar.min.js',
				to: 'public/js/simplebar.min.js',
			},
		] ),
		new MiniCssExtractPlugin( {
			filename: './public/css/[name].min.css',
		} ),
		new FixStyleOnlyEntriesPlugin(),
		new webpack.ProvidePlugin( {
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
		} ),
		new WebpackRTLPlugin( {
			suffix: '-rtl',
			minify: process.env.NODE_ENV === 'production' ? { safe: true } : false,
		} ),
	],
};

module.exports = config;
