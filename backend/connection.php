<?php
class Connection {

    static function createConnection() {
        $config = array();
        $config["host"] = "bgroff-pi2.dhcp.bsu.edu";
        $config["user"] = "_php";
        $config["pass"] = "cGHtQ3YCStNHM7j4";
        $config["db"] = "PokemonDB";
        $config["port"] = 3306;

        $connection = new mysqli(
            $config["host"],
            $config["user"],
            $config["pass"],
            $config["db"],
            $config["port"]
        );

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        } else {
            echo "Connected successfully<br>";
            return $connection;
        }
    }
}