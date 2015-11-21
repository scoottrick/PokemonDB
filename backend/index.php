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

$app = new \Slim\Slim(array(
    'mode' => 'development',
    'log.writer' => new \Slim\LogWriter(fopen('log.txt', 'a')),
    'log.level' => \Slim\Log::DEBUG
));

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => true
    ));
});

$app->get('/', function() {
    $app->log->debug("/");
    echo "Welcome to the PokemonDB backend!";
});

$app->get('/hello/:name', function ($name) {
     $app->log->debug("/hello/:".$name);
    echo "Hello, $name";
});

$app->get("/pokemon", function() use ($app, $db) {
     $app->log->debug("/pokemon");
    $result = $db->query(SQL::allPokemon());
    $pokemon = Pokemon::getAll($result);
    echo json_encode($pokemon);
});

$app->get("/pokemon/:id", function($id) use ($app, $db) {
    $app->log->debug("/pokemon/:".$id);
    $result = $db->query(SQL::pokemonById($id));
    $pokemon = Pokemon::getById($result);
    echo (json_encode($pokemon));
});

$app->get('/trainers', function() use ($app, $db) {
    $app->log->debug("/trainers");
    $result = $db->query(SQL::allTrainers());
    $trainers = Trainer::getAll($result);
    echo json_encode($trainers);
});

$app->get('/trainers/:id', function($id) use ($app, $db) {
    $app->log->debug("/trainers/:".$id);
    $result = $db->query(SQL::trainerById($id));
    $trainer = Trainer::getById($result);
    echo json_encode($trainer);
});

$app->get('/types', function() use ($app, $db) {
    $app->log->debug("/types");
    $result = $db->query(SQL::allTypes());
    $types = Type::getAll($result);
    echo json_encode($types);
});

$app->get('/types/:id', function($id) use ($app, $db) {
    $app->log->debug("/types/:".$id);
    $result = $db->query(SQL::typeById($id));
    //echo json_encode($result);
    $type = Type::getById($result);
    echo json_encode($type);
});

$app->get('/badges', function() use ($app, $db) {
    $app->log->debug("/badges");
    $result = $db->query(SQL::allBadges());
    $badges = Badge::getAll($result);
    echo json_encode($badges);
});

$app->get('/badges/:id', function($id) use ($app, $db) {
    $app->log->debug("/badges/:".$id);
    $result = $db->query(SQL::badgeById($id));
    $badge = Badge::getById($result);
    echo json_encode($badge);
});

$app->run();