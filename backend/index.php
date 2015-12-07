<?php
require 'vendor/autoload.php';
require 'database.php';
require 'sql.php';
require 'model/Pokemon.php';
require 'model/Trainer.php';
require 'model/Gym.php';
require 'model/Type.php';
require 'model/Badge.php';

ini_set("display_errors", 'On');
error_reporting(E_ALL);

$app = new \Slim\Slim();

function sendResponse($data) {
    echo json_encode($data, JSON_PRETTY_PRINT);
}

$app->get("/search/:str", function($searchStr) use ($app) {
    $objects = array();
    $objects["badges"] = Badge::search($searchStr);
    $objects["gyms"] = Gym::search($searchStr);
    $objects["pokemon"] = Pokemon::search($searchStr);
    $objects["trainers"] = Trainer::search($searchStr);
    $objects["types"] = Type::search($searchStr);

    foreach($objects["types"] as $type) {
        $typeId = intval($type["id"]);
        $pokemonForType = Pokemon::searchByType($typeId);
        foreach($pokemonForType as $pokemon) {
            array_push($objects["pokemon"], $pokemon);
        }
    }
    sendResponse($objects);
});

$app->get("/pokemon", function() use ($app) {
    sendResponse(Pokemon::getAll());
});

$app->get("/pokemon/:id", function($id) use ($app) {
    $pokemon = Pokemon::getById($id);
    sendResponse($pokemon->serialize());
});

$app->get("/pokemon/:id/owners", function($pokemonId) use ($app) {
    $pokemon = Pokemon::getById($pokemonId);
    sendResponse($pokemon->getTrainers());
});

$app->post('/trainers/create', function() use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::create($json->name, $json->rivalId, $json->pokemon, $json->badgeIds);
    sendResponse($trainer);
});

$app->post('/trainers/delete', function() use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::delete($json->id);
    sendResponse($trainer);
});

$app->get('/trainers', function() use ($app) {
    sendResponse(Trainer::getAll());
});

$app->post('/trainers/:id/pokemon/add', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->addPokemon($json->pokemonId, $json->pokemonLevel);
    sendResponse($result);
});

$app->post('/trainers/:id/pokemon/remove', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->removePokemon($json->pokemonId);
    sendResponse($result);
});

$app->post('/trainers/:id/badges/add', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->addBadge($json->badgeId);
    sendResponse($result);
});

$app->post('/trainers/:id/badges/remove', function($id) use ($app) {
    $body = $app->request->getBody();
    $json = json_decode($body);
    $trainer = Trainer::getById($id);
    $result = $trainer->removeBadge($json->badgeId);
    sendResponse($result);
});

$app->get('/trainers/:id', function($id) use ($app) {
    $trainer = Trainer::getById($id);
    sendResponse($trainer->serialize());
});

$app->get('/trainers/:id/pokemon', function($id) use ($app) {
    $trainer = Trainer::getById($id);
    sendResponse($trainer->getPokemon());
});

$app->get('/trainers/:id/badges', function($id) use ($app) {
    $trainer = Trainer::getById($id);
    sendResponse($trainer->getBadges());
});

$app->get('/gyms', function() use ($app) {
    sendResponse(Gym::getAll());
});

$app->get('/gyms/:id', function($id) use ($app) {
    $gym = Gym::getById($id);
    sendResponse($gym->serialize());
});

$app->get('/gyms/:id/leader', function($id) use ($app) {
    $gym = Gym::getById($id);
    sendResponse($gym->getLeader()->serialize());
});

$app->get('/types', function() use ($app) {
    sendResponse(Type::getAll());
});

$app->get('/types/:id', function($id) use ($app) {
    $type = Type::getById($id);
    sendResponse($type->serialize());
});

$app->get('/badges', function() use ($app) {
    sendResponse(Badge::getAll());
});

$app->get('/badges/:id', function($id) use ($app) {
    $badge = Badge::getById($id);
    sendResponse($badge->serialize());
});

$app->run();