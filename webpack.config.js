const glob = require( 'glob' );
const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const StylelintPlugin = require( 'stylelint-webpack-plugin' );

module.exports = ( env, argv ) => {
	const {mode} = argv;

	return {
		entry: {
			main: path.resolve( __dirname, './app/view/index.js' ),
			block: path.resolve( __dirname, './app/domains/gutenberg_block/block.js' )
		},
		output: {
			path: path.resolve( __dirname, './app/assets/js/' ),
			filename: '[name].min.js'
		}, module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /node_modules/,
					use: [
						{
							loader: 'babel-loader',
							options: {
								plugins: [ '@babel/plugin-proposal-class-properties' ],
								presets: [
									'@babel/preset-env',
									[
										'@babel/preset-react',
										{
											'pragma': 'wp.element.createElement',
											'pragmaFrag': 'wp.element.Fragment',
											'development': 'development' === argv.mode,
										}
									]
								],
							},
						},
						'eslint-loader',
					]
				},
				{
					test: /\.(s?css)$/i,
					use: [

						// load extract css to individual files. To not compile everything into single file
						{
							loader: MiniCssExtractPlugin.loader
						},

						// load css
						{
							loader: 'css-loader',
							options: {
								url: false
							}
						},

						// compile scss to css
						{
							loader: 'postcss-loader'
						},

						// load scss
						{
							loader: 'sass-loader'
						}
					],
					exclude: /node_modules/
				},
			]
		},
		watchOptions: {
			ignored: [ '**/node_modules', '**/vendor' ]
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: '../css/style.css',
			}),
			new StylelintPlugin({
				files: '**/app/view/*.scss',
				failOnError: false,
			})
		],
		devtool: 'production' === mode ? false : 'source-map',
		resolve: {
			extensions: [ '*', '.js' ]
		},
	};
};
