<?php
class Trainer {

    private $id;
    private $name;
    private $rivalId;

    public static function createFromResult($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $trainer = new Trainer($row);
            return $trainer;
        } else {
            return false;
        }
    }

    private function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'rival_id' => $this->rivalId
        );
    }

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval($data['trainer_id']);
            $this->name = $data['trainer_name'];
            $this->rivalId = intval($data['trainer_rival']);
        }
    }

    public static function getAll($result) {
        $trainers = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $trainer = new Trainer($row);
                if ($trainer) {
                    array_push($trainers, $trainer->serialize());
                } else {
                    echo "no trainer";
                }
            }
        }
        return $trainers;
    }
}