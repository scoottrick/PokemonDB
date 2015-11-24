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

    public static function getAll() {
        $db = Connection::sharedDB();
        $result = $db->query(SQL::allTypes());

        $types = array();
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $type = new Type($row);
                array_push($types, $type->serialize());
            }
        }
        return $types;
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
}