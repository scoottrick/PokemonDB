<?php
require 'vendor/autoload.php';
require 'connection.php';
require 'sql.php';
require 'model/Pokemon.php';
require 'model/Trainer.php';
require 'model/Gym.php';
require 'model/Type.php';
require 'model/Badge.php';

error_reporting(E_ALL);

$db = Connection::createConnection();

$app = new \Slim\Slim();

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

$app->get("/pokemon/:id/owners", function($pokemonId) use ($app, $db) {
    $result = $db->query(SQL::trainersOwningPokemon($pokemonId));
    if (mysqli_num_rows($result) > 0) {
        $trainers = array();
        foreach ($result as $row) {
            $trainerId = $row["trainer_id"];
            $trainerResult = $db->query(SQL::trainerById($trainerId));
            array_push($trainers, Trainer::getById($trainerResult));
        }
        echo json_encode($trainers);
    }
});

$app->get("/trainers/:id/owned_pokemon", function($trainerId) use ($app, $db) {
    $result = $db->query(SQL::pokemonOwnedByTrainer($trainerId));
    if (mysqli_num_rows($result) > 0) {
        $pokemon = array();
        foreach ($result as $row) {
            $pokemonId = $row["pokemon_id"];
            $pokemonResult = $db->query(SQL::pokemonById($pokemonId));
            array_push($pokemon, Pokemon::getById($pokemonResult));
        }
        echo json_encode($pokemon);
    }
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

$app->get('/gyms', function() use ($app, $db) {
    $result = $db->query(SQL::allGyms());
    $gyms = Gym::getAll($result);
    echo json_encode($gyms);
});

$app->get('/gyms/:id', function($id) use ($app, $db) {
    $result = $db->query(SQL::gymByName($id));
    $gym = Gym::getById($result);
    echo json_encode($gym);
});

$app->get('/types', function() use ($app, $db) {
    $result = $db->query(SQL::allTypes());
    $types = Type::getAll($result);
    echo json_encode($types);
});

$app->get('/types/:id', function($id) use ($app, $db) {
    $result = $db->query(SQL::typeById($id));
    echo json_encode($result);
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