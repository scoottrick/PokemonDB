<?php
class SQL {
    static function allPokemon() {
        return "SELECT * FROM `POKEMON`";
    }

    static function pokemonById($id) {
        return "SELECT * FROM `POKEMON` WHERE pokemon_id=" . $id;
    }

    static function allTrainers() {
        return "SELECT * FROM `TRAINER`";
    }

    static function trainerById($id) {
        return "SELECT * FROM `TRAINER` WHERE trainer_id=" . $id;
    }
}