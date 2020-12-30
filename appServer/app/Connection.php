<?php

class Connection {
    private static $instance;

    public static function getConn() {

        if (!isset(self::$instance)):
            try {
                self::$instance = new PDO('mysql:dbname=steamproject;host=localhost', 'root', '');
            }catch (Exception $e) {
                throw new Exception($e);
            }
        endif;

        return self::$instance;
    }
}