module.exports = {
  ignorePatterns: ['content/themes/leitura/js/dist/*.js', 'content/themes/leitura/node_modules/**/*.js', '**/gulp/**/*.js', '**/gulp/*.js', 'gulpfile.js'],
  parser: '@babel/eslint-parser',
  parserOptions: {
    requireConfigFile: false,
  },
  extends: 'eslint-config-airbnb/base',
  rules: {
    indent: [0, 'tab'],
    noTabs: 0,
  },
  env: {
    browser: true,
    jquery: true,
  },
};
