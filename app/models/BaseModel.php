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
    protected static $with = [];
    protected $relations = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct();
        $this->fill($attributes);
    }

    // public static function with($relations)
    // {
    //     $instance = new static;
    //     static::$with = is_string($relations) ? func_get_args() : $relations;
    //     return $instance;
    // }

    public static function with($relations)
    {
        $instance = new static;
        static::$with = is_string($relations) ? func_get_args() : $relations;

        try {
            return $instance;
        } catch (\App\Exceptions\RelationNotFoundException $e) {
            // Aquí puedes manejar la excepción como prefieras
            // Por ejemplo, podrías loggear el error y continuar sin la relación
            error_log($e->getMessage());
            // Removemos la relación que no existe de static::$with
            static::$with = array_diff(static::$with, [$e->getRelation()]);
            return $instance;
        }
    }
    

    public function get()
    {
        $results = $this->all();
        foreach ($results as $result) {
            $this->loadRelations($result);
        }
        return $results;
    }

    // protected function loadRelations($model)
    // {
    //     foreach (static::$with as $relation) {
    //         if (method_exists($model, $relation)) {
    //             $model->relations[$relation] = $model->$relation();
    //         }
    //     }
    // }
    protected function loadRelations($model)
    {
        foreach (static::$with as $relation) {
            if (method_exists($model, $relation)) {
                $model->relations[$relation] = $model->$relation();
            } else {
                throw new \App\Exceptions\RelationNotFoundException($relation, $model);
            }
        }
    }

    public static function find($id)
    {
        $instance = new static;
        $query = "SELECT * FROM {$instance->table} WHERE id = :id LIMIT 1";
        $stmt = $instance->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $model = $instance->fill($result);
            $instance->loadRelations($model);
            return $model;
        }
        return null;
    }

    public function toArray()
    {
        $array = array_diff_key($this->attributes, array_flip($this->hidden));
        foreach ($this->relations as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
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

    public function __toString()
    {
        return json_encode($this->toArray());
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

    protected function hasOne($relatedModel, $foreignKey = null, $localKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        $foreignKey = $foreignKey ?: strtolower(class_basename($this)) . '_id';
        $query = "SELECT * FROM {$relatedInstance->table} WHERE $foreignKey = :localKey LIMIT 1";
        $stmt = $this->prepare($query);
        $stmt->bindValue(':localKey', $this->$localKey);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $relatedInstance->fill($result) : null;
    }

    protected function hasMany($relatedModel, $foreignKey = null, $localKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        $foreignKey = $foreignKey ?: strtolower(class_basename($this)) . '_id';
        $query = "SELECT * FROM {$relatedInstance->table} WHERE $foreignKey = :localKey";
        $stmt = $this->prepare($query);
        $stmt->bindValue(':localKey', $this->$localKey);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($result) use ($relatedModel) {
            return (new $relatedModel())->fill($result);
        }, $results);
    }

    protected function belongsTo($relatedModel, $foreignKey = null, $ownerKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        $foreignKey = $foreignKey ?: strtolower(class_basename($relatedInstance)) . '_id';
        $query = "SELECT * FROM {$relatedInstance->table} WHERE $ownerKey = :foreignKey LIMIT 1";
        $stmt = $this->prepare($query);
        $stmt->bindValue(':foreignKey', $this->$foreignKey);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $relatedInstance->fill($result) : null;
    }

    protected function belongsToMany($relatedModel, $pivotTable = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = 'id', $relatedKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        $pivotTable = $pivotTable ?: $this->getPivotTableName(get_class($this), get_class($relatedInstance));
        $foreignPivotKey = $foreignPivotKey ?: strtolower(class_basename($this)) . '_id';
        $relatedPivotKey = $relatedPivotKey ?: strtolower(class_basename($relatedInstance)) . '_id';

        $query = "SELECT {$relatedInstance->table}.* FROM {$relatedInstance->table} 
                  INNER JOIN $pivotTable ON {$relatedInstance->table}.$relatedKey = $pivotTable.$relatedPivotKey
                  WHERE $pivotTable.$foreignPivotKey = :parentKey";

        $stmt = $this->prepare($query);
        $stmt->bindValue(':parentKey', $this->$parentKey);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($result) use ($relatedModel) {
            return (new $relatedModel())->fill($result);
        }, $results);
    }

    private function getPivotTableName($model1, $model2)
    {
        $models = [
            strtolower(class_basename($model1)),
            strtolower(class_basename($model2))
        ];
        sort($models);
        return implode('_', $models);
    }
}
