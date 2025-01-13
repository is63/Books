<?php

class Database
{
    private static $dbName = 'if0_37391483_crud_mvc_oop';
    private static $dbHost = 'sql206.infinityfree.com';
    private static $dbUsername = 'if0_37391483';
    private static $dbUserPassword = 'rQ0fMHEb5O';

    private static $conn = null;

    public function __construct(){}

    public static function connect()
    {
        if (null == self::$conn) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName.";port=3306", self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$conn;
    }

    public static function disconnect()
    {
        self::$conn = null;
    }
}

?>
