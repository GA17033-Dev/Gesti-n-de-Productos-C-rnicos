<?php

namespace App\Lib;

class Model
{

    private Database $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function query($query)
    {
        return $this->db->connect()->query($query);
    }
    public function prepare($query)
    {
        return $this->db->connect()->prepare($query);
    }
    //lastInsertId
    public function lastInsertId()
    {
        return $this->db->connect()->lastInsertId();
    }
}
