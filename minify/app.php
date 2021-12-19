<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * CSS
 */
$minCSS = new MatthiasMullie\Minify\CSS();
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/global/plugins.bundle.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/custom/prismjs/prismjs.bundle.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/css/style.bundle.css");

$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/custom/animate/animate.min.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/custom/owlcarousel/assets/owl.carousel.min.css");
$minCSS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/custom/owlcarousel/assets/owl.theme.default.min.css");

//Minify CSS
$minCSS->minify(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/style.css");


/**
 * JS
 */
$minJS = new MatthiasMullie\Minify\JS();
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/global/plugins.bundle.js");
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/custom/prismjs/prismjs.bundle.js");
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/js/scripts.bundle.js");
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/plugins/custom/owlcarousel/owl.carousel.min.js");
$minJS->add(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/js/form.js");

//Minify JS
$minJS->minify(__DIR__ . "/../themes/" . CONF_VIEW_APP . "/assets/scripts.js");