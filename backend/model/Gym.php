<?php
class Gym {

    private $name;
    private $city;
    private $typeId;
    private $badgeId;

    public function __construct($data) {
        if (is_array($data)) {
            $this->name = $data['gym_name'];
            $this->city = $data['gym_city'];
            $this->typeId = intval($data['gym_type']);
            $this->badgeId = intval($data['gym_badge']);
        }
    }

    private function serialize() {
        return array(
            'name' => $this->name,
            'city' => $this->city,
            'typeId' => $this->typeId,
            'badgeId' => $this->badgeId
        );
    }

    public static function getAll($result) {
        $gyms = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $gym = new Gym($row);
                array_push($gyms, $gym->serialize());
            }
        }
        return $gyms;
    }

    public static function getById($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $gym = new Gym($row);
            return $gym->serialize();
        } else {
            return false;
        }
    }
}