// Dependencies
const { dest, src } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const calcFunction = require('postcss-calc');
const colormin = require('postcss-colormin');
const discardEmpty = require('postcss-discard-empty');
const mergeLonghand = require('postcss-merge-longhand');
const mergeAdjacentRules = require('postcss-merge-rules');
const minifyGradients = require('postcss-minify-gradients');
const normalizePositions = require('postcss-normalize-positions');
const normalizeUrl = require('postcss-normalize-url');
const uniqueSelectors = require('postcss-unique-selectors');
const zIndex = require('postcss-zindex');
const size = require('gulp-size');
// const cleanCSS = require('gulp-clean-css');
const config = require('../config.js');

function prodstyles() {
  return src(config.styles.src)

    // Compile SCSS synchronously
    .pipe(sass.sync(config.styles.opts.production)).on('error', sass.logError)

    // Run PostCSS plugins
    .pipe(postcss([
      autoprefixer(),
      colormin(),
      calcFunction(),
      discardEmpty(),
      mergeLonghand(),
      mergeAdjacentRules(),
      minifyGradients(),
      normalizePositions(),
      normalizeUrl(),
      uniqueSelectors(),
      zIndex(),
      cssnano(config.cssnano)
    ]))

    // Output production CSS size
    .pipe(size(config.size))

    // Save the final version for production
    .pipe(dest(config.styles.production));
}

exports.prodstyles = prodstyles;
