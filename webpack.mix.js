const mix = require('laravel-mix');

mix.webpackConfig({
    watchOptions: {
      ignored: /node_modules/
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

if (mix.inProduction()) {
    mix.version();
}

