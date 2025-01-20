// Set theme dir
const themeDir = './';
const proxyUrl = 'http://leitura.local';

module.exports = {
  cssnano: {
    "preset": [
      "cssnano-preset-advanced",
      {
        "discardComments": {
          "removeAll": true
        }
      }
    ],
  },
  size: {
    gzip: true,
    uncompressed: true,
    pretty: true,
    showFiles: true,
    showTotal: false,
  },
  rename: {
    min: {
      suffix: '.min'
    }
  },
  browsersync: {
    src: [
      themeDir + '**/*.php',
      themeDir + 'css/**/*',
      themeDir + 'js/dev/**/*'
    ],
    opts: {
      logLevel: 'debug',
      injectChanges: true,
      proxy: proxyUrl,
      browser: 'Vivaldi',
      open: false,
      notify: true,
      // Generate with: mkdir -p ../../../certs && cd ../../../certs && mkcert localhost 192.168.x.xxx ::1
      // https: {
      //   key: "../../../certs/localhost-key.pem",
      //   cert: "../../../certs/localhost.pem",
      // }
    },
  },
  styles: {
    src: themeDir + 'sass/*.scss',
    development: themeDir + 'css/dev/',
    production: themeDir + 'css/prod/',
    watch: {
      development: themeDir + 'sass/**/*.scss',
      production: themeDir + 'css/dev/*.css',
    },
    stylelint: {
      src: themeDir + 'sass/**/*.scss',
      opts: {
        fix: false,
        reporters: [{
          formatter: 'string',
          console: true,
          failAfterError: false,
          debug: false
        }]
      },
    },
    opts: {
      development: {
        verbose: true,
        bundleExec: false,
        outputStyle: 'expanded',
        debugInfo: true,
        errLogToConsole: true,
        includePaths: [themeDir + 'node_modules/'],
        quietDeps: true,
      },
      production: {
        verbose: false,
        bundleExec: false,
        outputStyle: 'compressed',
        debugInfo: false,
        errLogToConsole: false,
        includePaths: [themeDir + 'node_modules/'],
        quietDeps: true,
      }
    }
  },
  js: {
    src: themeDir + 'js/src/*.js',
    watch: themeDir + 'js/src/**/*',
    production: themeDir + 'js/prod/',
    development: themeDir + 'js/dev/',
  },
  php: {
    watch: [
      themeDir + '*.php',
      themeDir + 'inc/**/*.php',
      themeDir + 'template-parts/**/*.php'
    ]
  },
  phpcs: {
    src: [`"${themeDir}**/*.php"`, `!"${themeDir}node_modules/**/*"`, `!"${themeDir}vendor/**/*"`],
    opts: {
      bin: 'phpcs', // Usando o caminho global configurado
      standard: `"${themeDir}phpcs.xml"`,
      warningSeverity: 0,
    }
  }
};
