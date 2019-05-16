let mix = require('laravel-mix'),
    buildDir = './assets/build',
    fs = require('fs');

mix.less('./assets/css/main.less', './assets/build/css').options({
    processCssUrls: false
});

mix.options({
    postCss: [
        require('autoprefixer')({
            browsers: ['last 2 versions'],
            cascade: false
        })
    ]
});

if (!mix.inProduction()) {
    mix.sourceMaps();
}
