const path = require('path');
const fs = require('fs');
const concurrently = require('concurrently');

const configPath = path.resolve(__dirname, 'config.json');

if (!fs.existsSync(configPath)) {
    console.error('File config.json non trovato!');
    process.exit(1);
}

const config = JSON.parse(fs.readFileSync(configPath, 'utf8'));
const {PHP_BIN, PHP_INI_PATH, PORT} = config;

if (!PHP_BIN || !PHP_INI_PATH || !PORT) {
    console.error('Variabili mancanti in config.json');
    process.exit(1);
}

const phpCmd = `"${PHP_BIN}" -c "${PHP_INI_PATH}" -S localhost:${PORT} route.php`;
// const bsCmd = `npx browser-sync start --proxy "localhost:${PORT}" --files "public/**/*" "src/**/*" --no-ui --no-open`;
// const bsCmd = `npx browser-sync start --proxy "localhost:${PORT}" --files "**/*" --no-ui --open`;
const bsCmd = `npx browser-sync start --config .bs-config.js`;

concurrently([
    {command: phpCmd, name: 'php', prefixColor: 'blue'},
    {command: bsCmd, name: 'bs', prefixColor: 'magenta'}
], {
    killOthers: ['failure', 'success'],
    restartTries: 0
}).result.then(() => {
    console.log('Tutti i processi terminati con successo');
}).catch(err => {
    console.error('Errore in uno dei processi:', err);
});
