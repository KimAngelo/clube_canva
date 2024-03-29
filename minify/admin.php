<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * CSS
 */
$minCSS = new MatthiasMullie\Minify\CSS();
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/plugins/global/plugins.bundle.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/plugins/custom/prismjs/prismjs.bundle.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/css/style.bundle.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/css/themes/layout/header/base/light.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/css/themes/layout/header/menu/light.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/css/themes/layout/brand/dark.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/css/themes/layout/aside/dark.css");

$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/custom/animate/animate.min.css");
$minCSS->add(__DIR__ . "/../shared/assets/css/animate.css");

//Minify CSS
$minCSS->minify(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/style.css");


/**
 * JS
 */
$minJS = new MatthiasMullie\Minify\JS();
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/plugins/global/plugins.bundle.js");
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/plugins/custom/prismjs/prismjs.bundle.js");
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/js/scripts.bundle.js");
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/js/custom.js");

//Minify JS
$minJS->minify(__DIR__ . "/../themes/" . CONF_VIEW_ADMIN . "/assets/scripts.js");