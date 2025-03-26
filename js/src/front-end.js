/* eslint-disable max-len, no-param-reassign, no-unused-vars */
/**
 * Air theme JavaScript.
 */

// Import modules
import reframe from 'reframe.js';
import 'owl.carousel';
import { styleExternalLinks, initExternalLinkLabels } from './modules/external-link';
import initAnchors from './modules/anchors';
import backToTop from './modules/top';
import initAccordions from './modules/accordion';
import initA11ySkipLink from './modules/a11y-skip-link';
import initA11yFocusSearchField from './modules/a11y-focus-search-field';
import {
  navSticky, navClick, navDesktop, navMobile,
} from './modules/navigation';
import { initStickyNav } from './modules/navigation/sticky-nav';
// import './modules/modal';

// Define Javascript is active by changing the body class
document.body.classList.remove('no-js');
document.body.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
  initAnchors();
  backToTop();
  styleExternalLinks();
  initExternalLinkLabels();
  initA11ySkipLink();
  initA11yFocusSearchField();
  initAccordions();

  // Init navigation
  // If you want to enable click based navigation, comment navDesktop() and uncomment navClick()
  // Remember to enable styles in sass/navigation/navigation.scss
  navDesktop();
  // navClick();
  navMobile();

  // Uncomment if you like to use a sticky navigation
  // navSticky();

  // Fit video embeds to container
  reframe('.wp-has-aspect-ratio iframe');

  initStickyNav();

  // Modal.init();
});
