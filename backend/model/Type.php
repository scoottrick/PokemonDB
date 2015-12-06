<?php
class Type {
    private $id, $name;

    public function __construct($data) {
        if (is_array($data)) {
            $this->id = intval($data['type_id']);
            $this->name = $data['type_name'];
        }
    }

    public function serialize() {
        return array(
            'id' => $this->id,
            'name' => $this->name
        );
    }

    private static function typesFromResult($result) {
        $types = array();
        if ($result && mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $type = new Type($row);
                array_push($types, $type->serialize());
            }
        }
        return $types;
    }

    public static function getAll() {
        $result = Database::query(SQL::allTypes());
        return Type::typesFromResult($result);
    }

    public static function getById($id) {
        $result = Database::query(SQL::typeById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $type = new Type($row);
            return $type;
        } else {
            return false;
        }
    }

    public static function search($searchStr) {
        $result = Database::query(SQL::searchTypes($searchStr));
        return Type::typesFromResult($result);
    }
}