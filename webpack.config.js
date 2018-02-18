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
      query: {
        outputStyle: 'production' === process.env.NODE_ENV ? 'compressed' : 'nested',
      },
		},
	],
};

const themeCSS = new ExtractTextPlugin( {
	filename: './public/css/app.min.css',
} );

const nuxCSS = new ExtractTextPlugin( {
	filename: './public/css/nux.min.css',
} );

const config = {
  entry: {
    app: './resources/assets/js/app.js',
    nux: './resources/assets/js/nux',
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
        test: /\.(png|jp(e*)g|svg)$/,  
        use: [
          {
            loader: 'file-loader',
            options: { 
              limit: 8000, // Convert images < 8kb to base64 strings
              name: '[name].[ext]',
              useRelativePath: true,
              outputPath: './public/images/',
            } 
          }
        ],
				include: /images/,
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
				test: /.s?css$/,
				use: themeCSS.extract( extractConfig ),
				include: /scss/,
        exclude: /nux\.scss$/
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
		nuxCSS,
		themeCSS,
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

switch ( process.env.NODE_ENV ) {
	case 'production':
		config.plugins.push( new webpack.optimize.UglifyJsPlugin() );
		break;

	default:
		config.devtool = 'source-map';
}

module.exports = config;
