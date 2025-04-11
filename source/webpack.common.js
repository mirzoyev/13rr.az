const path = require('path');
const webpack = require('webpack');

module.exports = {
    entry: './scripts/index.js',
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, '../assets/'),
        publicPath: '/assets/'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    },
    plugins: [
        new webpack.EnvironmentPlugin({
            'process.env.NODE_ENV': 'development'
        })
    ]
};
