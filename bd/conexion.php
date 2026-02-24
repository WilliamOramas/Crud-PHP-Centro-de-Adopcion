<?php
// Datos de la base de datos
$host = "localhost";
$db   = "centro_adopcion"; 
$user = "root";           
$pass = "";               
$charset = "utf8mb4";     

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Configuraciones del PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

try {
    // Se crea la conexion 
    $pdo = new PDO($dsn, $user, $pass, $options);
    
} catch (\PDOException $e) {
    // Si sucede algo manda el mensaje de que sucedio
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
   
}
?>