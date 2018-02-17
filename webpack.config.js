/**
 * External dependencies
 */
const webpack = require( 'webpack' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' ); // CSS loader for styles specific to block editing.
const SpritePlugin = require('svg-sprite-loader/plugin');

// Configuration for the ExtractTextPlugin.
const extractConfig = {
	use: [
		{ 
			loader: 'raw-loader' 
		},
		{
			loader: 'postcss-loader',
			options: {
				plugins: [
					require('autoprefixer'),
				],
			},
		},
		{
			loader: 'sass-loader',
		},
	],
};

const cssPlugin = new ExtractTextPlugin( {
	filename: './public/css/app.min.css',
} );

module.exports = {
  entry: {
    app: './resources/assets/js/app.js',
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
							spriteFilename: './public/images/sprite.svg'
						},
					},
					'svgo-loader'
				],
				include: /images/,
			},
			{
				test: /.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/,
				include: /js/,
			},
			{
				test: /.s?css$/,
				use: cssPlugin.extract( extractConfig ),
				include: /scss/,
			},
		],
	},
  externals: {
    jquery: 'jQuery',
  },
	plugins: [
		new webpack.DefinePlugin( {
			'process.env.NODE_ENV': JSON.stringify( process.env.NODE_ENV || 'development' ),
		} ),
		cssPlugin,
		new SpritePlugin(),
		new webpack.ProvidePlugin( {
			'$': 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
			Popper: ['popper.js', 'default'],
			'Util': "exports-loader?Util!bootstrap/js/dist/util"
		} ),
	],
};
