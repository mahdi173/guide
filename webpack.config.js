var Encore = require('@symfony/webpack-encore');
const ConcatPlugin = require('webpack-concat-plugin');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}
const scripts = [


    './assets/js/pages/author.js',
];


Encore

    .setOutputPath('public/build/website/')
    .setPublicPath('/build/website')
    .addEntry('app', './assets/js/app.js')
    .addEntry('consent', './assets/js/pages/cookie-consent.js')

    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')
    .addEntry('pages-author', ['./assets/js/pages/author.js'])
    .addStyleEntry('consentcss', './assets/website/css/cookie-consent.css')
    .disableSingleRuntimeChunk()
    .addEntry('register', './assets/website/scss/register.scss')

    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')
    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()




;


module.exports = Encore.getWebpackConfig();
