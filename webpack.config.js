/**
 * Created by Nick on 12/2/2016.
 */

module.exports = {
    entry: {
        app: ['./src/js/main.js']
        // app: ['./src/js/main.js', './src/js/wNumb.js']
    },
    output: {
        filename: 'app.bundle.js',
        path: './www/js'
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