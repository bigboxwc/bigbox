/**
 * External dependencies
 */
const webpack = require( 'webpack' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const SpritePlugin = require( 'svg-sprite-loader/plugin' );

const themeCSS = new ExtractTextPlugin( {
	filename: './public/css/app.min.css',
} );

const nuxCSS = new ExtractTextPlugin( {
	filename: './public/css/nux.min.css',
} );

const editorCSS = new ExtractTextPlugin( {
	filename: './public/css/editor.min.css',
} );

const gutenbergCSS = new ExtractTextPlugin( {
	filename: './public/css/gutenberg.min.css',
} );

const customizeControlsCSS = new ExtractTextPlugin( {
	filename: './public/css/customize-controls.min.css',
} );

// Configuration for the ExtractTextPlugin.
const extractConfig = {
	use: [
		{
			loader: 'raw-loader',
		},
		{
			loader: 'postcss-loader',
			options: {
				plugins: [
					require( 'autoprefixer' ),
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
};

const config = {
	mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
	entry: {
		app: './resources/assets/js',
		lazyload: './resources/assets/js/app/lazyload.js', // Separate because it can be removed.
		woocommerce: './resources/assets/js/woocommerce',
		facetwp: './resources/assets/js/facetwp',
		'license-manager': './resources/assets/js/license-manager',
		'customize-preview': './resources/assets/js/customize/preview.js',
		'customize-controls': './resources/assets/js/customize/controls.js',
	},
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
				include: /icons/,
			},
			{
				test: /\.(png|jp(e*)g|svg)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							limit: 8000, // Convert images < 8kb to base64 strings
							name: '[name].[ext]',
							useRelativePath: true,
							outputPath: './public/',
						},
					},
				],
				exclude: /icons/,
			},
			{
				test: /.js$/,
				use: 'babel-loader',
				exclude: /node_modules/,
				include: /js/,
			},
			{
				test: /nux\.scss$/,
				use: nuxCSS.extract( extractConfig ),
				include: /scss/,
			},
			{
				test: /editor\.scss$/,
				use: editorCSS.extract( extractConfig ),
				include: /scss/,
			},
			{
				test: /gutenberg\.scss$/,
				use: gutenbergCSS.extract( extractConfig ),
				include: /scss/,
			},
			{
				test: /style\.scss$/,
				use: themeCSS.extract( extractConfig ),
				include: /scss/,
			},
			{
				test: /customize\-controls\.scss$/,
				use: customizeControlsCSS.extract( extractConfig ),
				include: /scss/,
			},
		],
	},
	externals: {
		jquery: 'jQuery',
		$: 'jQuery',
	},
	plugins: [
		themeCSS,
		nuxCSS,
		editorCSS,
		gutenbergCSS,
		customizeControlsCSS,
		new SpritePlugin(),
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

if ( config.mode !== 'production' ) {
	config.devtool = process.env.SOURCEMAP || 'source-map';
}

module.exports = config;
