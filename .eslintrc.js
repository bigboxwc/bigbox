module.exports = {
	root: true,
	extends: [
		'./eslint/config.js',
	],
	globals: {
		wpApiSettings: true,
		bigbox: true,
		BigBoxLicenseManager: true,
	},
};