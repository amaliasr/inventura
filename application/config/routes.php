<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Routing untuk URL dengan dua segmen dengan penggantian '-' menjadi '_'
$route['(:any)/(:any)'] = function ($controller, $method) {
    $controller = str_replace('-', '_', $controller);
    $method = str_replace('-', '_', $method);
    return $controller . '/' . $method;
};
