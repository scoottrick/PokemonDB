<?php
class Pokemon {

    private $id;
    private $name;
    private $type;
    private $type2;
    private $hp;
    private $speed;
    private $attack;
    private $specialAttack;
    private $defense;
    private $specialDefense;
    private $previousEvolution;
    private $previousEvolutionLevel;
    private $nextEvolution;
    private $nextEvolutionLevel;
    private $level;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = $data['pokemon_id'];
            $this->name = $data['pokemon_name'];

            $type1 = Type::getById(intval($data['pokemon_type1']));
            $this->type = $type1->serialize();

            $type2 = $data['pokemon_type2'];
            if ($type2 !== null) {
                $type2 = Type::getById($type2);
                $this->type2 = $type2->serialize();
            } else {
                $this->type2 = null;
            }

            $this->hp = intval($data['pokemon_hp']);
            $this->speed = intval($data['pokemon_speed']);
            $this->attack = intval($data['pokemon_attack']);
            $this->specialAttack = intval($data['pokemon_special_attack']);
            $this->defense = intval($data['pokemon_defense']);
            $this->specialDefense = intval($data['pokemon_special_defense']);

            if ($data['pokemon_before'] != null){
                $this->previousEvolution = $data['pokemon_before'];
            } else {
                $this->previousEvolution = null;
            }
            if (intval($data['pokemon_before_evo_level']) != null){
                $this->previousEvolutionLevel = intval($data['pokemon_before_evo_level']);
            } else {
                $this->previousEvolutionLevel = null;
            }
            if ($data['pokemon_after'] != null){
                $this->nextEvolution = $data['pokemon_after'];
            } else {
                $this->nextEvolution = null;
            }
            if (intval($data['pokemon_after_evo_level']) != null){
                $this->nextEvolutionLevel = intval($data['pokemon_after_evo_level']);
            } else {
                $this->nextEvolutionLevel = null;
            }
            if (array_key_exists('pokemon_level', $data)){
                if (intval($data['pokemon_level']) != null){
                $this->level = intval($data['pokemon_level']);
            } else {
                $this->level = null;
            }
            } else {
                $this->level = null;
            }

        }
    }

    public function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'type2' => $this->type2,
            'hp' => $this->hp,
            'speed' => $this->speed,
            'attack' => $this->attack,
            'specialAttack' => $this->specialAttack,
            'defense' => $this->defense,
            'specialDefense' => $this->specialDefense,
            'lastEvolution' => $this->previousEvolution,
            'lastEvolutionLevel' => $this->previousEvolutionLevel,
            'nextEvolution' => $this->nextEvolution,
            'nextEvolutionLevel' => $this->nextEvolutionLevel,
            'level' => $this->level
        );
    }

    public function getTrainers() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::trainersForPokemon($this->id));

        $trainers = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $trainer = new Trainer($row);
                array_push($trainers, $trainer->serialize());
            }
        }
        return $trainers;
    }

    private static function pokemonFromResult($result) {
        $pokemonArr = array();
        if ($result && mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $pokemon = new Pokemon($row);
                array_push($pokemonArr, $pokemon->serialize());
            }
        }
        return $pokemonArr;
    }

    public static function getAll() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::allPokemon());
        Pokemon::pokemonFromResult($result);
    }

    public static function getById($id) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::pokemonById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $pokemon = new Pokemon($row);
            return $pokemon;
        } else {
            return false;
        }
    }

    public static function search($searchStr) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::searchPokemon($searchStr));
        return Pokemon::pokemonFromResult($result);
    }

}