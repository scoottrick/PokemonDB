<?php
class SQL {
    static function allTrainers() {
        return "SELECT * FROM `TRAINER`";
    }

    static function trainerById($id) {
        return "SELECT * FROM `TRAINER` WHERE trainer_id=" . $id;
    }
}