<?php
class Connection {

    private static $singleton = null;

    static function sharedDB() {
        if (Connection::$singleton === null) {
            $config = array();
//            $config["host"] = "bgroff-pi2.dhcp.bsu.edu";
//            $config["user"] = "_php";
//            $config["pass"] = "cGHtQ3YCStNHM7j4";
//            $config["db"] = "PokemonDB";
//            $config["port"] = 3306;

            $config["host"] = "localhost";
            $config["user"] = "root";
            $config["pass"] = "root";
            $config["db"] = "PokemonDB";
            $config["port"] = 8889;

            Connection::$singleton = new mysqli(
                $config["host"],
                $config["user"],
                $config["pass"],
                $config["db"],
                $config["port"]
            );

            $connection = Connection::$singleton;
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
        }
        return Connection::$singleton;
    }

}