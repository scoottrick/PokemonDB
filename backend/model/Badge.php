<?php
class Badge {

    private $id;
    private $name;
    private $obedienceLevel;

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
        if (mysqli_num_rows($result) > 0) {
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
        $db = Connection::sharedDB();
        $result = $db->query(SQL::allBadges());
        return Badge::badgesForResult($result);
    }

    public static function getById($id) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::badgeById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $badge = new Badge($row);
            return $badge;
        } else {
            return false;
        }
    }

    public static function search($searchStr) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::searchBadges($searchStr));
        return Badge::badgesForResult($result);
    }
}