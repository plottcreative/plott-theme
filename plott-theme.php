<?php

/*
Plugin Name: plott/plotttheme
Plugin URL: https://plott.co.uk
Description: Foundation of the PLOTT Os theme.
Version: 1.0.9
Author: Ashley Armstrong
Author URI: https://www.ashley-armstrong.com
Domain Path: /resources/lang
Text Domain: plott.plotttheme
*/

spl_autoload_register(function ($class) {
    $prefix = 'Plott\\';

    $base_dir = __DIR__ . '/src';

    $len =  strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
