<?php
require 'vendor/autoload.php';//yeah, we need autoload for this

use Dotenv\Dotenv;
use Src\System\DatabaseConnector;

$dotenv = Dotenv::createImmutable(__DIR__);//Create a new immutable dotenv instance with default repository
$dotenv->load();//loads all .env variables into the $_ENV superglobal, from where they will be available to us



$dbConnection = new DatabaseConnector();
// var_dump($dbConnection); die;
$t = 10;
$dbConnection = $dbConnection->getConnection();
