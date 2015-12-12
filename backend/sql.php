<?php
class SQL {
    
    /**
     * Retrieves all of the attributes for each of the records in the POKEMON table.
     */
    static function allPokemon() {
        return "SELECT * FROM `POKEMON`";
    }

    /**
     * Retrieves all of the attributes for the Pokemon in the POKEMON table whose pokemon_id matches the given one.
     */
    static function pokemonById($id) {
        return "SELECT * FROM `POKEMON` WHERE pokemon_id=" . $id;
    }

    /**
     * Retrieves all of the records from the TRAINER table where the trainer_id matches a trainer_id retrieved
     * from the OWNED_POKEMON table where the pokemon_id matches the one given.
     */
    static function ownersOfPokemon($id) {
        return "SELECT * FROM `TRAINER` t, `OWNED_POKEMON` o WHERE t.trainer_id = o.trainer_id and pokemon_id=" . $id;
    }
    
    /**
     * Retrieves all of the attributes for each of the records in the TRAINER table.
     */
    static function allTrainers() {
        return "SELECT * FROM `TRAINER`";
    }

    /**
     * Retrieves all of the attributes for the trainer in the TRAINER table whose trainer_id matches the given one.
     */
    static function trainerById($id) {
        return "SELECT * FROM `TRAINER` WHERE trainer_id=" . $id;
    }

    /**
     * Creates a new record in the TRAINER table for the trainer_name and trainer_rival given.
     */
    static function createTrainer($name, $rivalId) {
        return "insert into `TRAINER` (`trainer_name`, `trainer_rival`) values ('" . $name . "'," . $rivalId . ")";
    }

    /**
     * Deletes the trainer from the TRAINER table whose trainer_id matches the given one.
     */
    static function deleteTrainer($id){
        return "DELETE FROM `TRAINER` WHERE `trainer_id` = ".$id;
    }

    /**
     * Retrieves all of the records from the POKEMON table where the pokemon_id matches a pokemon_id retrieved
     * from the OWNED_POKEMON table where the trainer_id matches the one given.
     */
    static function trainerPokemon($id) {
        return "select * from `POKEMON` p, `OWNED_POKEMON` o where p.pokemon_id = o.pokemon_id and o.trainer_id=" . $id;
    }

    /**
     * Creates a new record in the OWNED_POKEMON table for the trainer_id, pokemon_id and pokemon_level give.
     */
    static function addPokemonToTrainer($trainerId, $pokemonId, $pokemonLevel) {
        return "insert into `OWNED_POKEMON` (`trainer_id`, `pokemon_id`, `pokemon_level`) values (". $trainerId . ",'" . $pokemonId . "'," . $pokemonLevel . ")";
    }

    /**
     * Deletes a record from the OWNED_POKEMON table where the trainer_id and pokemon_id match the ones given.
     */
    static function removePokemonFromTrainer($trainerId, $pokemonId) {
        return "delete from `OWNED_POKEMON` where `trainer_id` =" . $trainerId . " and `pokemon_id`=" . $pokemonId;
    }

    /**
     * Deletes all of the records from the OWNED_POKEMON table where the trainer_id matches the given one.
     */
    static function deleteTrainerPokemon($trainerId){
        return "delete from `OWNED_POKEMON` where `trainer_id` =" . $trainerId;
    }

    /**
     * Retrieves all of the records from the BADGE table where the badge_id matches a badge_id retrieved
     * from the EARNED_BADGE table where the trainer_id matches the one given.
     */
    static function trainerBadges($id) {
        return "select * from `BADGE` b, `EARNED_BADGE` e where b.badge_id = e.badge_id and e.trainer_id=" . $id;
    }

    /**
     * Creates a new record in the EARNED_BADGE table for the trainer_id and badge_id.
     */
    static function addBadgeToTrainer($trainerId, $badgeId) {
        return "insert into `EARNED_BADGE` (`trainer_id`, `badge_id`) values (" . $trainerId . "," . $badgeId . ")";
    }

