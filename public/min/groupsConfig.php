<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

$static_path = dirname(__DIR__). "/static/";
$core_path   = $static_path. "oneui/js/core/";
$oneui_path   = $static_path. "oneui/";
$admin_path  = $static_path. "admin/js/";

return [
    'core_js' => [ // 默认加载
        $core_path. "jquery.min.js",
        $core_path. "bootstrap.min.js",
        $core_path. "jquery.slimscroll.min.js",
        $core_path. "jquery.scrollLock.min.js",
        $core_path. "jquery.appear.min.js",
        $core_path. "jquery.countTo.min.js",
        $core_path. "jquery.placeholder.min.js",
        $core_path. "js.cookie.min.js",
        $oneui_path. "js/app.js",       
        $admin_path. "rain_admin.js",
    ],
    'base_js' => [ // 默认加载
        $core_path. "jquery.min.js",
        $core_path. "bootstrap.min.js",
        $core_path. "jquery.slimscroll.min.js",
        $core_path. "jquery.scrollLock.min.js",
        $core_path. "jquery.appear.min.js",
        $core_path. "jquery.countTo.min.js",
        $core_path. "jquery.placeholder.min.js",
        $core_path. "js.cookie.min.js",
        $oneui_path. "js/app.js",
    ],

];