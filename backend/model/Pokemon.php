<?php
class Pokemon {

    private $id;
    private $name;
    private $level;
    private $type;
    private $type2;
    private $hp;
    private $speed;
    private $attack;
    private $specialAttack;
    private $defense;
    private $specialDefense;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = $data['pokemon_id'];
            $this->name = $data['pokemon_name'];
            $this->level = intval($data['pokemon_level']);
            $this->type = intval($data['pokemon_type1']);

            $type2 = $data['pokemon_type2'];
            if ($type2 !== null) {
                $type2 = intval($type2);
            }
            $this->type2 = $type2;

            $this->hp = intval($data['pokemon_hp']);
            $this->speed = intval($data['pokemon_speed']);
            $this->attack = intval($data['pokemon_attack']);
            $this->specialAttack = intval($data['pokemon_special_attack']);
            $this->defense = intval($data['pokemon_defense']);
            $this->specialDefense = intval($data['pokemon_special_defense']);
        }
    }

    private function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'type' => $this->type,
            'type2' => $this->type2,
            'hp' => $this->hp,
            'speed' => $this->speed,
            'attack' => $this->attack,
            'specialAttack' => $this->specialAttack,
            'defense' => $this->defense,
            'specialDefense' => $this->specialDefense
        );
    }

    public static function getAll($result) {
        $pokemonArr = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $pokemon = new Pokemon($row);
                array_push($pokemonArr, $pokemon->serialize());
            }
        }
        return $pokemonArr;
    }

    public static function getById($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $pokemon = new Pokemon($row);
            return $pokemon->serialize();
        } else {
            return false;
        }
    }

    public static function getByTrainer($result) {

    }
}