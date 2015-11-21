<?php
class Badge {

    private $id;
    private $name;
    private $obedienceLevel;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval(['badge_id']);
            $this->name = $data['badge_name'];

            $obedienceLevel = $data['badge_obedience_level'];
            if ($obedienceLevel !== null) {
                $obedienceLevel = intval($obedienceLevel);
            }
            $this->obedienceLevel = $obedienceLevel;
        }
    }

    private function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'obedienceLevel' => $this->obedienceLevel
        );
    }

    public static function getAll($result) {
        $badges = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $badge = new Badge($row);
                array_push($badges, $badge->serialize());
            }
        }
        return $badges;
    }

    public static function getById($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $badge = new Badge($row);
            return $badge->serialize();
        } else {
            return false;
        }
    }
}