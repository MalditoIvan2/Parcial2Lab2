<?php

// Clase helper para funcionalidades específicas del todo list
class Todo {
    
    /**
     * Obtener estadísticas de tareas
     * @return array Array con estadísticas
     */
    public static function getStats() {
        $result = Db::query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN completed = 0 THEN 1 ELSE 0 END) as pending
            FROM todos
        ");
        return $result->fetch();
    }
    
    /**
     * Obtener tareas por prioridad
     * @param string $priority Prioridad (low, medium, high)
     * @return array Array de tareas
     */
    public static function getByPriority($priority) {
        $result = Db::query("SELECT * FROM todos WHERE priority = ? ORDER BY created_at DESC", [$priority]);
        return $result->fetchAll();
    }
    
    public static function toggleStatus($id) {
        Db::query("UPDATE todos SET completed = NOT completed WHERE id = ?", [$id]);
        return true;
    }
    
    public static function toggleImportant($id) {
        Db::query("UPDATE todos SET important = NOT important WHERE id = ?", [$id]);
        return true;
    }
    
    /**
     * Obtener el texto de prioridad en español
     * @param string $priority Prioridad en inglés
     * @return string Prioridad en español
     */
    public static function getPriorityText($priority) {
        $priorities = [
            'low' => 'Baja',
            'medium' => 'Media',
            'high' => 'Alta'
        ];
        return $priorities[$priority] ?? 'Media';
    }
    
    /**
     * Obtener el color de Bootstrap para la prioridad
     * @param string $priority Prioridad
     * @return string Clase CSS de Bootstrap
     */
    public static function getPriorityColor($priority) {
        $colors = [
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger'
        ];
        return $colors[$priority] ?? 'secondary';
    }
}
?>
