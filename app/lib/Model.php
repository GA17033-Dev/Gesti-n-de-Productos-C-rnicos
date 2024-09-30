<?php

namespace App\Lib;

class Model
{
    private Database $db;

    public function query($query)
    {
        return $this->db->connect()->query($query);
    }
    public function prepare($query)
    {
        return $this->db->connect()->prepare($query);
    }
}
