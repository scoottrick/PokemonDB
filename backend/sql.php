<?php
class SQL {

    static function searchBadges($str) {
        return "SELECT * FROM `BADGE` WHERE CONCAT(badge_id, badge_name, badge_obedience_level) LIKE '%" . $str . "%'";
    }

    static function allPokemon() {
        return "SELECT * FROM `POKEMON`";
    }

    static function pokemonById($id) {
        return "SELECT * FROM `POKEMON` WHERE pokemon_id=" . $id;
    }

    static function trainersForPokemon($id) {
        return "SELECT * FROM `TRAINER` t, `OWNED_POKEMON` o WHERE t.trainer_id = o.trainer_id and pokemon_id=" . $id;
    }

    static function pokemonOwnedByTrainer($id) {
        return "select * from `POKEMON` p, `OWNED_POKEMON` o where p.pokemon_id = o.pokemon_id and o.trainer_id=" . $id;
    }

    static function allTrainers() {
        return "SELECT * FROM `TRAINER`";
    }

    static function trainerById($id) {
        return "SELECT * FROM `TRAINER` WHERE trainer_id=" . $id;
    }

    static function trainerBadges($id) {
        return "select * from `BADGE` b, `EARNED_BADGE` e where b.badge_id = e.badge_id and e.trainer_id=" . $id;
    }

    static function allGyms() {
        return "SELECT * FROM `GYM`";
    }

    static function gymById($id) {
        return "SELECT * FROM `GYM` WHERE gym_id=" . $id;
    }

    static function allTypes() {
        return "SELECT * FROM `TYPE`";
    }

    static function typeById($id) {
        return "SELECT * FROM `TYPE` WHERE type_id=" . $id;
    }

    static function allBadges() {
        return "SELECT * FROM `BADGE`";
    }

    static function badgeById($id) {
        return "SELECT * FROM `BADGE` WHERE badge_id=" . $id;
    }
}