<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Src\DatabaseConnector;

/**
 * The boostrap has three functions:
 * 1. activate the dotenv, so all the .env variables are available for our app 
 * 2. create a new PDO connection, that will be used to connect to the db.
 * 3. activates the composer autoload
 */
$dotenv = Dotenv::createImmutable(__DIR__);//Create a new immutable dotenv instance with default repository
$dotenv->load();//loads all .env variables into the $_ENV superglobal, from where they will be available to us

$dbConnection = new DatabaseConnector();
$dbConnection = $dbConnection->getConnection();
