<?php
require 'vendor/autoload.php';
require 'connection.php';

error_reporting(E_ALL);

$connection = Connection::getConnection();

$app = new \Slim\Slim();

$app->get('/', function() {
    echo "Welcome to the PokemonDB backend!";
});

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->run();