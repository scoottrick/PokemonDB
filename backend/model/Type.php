<?php
class Type {
    private $id;
    private $name;

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
        $db = Connection::sharedDB();
        $result = $db->query(SQL::allTypes());
        return Type::typesFromResult($result);
    }

    public static function getById($id) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::typeById($id));

        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_array();
            $type = new Type($row);
            return $type;
        } else {
            return false;
        }
    }

    public static function search($searchStr) {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::searchTypes($searchStr));
        return Type::typesFromResult($result);
    }
}