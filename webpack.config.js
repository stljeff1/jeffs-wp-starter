
const NODE_ENV = process.env.NODE_ENV || 'development';
const path = require('path');

module.exports = {
    mode: NODE_ENV,

    // entry is the source script
    // entry: {
    //     //'blocks': './src/blocks.js',
        // 'main': './src/js/main.js',
    //     //'nf-extend': './src/js/nf-extend.js',
    //     //'test': './src/test.js',
    //     //'admin-block-styles': './src/admin-block-styles.js'
    // },

    externals: {
        jquery: 'jQuery'
    },

    // output is where to write the built file
    // output: {
    //     path: path.resolve(__dirname, 'js/'),
    //     filename: '[name].js',
    // },
    output: {filename: 'main.js'},
    module: {
        rules: [
            {
                test: /.js$/,
                exclude: /node_modules/,
                    loader: 'babel-loader'
            }
        ],
    },
    plugins: [
    ],
    watch: false 
};