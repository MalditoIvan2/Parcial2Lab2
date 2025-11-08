<?php

// Clase base para todos los modelos
// Proporciona métodos comunes para operaciones CRUD
class Model {
    
    // Nombre de la tabla (debe ser definido en cada modelo hijo)
    protected $table = '';
    
    // Campos de la tabla (debe ser definido en cada modelo hijo)
    protected $fillable = [];
    
    /**
     * Obtener todos los registros de la tabla
     * @return array Array con todos los registros
     */
    public static function all() {
        $model = new static();
        $result = Db::query("SELECT * FROM {$model->table} ORDER BY created_at DESC");
        return $result->fetchAll();
    }
    
    /**
     * Buscar un registro por ID
     * @param int $id ID del registro
     * @return array|false Registro encontrado o false
     */
    public static function find($id) {
        $model = new static();
        $result = Db::query("SELECT * FROM {$model->table} WHERE id = ?", [$id]);
        return $result->fetch();
    }
    
    /**
     * Crear un nuevo registro
     * @param array $data Datos del registro
     * @return bool True si se creó exitosamente
     */
    public static function create($data) {
        $model = new static();
        
        // Filtrar solo campos permitidos
        $filteredData = array_intersect_key($data, array_flip($model->fillable));
        
        // Construir consulta INSERT
        $fields = implode(', ', array_keys($filteredData));
        $placeholders = implode(', ', array_fill(0, count($filteredData), '?'));
        
        $sql = "INSERT INTO {$model->table} ({$fields}, created_at) VALUES ({$placeholders}, NOW())";
        
        Db::query($sql, array_values($filteredData));
        return true;
    }
    
    /**
     * Actualizar un registro por ID
     * @param int $id ID del registro
     * @param array $data Datos a actualizar
     * @return bool True si se actualizó exitosamente
     */
    public static function update($id, $data) {
        $model = new static();
        
        // Filtrar solo campos permitidos
        $filteredData = array_intersect_key($data, array_flip($model->fillable));
        
        // Construir consulta UPDATE
        $setClause = implode(' = ?, ', array_keys($filteredData)) . ' = ?';
        $sql = "UPDATE {$model->table} SET {$setClause} WHERE id = ?";
        
        $values = array_values($filteredData);
        $values[] = $id;
        
        Db::query($sql, $values);
        return true;
    }
    
    /**
     * Eliminar un registro por ID
     * @param int $id ID del registro
     * @return bool True si se eliminó exitosamente
     */
    public static function delete($id) {
        $model = new static();
        Db::query("DELETE FROM {$model->table} WHERE id = ?", [$id]);
        return true;
    }
}
?>
