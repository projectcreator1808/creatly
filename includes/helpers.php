<?php 

if (!function_exists('isDev')) {
    function isDev() {
        global $config;
        return isset($config['dev']);
    }
}

if (!function_exists('dump')) {
    function dump(...$vars) {
        echo '<pre>';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
    }
}

if (!function_exists('dd')) {
    function dd(...$vars) {
        dump(...$vars);
        die;
    }
}