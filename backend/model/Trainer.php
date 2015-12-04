<?php
class Trainer {

    private $id;
    private $name;
    private $rivalId;
    private $pokemon;
    private $badges;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval($data['trainer_id']);
            $this->name = $data['trainer_name'];

            $rivalId = $data['trainer_rival'];
            if ($rivalId !== null) {
                $rivalId = intval($rivalId);
            }
            $this->rivalId = $rivalId;
            $this->pokemon = $this->getPokemon();
            $this->badges = $this->getBadges();
        }
    }

    public function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'rival_id' => $this->rivalId,
            'owned_pokemon' => $this->pokemon,
            'earned_badges' => $this->badges
        );
    }

    public function addTrainer(){
        $db = Connection::sharedDB();
        $result = $db->query(SQL::addTrainer($this->name));
        echo json_encode($result);
    }

    public function getPokemon() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::pokemonOwnedByTrainer($this->id));

        $pokemonArr = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $pokemon = new Pokemon($row);
                array_push($pokemonArr, $pokemon->serialize());
            }
        }
        return $pokemonArr;
    }

    public function addPokemon($pokemonId, $pokemonLevel) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::addPokemonToTrainer($this->id, $pokemonId, $pokemonLevel));
        return $result;
    }

    public function removePokemon($pokemonId) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::removePokemonFromTrainer($this->id, $pokemonId));
        return $result;
    }

    public function getBadges() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::trainerBadges($this->id));

        $badges = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $badge = new Badge($row);
                array_push($badges, $badge->serialize());
            }
        }
        return $badges;
    }

    public function addBadge($badgeId) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::addBadgeToTrainer($this->id, $badgeId));
        return $result;
    }

    public function removeBadge($badgeId) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::removeBadgeFromTrainer($this->id, $badgeId));
        return $result;
    }

    public static function getAll() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::allTrainers());

        $trainers = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $trainer = new Trainer($row);
                array_push($trainers, $trainer->serialize());
            }
        }
        return $trainers;
    }

    public static function getById($id) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::trainerById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $trainer = new Trainer($row);
            return $trainer;
        } else {
            return false;
        }
    }

    public static function create($name, $rivalId, $pokemon, $badgeIds) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::createTrainer($name, $rivalId));
        if ($result) {
            $lastId = mysqli_insert_id($db);
            $trainer = Trainer::getById($lastId);

            foreach($pokemon as $p) {
                $trainer->addPokemon($p->pokemonId, $p->pokemonLevel);
            }

            foreach($badgeIds as $id) {
                $trainer->addBadge($id);
            }

            return Trainer::getById($lastId)->serialize();
        }
        return false;
    }
}