module.exports = {
	parser: 'babel-eslint',
	env: {
		es6: true,
		browser: true,
		node: true,
		jquery: true,
		amd: true,
		es2021: true,
	},
	parserOptions: {
		ecmaFeatures: {
			'jsx': true
		},
		ecmaVersion: 12,
		sourceType: 'module'
	},
	extends: [
		'wordpress',
		'eslint:recommended'
	],
	ignorePatterns: [
		'node_modules/*',
		'assets',
		'**/*.min.js'
	],
	plugins: [
		'react'
	],
	rules: {
		'react/react-in-jsx-scope': 0,
		'jsdoc/require-param': 0,
		'no-console': 1,
		'camelcase': 0,
		'no-unused-vars': 1,
		'comma-dangle': 0,
		'linebreak-style': [ 'error', ( 'win32' === process.platform ? 'windows' : 'unix' ) ],
	},
	globals: {
		wp: true,
		jQuery: true,
		dp: true,
	}
};
