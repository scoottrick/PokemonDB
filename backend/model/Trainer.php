<?php
class Trainer {
    private $id, $name, $rivalId, $pokemon, $badges;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval($data['trainer_id']);
            $this->name = $data['trainer_name'];

            $rivalId = $data['trainer_rival'];
            if ($rivalId != null) {
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

//    public function addTrainer(){
//        $result = Database::query(SQL::addTrainer($this->name));
//        echo json_encode($result);
//    }

    public function getPokemon() {
        $result = Database::query(SQL::pokemonOwnedByTrainer($this->id));

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
        $result = Database::query(SQL::addPokemonToTrainer($this->id, $pokemonId, $pokemonLevel));
        return $result;
    }

    public function removePokemon($pokemonId) {
        $result = Database::query(SQL::removePokemonFromTrainer($this->id, $pokemonId));
        return $result;
    }

    public function getBadges() {
        $result = Database::query(SQL::trainerBadges($this->id));

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
        $result = Database::query(SQL::addBadgeToTrainer($this->id, $badgeId));
        return $result;
    }

    public function removeBadge($badgeId) {
        $result = Database::query(SQL::removeBadgeFromTrainer($this->id, $badgeId));
        return $result;
    }

    private static function trainersFromResult($result) {
        $trainers = array();
        if ($result && mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $trainer = new Trainer($row);
                array_push($trainers, $trainer->serialize());
            }
        }
        return $trainers;
    }

    public static function getAll() {
        $result = Database::query(SQL::allTrainers());
        return Trainer::trainersFromResult($result);
    }

    public static function getById($id) {
        $result = Database::query(SQL::trainerById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $trainer = new Trainer($row);
            return $trainer;
        } else {
            return false;
        }
    }

    public static function search($searchStr) {
        $result = Database::query(SQL::searchTrainers($searchStr));
        return Trainer::trainersFromResult($result);
    }

    public static function create($name, $rivalId, $pokemon, $badgeIds) {
        if ($rivalId == null){
            $rivalId = "NULL";
        }
        $result = Database::query(SQL::createTrainer($name, $rivalId));
        if ($result) {
            $lastId = mysqli_insert_id(Database::sharedDB());
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

    public static function delete($id) {
        $badge = Database::query(SQL::trainerBadges($id));
        $poke = Database::query(SQL::pokemonOwnedByTrainer($id));
        $result1 = true; $result2 = true;
        if ($badge != null){
            $result1 = Database::query(SQL::deleteTrainerBadges($id));
        }
        if ($poke != null){
            $result2 = Database::query(SQL::deleteTrainerPokemon($id));
        }

        if ($result1 && $result2){

            return Database::query(SQL::deleteTrainer($id));
        }

        return false;
    }
}