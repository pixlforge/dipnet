const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css');

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css')
//    .browserSync({
//      proxy: process.env.APP_URL
//    });


// mix.js('resources/assets/js/app.js', 'public/js')
//   .sass('resources/assets/sass/app.scss', 'public/css')
//   .browserSync({
//     proxy: process.env.APP_URL
//   })
//   .version();