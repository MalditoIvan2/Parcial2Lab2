<?php

// Clase Db: Maneja la conexión y operaciones con la base de datos
// Proporciona una interfaz simple para interactuar con MySQL
class Db {
    
    // Propiedades privadas para la configuración de la base de datos
    private $link;      // Conexión a la base de datos
    private $engine;    // Motor de base de datos (mysql, postgresql, etc.)
    private $host;      // Host de la base de datos
    private $name;      // Nombre de la base de datos
    private $user;      // Usuario de la base de datos
    private $pass;      // Contraseña de la base de datos
    private $charset;   // Codificación de caracteres
    
    /**
     * Constructor para nuestra clase
     * Inicializa las propiedades con los valores de configuración
     */
    public function __construct() {
        // Configurar propiedades según el entorno (local o producción)
        $this->engine = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
        $this->host = IS_LOCAL ? LDB_HOST : DB_HOST;
        $this->name = IS_LOCAL ? LDB_NAME : DB_NAME;
        $this->user = IS_LOCAL ? LDB_USER : DB_USER;
        $this->pass = IS_LOCAL ? LDB_PASS : DB_PASS;
        $this->charset = IS_LOCAL ? LDB_CHARSET : DB_CHARSET;
        
        // Establecer conexión automáticamente
        $this->connect();
    }
    
    /**
     * Método para abrir una conexión a la base de datos
     * Crea la conexión PDO y la almacena en $this->link
     *
     * @return PDO
     */
    private function connect() {
        try {
            $this->link = new PDO($this->engine.':host='.$this->host.'; dbname='.$this->name.'; charset='.$this->charset, $this->user, $this->pass);
            return $this->link;
        } catch (PDOException $e) {
            die(sprintf('No hay conexión a la base de datos, hubo un error: %s', $e->getMessage()));
        }
    }
    
    /**
     * Método para hacer un query a la base de datos
     * Ejecuta consultas SQL de forma segura usando prepared statements
     *
     * @param string $sql Consulta SQL a ejecutar
     * @param array $params Parámetros para la consulta preparada
     * @return PDOStatement|false Resultado de la consulta
     */
    public static function query($sql, $params = []) {
        // Crear instancia de la clase para acceder a la conexión
        $db = new self();
        
        try {
            // Preparar la consulta
            $stmt = $db->link->prepare($sql);
            
            // Ejecutar con parámetros
            $stmt->execute($params);
            
            // Retornar el statement para procesar resultados
            return $stmt;
            
        } catch (PDOException $e) {
            // En caso de error, mostrar mensaje y retornar false
            die('Error en consulta: ' . $e->getMessage());
        }
    }
}