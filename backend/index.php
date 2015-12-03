<?php
require 'vendor/autoload.php';
require 'connection.php';
require 'sql.php';
require 'model/Pokemon.php';
require 'model/Trainer.php';
require 'model/Gym.php';
require 'model/Type.php';
require 'model/Badge.php';

ini_set("display_errors", 'On');
error_reporting(E_ALL);

$app = new \Slim\Slim();

$app->get("/search/:str", function($searchStr) use ($app) {
    echo json_encode(Badge::search($searchStr));
});

$app->get("/pokemon", function() use ($app) {
    echo json_encode(Pokemon::getAll());
});

$app->get("/pokemon/:id", function($id) use ($app) {
    $pokemon = Pokemon::getById($id);
    echo json_encode($pokemon->serialize());
});

$app->get("/pokemon/:id/owners", function($pokemonId) use ($app) {
    $pokemon = Pokemon::getById($pokemonId);
    echo json_encode($pokemon->getTrainers());
});

$app->post('/trainers/create', function() use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::create($json->name, $json->rivalId, $json->pokemon, $json->badgeIds);
    echo json_encode($trainer);
});

$app->get('/trainers', function() use ($app) {
    echo json_encode(Trainer::getAll());
});

$app->post('/trainers/:id/pokemon/add', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->addPokemon($json->pokemonId, $json->pokemonLevel);
    echo json_encode($result);
});

$app->post('/trainers/:id/pokemon/remove', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->removePokemon($json->pokemonId);
    echo json_encode($result);
});

$app->post('/trainers/:id/badges/add', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->addBadge($json->badgeId);
    echo json_encode($result);
});

$app->post('/trainers/:id/badges/remove', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->removeBadge($json->badgeId);
    echo json_encode($result);
});

$app->get('/trainers/:id', function($id) use ($app) {
    $trainer = Trainer::getById($id);
    echo json_encode($trainer->serialize());
});

$app->get('/trainers/:id/pokemon', function($id) use ($app) {
    $trainer = Trainer::getById($id);
    echo json_encode($trainer->getPokemon());
});

$app->get('/trainers/:id/badges', function($id) use ($app) {
    $trainer = Trainer::getById($id);
    echo json_encode($trainer->getBadges());
});

$app->get('/gyms', function() use ($app) {
    echo json_encode(Gym::getAll());
});

$app->get('/gyms/:id', function($id) use ($app) {
    $gym = Gym::getById($id);
    echo json_encode($gym->serialize());
});

$app->get('/types', function() use ($app) {
    echo json_encode(Type::getAll());
});

$app->get('/types/:id', function($id) use ($app) {
    $type = Type::getById($id);
    echo json_encode($type->serialize());
});

$app->get('/badges', function() use ($app) {
    echo json_encode(Badge::getAll());
});

$app->get('/badges/:id', function($id) use ($app) {
    $badge = Badge::getById($id);
    echo json_encode($badge->serialize());
});

$app->run();