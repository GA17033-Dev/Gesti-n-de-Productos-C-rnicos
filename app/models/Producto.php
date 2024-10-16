<?php
namespace App\Models;

use App\Models\BaseModel;

class Producto extends BaseModel
{
    protected $table = 'productos';
    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'estado',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    public static function count()
    {
    $db = static::getDB(); // Método para obtener la conexión a la base de datos
    $stmt = $db->query("SELECT COUNT(*) FROM productos"); //esto servira para mostrar el total de productos en el dashboard
    return $stmt->fetchColumn();
    }
}