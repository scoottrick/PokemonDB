<?php
class Badge {
    private $id, $name, $obedienceLevel;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval($data['badge_id']);
            $this->name = $data['badge_name'];

            $obedienceLevel = $data['badge_obedience_level'];
            if ($obedienceLevel !== null) {
                $obedienceLevel = intval($obedienceLevel);
            }
            $this->obedienceLevel = $obedienceLevel;
        }
    }

    private static function badgesForResult($result) {
        $badges = array();
        if ($result && mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $badge = new Badge($row);
                array_push($badges, $badge->serialize());
            }
        }
        return $badges;
    }

    public function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'obedienceLevel' => $this->obedienceLevel
        );
    }

    public static function getAll() {
        $result = Database::query(SQL::allBadges());
        return Badge::badgesForResult($result);
    }

    public static function getById($id) {
        $result = Database::query(SQL::badgeById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $badge = new Badge($row);
            return $badge;
        } else {
            return false;
        }
    }

    public static function search($searchStr) {
        $result = Database::query(SQL::searchBadges($searchStr));
        return Badge::badgesForResult($result);
    }
}