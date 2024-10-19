<?php

namespace App\Lib;

class Model {
    protected static $db;

    public function __construct()
    {
        if (!self::$db) {
            self::$db = Database::getInstance();
        }
    }

    public function query($query)
    {
        return self::$db->query($query);
    }

    public function prepare($query)
    {
        return self::$db->prepare($query);
    }

    public function lastInsertId()
    {
        return self::$db->lastInsertId();
    }

    public static function beginTransaction()
    {
        return self::getDb()->beginTransaction();
    }

    public static function commit()
    {
        return self::getDb()->commit();
    }

    public static function rollBack()
    {
        return self::getDb()->rollBack();
    }

    protected static function getDb()
    {
        if (!self::$db) {
            self::$db = Database::getInstance();
        }
        return self::$db;
    }
}