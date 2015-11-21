<?php
class Trainer {

    private $id;
    private $name;
    private $rivalId;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval($data['trainer_id']);
            $this->name = $data['trainer_name'];

            $rivalId = $data['trainer_rival'];
            if ($rivalId !== null) {
                $rivalId = intval($rivalId);
            }
            $this->rivalId = $rivalId;
        }
    }

    private function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'rival_id' => $this->rivalId
        );
    }

    public static function getAll($result) {
        $trainers = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $trainer = new Trainer($row);
                array_push($trainers, $trainer->serialize());
            }
        }
        return $trainers;
    }

    public static function getById($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $trainer = new Trainer($row);
            return $trainer->serialize();
        } else {
            return false;
        }
    }
}