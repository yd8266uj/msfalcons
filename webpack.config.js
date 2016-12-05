/**
 * Created by Nick on 12/2/2016.
 */

module.exports = {
    entry: './src/js',
    output: {
        filename: '[name].js',
        path: __dirname + './www/js'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel',
                query: {
                    presets: ['es2015']
                }
            }
        ]
    }
}