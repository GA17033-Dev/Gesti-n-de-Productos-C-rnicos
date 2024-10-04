<?php

namespace App\Exceptions;

use Exception;

class RelationNotFoundException extends Exception
{
    public function __construct($relation, $model)
    {
        parent::__construct("Relation '{$relation}' does not exist on model " . get_class($model));
    }
}