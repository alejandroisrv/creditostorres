const mix = require('laravel-mix');

mix.js(['resources/js/app.js'], 'public/js/app.js')
.sass('resources/sass/app.scss', 'public/css/app.css')
.browserSync({
    open: 'external',
 host: 'localhost:8000',
 proxy: 'localhost:8000',
 files: ['resources/views/**/*.php', 'app/**/*.php', 'routes/**/*.php', 'public/js/*.js', 'public/css/*.css']
});

mix.version();