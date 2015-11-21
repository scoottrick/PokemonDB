<?php
class Type {
    private $id;
    private $name;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval(['type_id']);
            $this->name = $data['type_name'];
        }
    }

    private function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name
        );
    }

    public static function getAll($result) {
        $types = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $type = new Type($row);
                array_push($types, $type->serialize());
            }
        }
        return $types;
    }

    public static function getById($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $type = new Type($row);
            return $type->serialize();
        } else {
            return false;
        }
    }
}