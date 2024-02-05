const mix = require('laravel-mix');
const path = require('path');


mix.js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    //
  ])
  .webpackConfig({
    resolve: {
      alias: {
        '@': path.resolve('resources/js'),
        '@fullcalendar/core': path.resolve('node_modules/@fullcalendar/core/main.js'),
        '@fullcalendar/daygrid': path.resolve('node_modules/@fullcalendar/daygrid/main.js'),
        '@fullcalendar/interaction': path.resolve('node_modules/@fullcalendar/interaction/main.js'),
        '@fullcalendar/vue3': path.resolve('node_modules/@fullcalendar/vue3/main.js'),
      },
    },
    module: {
      rules: [
        {
          test: /fullcalendar-vue3\.min\.js$/,
          loader: 'imports-loader',
          options: {
            type: 'commonjs',
            imports: ['lodash/debounce'],
          },
        },
      ],
    },
  });