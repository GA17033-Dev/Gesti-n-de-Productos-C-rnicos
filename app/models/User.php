<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Lib\Model;

class User extends Model
{
    protected $table = 'users';

    // Propiedades explícitas
    protected $id;
    protected $name;
    protected $lastname;
    protected $address;
    protected $email;
    protected $password;
    protected $created_at;
    protected $updated_at;

    protected $fillable = ['name', 'lastname', 'address', 'email', 'password'];
    protected $hidden = ['password'];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        $this->fill($attributes);
    }

    public function fill(array $attributes)
    {
        foreach ($this->fillable as $field) {
            if (isset($attributes[$field])) {
                $this->$field = $attributes[$field];
            }
        }
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    // Setters
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function save()
    {
        if (isset($this->id)) {
            return $this->update();
        }
        return $this->insert();
    }

    protected function insert()
    {
        $fields = implode(', ', $this->fillable);
        $placeholders = ':' . implode(', :', $this->fillable);
        $query = "INSERT INTO {$this->table} ($fields, created_at, updated_at) 
                  VALUES ($placeholders, :created_at, :updated_at)";

        $stmt = $this->prepare($query);

        foreach ($this->fillable as $field) {
            $stmt->bindValue(":$field", $this->$field);
        }
        $now = date('Y-m-d H:i:s');
        $stmt->bindValue(':created_at', $now);
        $stmt->bindValue(':updated_at', $now);

        if ($stmt->execute()) {
            $this->id = $this->lastInsertId();
            return true;
        }
        return false;
    }

    protected function update()
    {
        $fields = array_map(function ($field) {
            return "$field = :$field";
        }, $this->fillable);
        $fields = implode(', ', $fields);

        $query = "UPDATE {$this->table} SET $fields, updated_at = :updated_at WHERE id = :id";

        $stmt = $this->prepare($query);

        foreach ($this->fillable as $field) {
            $stmt->bindValue(":$field", $this->$field);
        }
        $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));
        $stmt->bindValue(':id', $this->id);

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->prepare($query);
        $stmt->bindValue(':id', $this->id);
        return $stmt->execute();
    }

    public static function findById($id)
    {
        $instance = new static;
        $query = "SELECT * FROM {$instance->table} WHERE id = :id";
        $stmt = $instance->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new static($data);
        }
        return null;
    }

    public static function all()
    {
        $instance = new static;
        $query = "SELECT * FROM {$instance->table}";
        $stmt = $instance->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function toArray()
    {
        $data = get_object_vars($this);
        foreach ($this->hidden as $key) {
            unset($data[$key]);
        }
        return $data;
    }
}
