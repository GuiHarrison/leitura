// Dependencies
const { watch, series } = require('gulp');
const bs = require('browser-sync').create();
const config = require('../config.js');
const { handleError } = require('../helpers/handle-errors.js');

// Watch task
function watchFiles(done) {

  // Init BrowserSync
  bs.init(config.browsersync.src, config.browsersync.opts);

  // Console info
  function consoleInfo(path) {
    console.log(`\x1b[37m[\x1b[35mfileinfo\x1b[37m] \x1b[37mFile \x1b[34m${path} \x1b[37mwas changed.\x1b[0m`);
  }

  // Styles in development environment
  const devstyles = watch(config.styles.watch.development, series('devstyles', 'lintstyles')).on('error', handleError());
  devstyles.on('change', function (path) {
    consoleInfo(path);
  });

  // Styles in production environment
  const prodstyles = watch(config.styles.watch.production, series('prodstyles'));
  prodstyles.on('change', function (path) {
    consoleInfo(path);
  });

  // JavaScript
  const javascript = watch(config.js.watch, series('js'));
  javascript.on('change', function (path) {
    consoleInfo(path);
    bs.reload(); // Recarrega o BrowserSync após mudanças no JavaScript
  });

  // PHP
  const php = watch(config.php.watch, series('phpcs'));
  php.on('change', function (path) {
    consoleInfo(path);
    bs.reload(); // Recarrega o BrowserSync após mudanças no PHP
  });

  // Lint styles
  watch(config.styles.watch.development, series('lintstyles'));

  // Finish task
  done();
};

exports.watch = watchFiles;
