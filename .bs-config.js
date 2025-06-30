const config = require('./config.json'); // carica la porta dal file JSON

module.exports = {
    proxy: `localhost:${config.PORT}`,
    files: [
        './**/*.php',
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
        'config/**/*.php',

    ],
    open: true,
    notify: true,
    /*
    watchOptions: {
      usePolling: true,
      interval: 500
    }*/
};
