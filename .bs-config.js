module.exports = {
    proxy: 'localhost:8000',
    files: [
        'src/**/*.php',
        'src/**/*.css',
        'src/**/*.js',
        'controllers/**/*.php',
        'models/**/*.php',
        'views/**/*.php',
        'templates/**/*.tpl',
        'classes/**/*.php',
        'locales/**/*.txt',
        'css/**/*.cs',
        'js/**/*.cs',
    ],
    open: true,
    notify: true,
    /*
    watchOptions: {
      usePolling: true,
      interval: 500
    }*/
};
