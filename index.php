<?php

// require __DIR__ . '/vendor/autoload.php';

require 'app/config.php';
$requestUri = $_SERVER['REQUEST_URI'];
// Define routes and corresponding PHP files
$str = substr($requestUri, 1);

$urlComponents = explode("/", $str);

if (empty($urlComponents[0])) {
  $urlComponents[0] = "login";
}
$fileName = './app/' . $urlComponents[0] . '.php';
if (!file_exists($fileName)) {
  $fileName = './app/error404.php';
}
include_once($fileName);