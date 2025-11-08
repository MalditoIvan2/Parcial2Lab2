# Sistema de Gestión de Proyectos

Integrantes: 
- Barrios Nihoul Fabricio Leonel (28689)
- Mendieta Bolgevich Iván (29377)
- Perno Romero Máximo Marcos (28758)

## Nueva Entidad: projects

Se implementó la entidad "projects" relacionada con la tabla "todos" mediante una Foreign Key.

Script SQL: create_projects_table.sql

```sql
CREATE TABLE `projects` (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `description` TEXT,
    `start_date` DATE NULL,
    `end_date` DATE NULL,
    `status` ENUM('activo', 'pausado', 'completado') DEFAULT 'activo',
    `color` VARCHAR(20) DEFAULT 'primary',
    `created_at` DATETIME NOT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `todos` 
ADD `project_id` BIGINT NULL AFTER `priority`,
ADD FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL;

--Agregado de datos
INSERT INTO `projects` (`name`, `description`, `start_date`, `end_date`, `status`, `color`, `created_at`) VALUES
('Desarrollo Web E-commerce', 'Crear plataforma de ventas online con carrito y pagos', '2024-11-01', '2024-12-15', 'activo', 'primary', NOW()),
('App Móvil Fitness', 'Aplicación para seguimiento de ejercicios y nutrición', '2024-10-15', '2025-01-30', 'activo', 'success', NOW()),
('Rediseño de Portfolio', 'Actualizar portfolio personal con nuevos proyectos', '2024-11-05', '2024-11-30', 'pausado', 'warning', NOW()),
('Sistema de Inventario', 'Software para gestión de stock y productos', '2024-09-01', '2024-10-31', 'completado', 'info', NOW());
```

Tipo de relación: 1:N (Un proyecto puede tener muchas tareas)


## CRUD Completo Implementado

- CREATE: app/controllers/projectsController.php → store()
- READ: app/controllers/projectsController.php → index()
- UPDATE: app/controllers/projectsController.php → update()
- DELETE: app/controllers/projectsController.php → delete()

Vistas:
- templates/views/projects/projectsList.php
- templates/views/projects/addProject.php
- templates/views/projects/editProject.php

---

## Patrón de Diseño: SINGLETON

Descripción:

El patrón Singleton garantiza que una clase tenga una única instancia y proporciona un punto de acceso global a ella. En este proyecto, se implementa en la clase Db para gestionar la conexión a la base de datos de manera centralizada.

Ubicación: app/classes/Db.php

Implementación:

```php
<?php

class Db {
    
    private $link;
    private $engine;
    private $host;
    private $name;
    private $user;
    private $pass;
    private $charset;
    
    public function __construct() {
        $this->engine = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
        $this->host = IS_LOCAL ? LDB_HOST : DB_HOST;
        $this->name = IS_LOCAL ? LDB_NAME : DB_NAME;
        $this->user = IS_LOCAL ? LDB_USER : DB_USER;
        $this->pass = IS_LOCAL ? LDB_PASS : DB_PASS;
        $this->charset = IS_LOCAL ? LDB_CHARSET : DB_CHARSET;
        
        $this->connect();
    }
    
    private function connect() {
        try {
            $this->link = new PDO(
                $this->engine.':host='.$this->host.'; dbname='.$this->name.'; charset='.$this->charset,
                $this->user,
                $this->pass
            );
            return $this->link;
        } catch (PDOException $e) {
            die('No hay conexión a la base de datos: ' . $e->getMessage());
        }
    }
    
    public static function query($sql, $params = []) {
        $db = new self();
        
        try {
            $stmt = $db->link->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die('Error en consulta: ' . $e->getMessage());
        }
    }
}
```
Uso en el proyecto:

```php
// En projectsModel.php
public static function all() {
    $model = new static();
    $result = Db::query("SELECT * FROM {$model->table} ORDER BY created_at DESC");
    return $result->fetchAll();
}
```

## Repositorio GitHub

URL: (https://github.com/MalditoIvan2/Parcial2Lab2.git)

