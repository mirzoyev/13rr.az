const common = require('./webpack.common.js');
const {merge} = require('webpack-merge');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = merge(common, {
    mode: 'production',
    optimization: {
        minimizer: [new TerserPlugin({
            parallel: true,
            terserOptions: {
                ecma: 6,
            },
            extractComments: true
        })]
    }
});
