<?php
class SQL {
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

    static function createTrainer($name, $rivalId) {
        return "insert into `TRAINER` (`trainer_name`, `trainer_rival`) values ('" . $name . "'," . $rivalId . ")";
    }

    static function deleteTrainer($id){
        return "DELETE FROM `TRAINER` WHERE `trainer_id` = ".$id;
    }

    static function trainerById($id) {
        return "SELECT * FROM `TRAINER` WHERE trainer_id=" . $id;
    }
    static function trainerBadges($id) {
        return "select * from `BADGE` b, `EARNED_BADGE` e where b.badge_id = e.badge_id and e.trainer_id=" . $id;
    }

    static function addPokemonToTrainer($trainerId, $pokemonId, $pokemonLevel) {
        return "insert into `OWNED_POKEMON` (`trainer_id`, `pokemon_id`, `pokemon_level`) values (". $trainerId . ",'" . $pokemonId . "'," . $pokemonLevel . ")";
    }

    static function removePokemonFromTrainer($trainerId, $pokemonId) {
        return "delete from `OWNED_POKEMON` where `trainer_id` =" . $trainerId . " and `pokemon_id`=" . $pokemonId;
    }

    static function deleteTrainerPokemon($trainerId){
        return "delete from `OWNED_POKEMON` where `trainer_id` =" . $trainerId;
    }

    static function addBadgeToTrainer($trainerId, $badgeId) {
        return "insert into `EARNED_BADGE` (`trainer_id`, `badge_id`) values (" . $trainerId . "," . $badgeId . ")";
    }

    static function removeBadgeFromTrainer($trainerId, $badgeId) {
        return "delete from `EARNED_BADGE` where `trainer_id` =" . $trainerId . " and `badge_id`=" . $badgeId;
    }

    static function deleteTrainerBadges($trainerId){
        return "delete from `EARNED_BADGE` where `trainer_id` =" . $trainerId;
    }

    static function allGyms() {
        return "SELECT * FROM `GYM`";
    }
    static function gymById($id) {
        return "SELECT * FROM `GYM` WHERE gym_id=" . $id;
    }

    static function getLeaderForGym($id) {
        return "select * from `TRAINER` t, `GYM_LEADER` g where g.trainer_id = t.trainer_id and g.gym_id =" . $id;
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

    static function searchBadges($searchStr) {
        return "select * from `BADGE` where concat(`badge_name`, `badge_obedience_level`) like '%" . $searchStr . "%'";
    }

    static function searchGyms($searchStr) {
        return "select * from `GYM` where concat(`gym_name`, `gym_city`) like '%" . $searchStr . "%'";
    }

    static function searchPokemon($searchStr) {
        return "select * from `POKEMON` where concat(`pokemon_id`, `pokemon_name`) like '%" . $searchStr . "%'";
    }

    static function searchTrainers($searchStr) {
        return "select * from `TRAINER` where concat(`trainer_name`) like '%" . $searchStr . "%'";
    }

    static function searchTypes($searchStr) {
        return "select * from `TYPE` where concat(`type_name`) like '%" . $searchStr . "%'";
    }
}