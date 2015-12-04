<?php
class Gym {

    private $id;
    private $name;
    private $city;
    private $type;
    private $badge;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = $data['gym_id'];
            $this->name = $data['gym_name'];
            $this->city = $data['gym_city'];
            $type = Type::getById(intval($data['gym_type']));
            $this->type = $type->serialize();
            $badge = Badge::getById(intval($data['gym_badge']));
            $this->badge = $badge -> serialize();
        }
    }

    public function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'type' => $this->type,
            'badge' => $this->badge,
            'leader' => $this->getLeader()->serialize()
        );
    }

    public function getLeader() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::getLeaderForGym($this->id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $leader = new Trainer($row);
            return $leader;
        } else {
            return false;
        }
    }

    public static function getAll() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::allGyms());

        $gyms = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $gym = new Gym($row);
                array_push($gyms, $gym->serialize());
            }
        }
        return $gyms;
    }

    public static function getById($id) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::gymById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $gym = new Gym($row);
            return $gym;
        } else {
            return false;
        }
    }
}