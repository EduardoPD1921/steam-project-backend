<?php

class Connection {
    private static $instance;

    public static function getConn() {

        if (!isset(self::$instance)):
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=projectdb;charset=utf8', 'pmauser', 'Magekiller11');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection failed: '.$e->getMessage();
            }
        endif;

        return self::$instance;
    }
}