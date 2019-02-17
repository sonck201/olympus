const mix = require( 'laravel-mix' );

var assetFrom = 'resources/assets/';
var assetTo = 'public/templates/';

// template
var adminTemplate = 'admin_wargon/';
var webTemplate = 'web_olympus/';

// admin
var adminFromCss = assetFrom + 'admin/css/';
var adminToCss = assetTo+ adminTemplate + 'css/';

var adminFromJs = assetFrom + 'admin/js/';
var adminToJs = assetTo + adminTemplate + 'js/';

// Web
var webFromCss = assetFrom + 'web/css/';
var webToCss = assetTo+ webTemplate + 'css/';

var webFromJs = assetFrom + 'web/js/';
var webToJs = assetTo + webTemplate + 'js/';



/**
 * Admin task
 */
// CSS
//mix.styles( adminFromCss + 'style.css', adminToCss + 'style.css' );

// JS
//mix.scripts( adminFromJs + 'core.js', adminToJs + 'core.js' )
//.scripts( adminFromJs + 'login.js', adminToJs + 'login.js' )
//.scripts( adminFromJs + 'menu.js', adminToJs + 'menu.js' )
//.scripts( adminFromJs + 'post.js', adminToJs + 'post.js' )
//.scripts( adminFromJs + 'widget.js', adminToJs + 'widget.js' );

/**
 * Web task
 */
// CSS
mix.styles( [webFromCss + 'default.css', webFromCss + 'owl.carousel.css', webFromCss + 'yamm.css', webFromCss + 'style.css'], webToCss + 'style.css' );

// JS
mix.scripts( [webFromJs + 'waypoints.min.js', webFromJs + 'jquery.counterup.js', webFromJs + 'owl.carousel.js', webFromJs + 'jquery.elevatezoom.js', webFromJs + 'theme.js'], webToJs + 'core.js' );

// Disabled notifications
mix.disableNotifications();