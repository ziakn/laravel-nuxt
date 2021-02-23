const mix = require('laravel-mix');


mix.webpackConfig({
    watchOptions: {
      ignored: /node_modules/
    },
    optimization: {
        minimize: true
      }
  })



mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .extract(['vue','vuetify','vue-moment'])
    .version()
    .vue();

// mix.styles([
//     'public/css/app.css',
//     'public/css/style.css'
// ], 'public/css/all.css');

if (mix.inProduction()) {
    mix.version();
}
