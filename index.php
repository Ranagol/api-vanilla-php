<?php

/**
 * Reminder: yoh have to run this app with php server where the index.php file is.
 * And that is in the public folder. So we do
 *  php -S localhost:8889
 * 
 * from here: D:\_CODE\api-vanilla-php\public>
 * Tutorial source: https://developer.okta.com/blog/2019/03/08/simple-rest-api-php
 * with this line blow we activate dotenv, a PDO connection and composer autoload in boostrap.php
 */
require "./bootstrap.php";

use Src\PersonController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );// The explode() function breaks a string into an array

/**
 * all of our endpoints start with /person, everything else results in a 404 Not Found
 * So, this is the way how we generate 404 error, if the user types an unvalid url 
 */
if ($uri[1] !== 'person') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the user id is, of course, optional and must be a number:
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

//we get the request method here
$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and user ID to the PersonController and process the HTTP request:
$controller = new PersonController($dbConnection, $requestMethod, $userId);
$controller->processRequest();