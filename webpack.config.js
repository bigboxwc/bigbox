/**
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
	devtool: 'source-map',
	mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
	entry: Object.assign(
		cssFiles.reduce( ( memo, name ) => {
			memo[ name ] = `./resources/assets/scss/${ name }.scss`;
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
					'css-loader',
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
						query: {
							outputStyle: 'production' === process.env.NODE_ENV ? 'compressed' : 'nested',
						},
					},
				],
				exclude: /node_modules/,
				include: /scss/,
			},
			{
				test: /.js$/,
				use: 'babel-loader',
				exclude: /node_modules/,
				include: /js/,
			},
		],
	},
	externals: {
		jquery: 'jQuery',
		$: 'jQuery',
		'@wordpress/element': 'wp.element',
	},
	plugins: [
		new SpritePlugin(),
		new CopyWebpackPlugin( [
			{
				from: 'resources/assets/images/icons',
				to: 'public/images/icons',
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