    /**
     * Deletes a record from the EARNED_BADGE table where the trainer_id and badge_id match the ones given.
     */
    static function removeBadgeFromTrainer($trainerId, $badgeId) {
        return "delete from `EARNED_BADGE` where `trainer_id` =" . $trainerId . " and `badge_id`=" . $badgeId;
    }

    /**
     * Deletes all of the records from the EARNED_BADGE table where the trainer_id matches the given one.
     */
    static function deleteTrainerBadges($trainerId){
        return "delete from `EARNED_BADGE` where `trainer_id` =" . $trainerId;
    }

    /**
     * Retrieves all of the attributes for each of the records in the GYM table.
     */
    static function allGyms() {
        return "SELECT * FROM `GYM`";
    }

    /**
     * Retrieves all of the attributes for the gym in the GYM table whose gym_id matches the given one.
     */
    static function gymById($id) {
        return "SELECT * FROM `GYM` WHERE gym_id=" . $id;
    }

    /**
     * Retrieves a record from the TRAINER table where the trainer_id matches a trainer_id retrieved
     * from the GYM_LEADER table where the gym_id matches the one given.
     */
    static function leaderOfGym($id) {
        return "select * from `TRAINER` t, `GYM_LEADER` g where g.trainer_id = t.trainer_id and g.gym_id =" . $id;
    }

    /**
     * Retrieves all of the attributes for each of the records in the TYPE table.
     */
    static function allTypes() {
        return "SELECT * FROM `TYPE`";
    }

    /**
     * Retrieves all of the attributes for the type in the TYPE table whose type_id matches the given one.
     */
    static function typeById($id) {
        return "SELECT * FROM `TYPE` WHERE type_id=" . $id;
    }

    /**
     * Retrieves all of the attributes for each of the records in the BADGE table.
     */
    static function allBadges() {
        return "SELECT * FROM `BADGE`";
    }

    /**
     * Retrieves all of the attributes for the badge in the BADGE table whose badge_id matches the given one.
     */
    static function badgeById($id) {
        return "SELECT * FROM `BADGE` WHERE badge_id=" . $id;
    }

    /**
     * Retrieves all records from the BADGE table where any part of the combined badge_name and badge_obedience_level
     * matches the given search string.
     */
    static function searchBadges($searchStr) {
        return "select * from `BADGE` where concat(`badge_name`, `badge_obedience_level`) like '%" . $searchStr . "%'";
    }

    /**
     * Retrieves all records from the GYM table where any part of the combined gym_name and gym_city
     * matches the given search string.
     */
    static function searchGyms($searchStr) {
        return "select * from `GYM` where concat(`gym_name`, `gym_city`) like '%" . $searchStr . "%'";
    }

    /**
     * Retrieves all records from the POKEMON table where any part of the combined pokemon_id and pokemon_name
     * matches the given search string.
     */
    static function searchPokemon($searchStr) {
        return "select * from `POKEMON` where concat(`pokemon_id`, `pokemon_name`) like '%" . $searchStr . "%'";
    }

    /**
     * Retrieves all records from the POKEMON table either pokemon_type1 or pokemon_type2 matches the given type_id.
     */
    static function searchPokemonByType($typeId) {
        return "SELECT * FROM `POKEMON` WHERE pokemon_type1 = " . $typeId . " or pokemon_type2 = " . $typeId . " ORDER BY `pokemon_id` ASC";
    }

    /**
     * Retrieves all records from the TRAINER table where any part of trainer_name matches the given search string.
     */
    static function searchTrainers($searchStr) {
        return "select * from `TRAINER` where concat(`trainer_name`) like '%" . $searchStr . "%'";
    }

    /**
     * Retrieves all records from the TYPE table where any part of type_name matches the given search string.
     */
    static function searchTypes($searchStr) {
        return "select * from `TYPE` where concat(`type_name`) like '%" . $searchStr . "%'";
    }
}