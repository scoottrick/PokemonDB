<?php
require 'vendor/autoload.php';
require 'connection.php';
require 'sql.php';
require 'model/Pokemon.php';
require 'model/Trainer.php';
require 'model/Type.php';
require 'model/Badge.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$db = Connection::createConnection();

$app = new \Slim\Slim();

$app->get('/', function() {
    echo "Welcome to the PokemonDB backend!";
});

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->get("/pokemon", function() use ($app, $db) {
    $result = $db->query(SQL::allPokemon());
    $pokemon = Pokemon::getAll($result);
    echo json_encode($pokemon);
});

$app->get("/pokemon/:id", function($id) use ($app, $db) {
    $result = $db->query(SQL::pokemonById($id));
    $pokemon = Pokemon::getById($result);
    echo (json_encode($pokemon));
});

$app->get('/trainers', function() use ($app, $db) {
    $result = $db->query(SQL::allTrainers());
    $trainers = Trainer::getAll($result);
    echo json_encode($trainers);
});

$app->get('/trainers/:id', function($id) use ($app, $db) {
    $result = $db->query(SQL::trainerById($id));
    $trainer = Trainer::getById($result);
    echo json_encode($trainer);
});

$app->get('/types', function() use ($app, $db) {
    $result = $db->query(SQL::allTypes());
    $types = Type::getAll($result);
    echo json_encode($types);
});

$app->get('/types/:id', function($id) use ($app, $db) {
    $result = $db->query(SQL::typeById($id));
    //echo json_encode($result);
    $type = Type::getById($result);
    echo json_encode($type);
});

$app->get('/badges', function() use ($app, $db) {
    $result = $db->query(SQL::allBadges());
    $badges = Badge::getAll($result);
    echo json_encode($badges);
});

$app->get('/badges/:id', function($id) use ($app, $db) {
    $result = $db->query(SQL::badgeById($id));
    $badge = Badge::getById($result);
    echo json_encode($badge);
});

$app->run();