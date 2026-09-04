module.exports = {
    productionSourceMap: false,
    publicPath:
        process.env.NODE_ENV === 'production'
            ? '/views/conditional/pages/locations-page/modules/locations-map/dist/'
            : 'http://localhost:8080/',
    outputDir: '../../dist',
    configureWebpack: {
        devServer: {
            //contentBase: '/views/conditional/pages/locations-page/modules/locations-map/dist/',
            //static:"/",
            headers: {
                'Access-Control-Allow-Origin': '*',
            },
            //disableHostCheck: true,
        },
        externals: {
            jquery: 'jQuery',
        },
        output: {
            filename: 'js/[name].js',
            chunkFilename: 'js/[name].js',
        },
    },
    css: {
        extract: {
            filename: 'css/[name].css',
            chunkFilename: 'css/[name].css',
        },
    },
};
