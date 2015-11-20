<?php
require 'vendor/autoload.php';
require 'connection.php';
require 'sql.php';
require 'model/Trainer.php';

error_reporting(E_ALL);

$db = Connection::createConnection();

$app = new \Slim\Slim();

$app->get('/', function() {
    echo "Welcome to the PokemonDB backend!";
});

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->get('/trainers/', function() use ($app, $db) {
    $result = $db->query(SQL::allTrainers());
    $trainers = Trainer::getAll($result);
    echo json_encode($trainers);
});

$app->run();