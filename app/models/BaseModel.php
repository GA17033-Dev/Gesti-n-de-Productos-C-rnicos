<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Lib\Model;
use JsonSerializable;

abstract class BaseModel extends Model implements JsonSerializable
{
    protected $table;
    protected $fillable = [];
    protected $hidden = [];
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        $this->fill($attributes);
    }

    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
        return $this;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function save()
    {
        if (isset($this->attributes['id'])) {
            return $this->update();
        }
        return $this->insert();
    }

    protected function insert()
    {
        $fields = array_intersect_key($this->attributes, array_flip($this->fillable));
        $fields['created_at'] = date('Y-m-d H:i:s');
        $fields['updated_at'] = date('Y-m-d H:i:s');

        $fieldNames = implode(', ', array_keys($fields));
        $fieldPlaceholders = ':' . implode(', :', array_keys($fields));

        $query = "INSERT INTO {$this->table} ($fieldNames) VALUES ($fieldPlaceholders)";

        $stmt = $this->prepare($query);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            $this->attributes['id'] = $this->lastInsertId();
            return true;
        }
        return false;
    }

    protected function update()
    {
        $fields = array_intersect_key($this->attributes, array_flip($this->fillable));
        $fields['updated_at'] = date('Y-m-d H:i:s');

        $fieldUpdates = [];
        foreach (array_keys($fields) as $field) {
            $fieldUpdates[] = "$field = :$field";
        }
        $fieldUpdatesStr = implode(', ', $fieldUpdates);

        $query = "UPDATE {$this->table} SET $fieldUpdatesStr WHERE id = :id";

        $stmt = $this->prepare($query);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $this->attributes['id']);

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->prepare($query);
        $stmt->bindValue(':id', $this->attributes['id']);
        return $stmt->execute();
    }

    public static function all()
    {
        $instance = new static;
        $query = "SELECT * FROM {$instance->table}";
        $stmt = $instance->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return static::collection(array_map(function ($result) {
            return (new static)->fill($result);
        }, $results));
    }

    public function toArray()
    {
        return array_diff_key($this->attributes, array_flip($this->hidden));
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public static function find($id)
    {
        return static::where('id', $id);
    }

    public static function where($field, $value)
    {
        $instance = new static;
        $query = "SELECT * FROM {$instance->table} WHERE $field = :$field";
        $stmt = $instance->prepare($query);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $instance->fill($result);
        }
        return null;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public static function collection($items)
    {
        return array_map(function ($item) {
            return $item instanceof self ? $item->toArray() : $item;
        }, $items);
    }
}