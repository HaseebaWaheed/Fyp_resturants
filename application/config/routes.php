<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// homepage
$route['default_controller'] = 'home';
$route['home/login'] = 'home/login';

$route['404_override'] = 'home/error';
$route['translate_uri_dashes'] = FALSE;

