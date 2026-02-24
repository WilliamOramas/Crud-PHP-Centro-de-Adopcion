<?php
session_start(); // Inicia la de sesion


// Si no existe la variable de sesion cedula redirige al inicio de sesion
if (!isset($_SESSION['cedula'])) {
    header("Location: /adopcioncom/views/login.php");
};
require_once '../bd/conexion.php'; // Para conectarse a la base de datos
require_once '../bd/consultas.php'; // Para importar las funciones
require_once '../controllers/validar_datos/funciones.php'; // Para importar las validaciones

$cedula = $_SESSION['cedula'];

// Verifica si existe un parámetro'id'
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Valida la id de la mascota
    if (ValidarIdMascota($id) == true) {
        
        // Se asigna la mascota al cuidador
        asignarMascotaAEmpleadoBD($pdo,$id,$cedula);
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php") ;
    } else {
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("error al buscar mascota para editar"));
        exit();
    }


}
header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php");
?>  