<?php
session_start(); // Inicia la de sesion

// Si no existe la variable de sesion cedula redirige al inicio de sesion
if (!isset($_SESSION['cedula'])) {
    header("Location: /adopcioncom/views/login.php");
};
require_once '../bd/conexion.php'; // Para conectarse a la base de datos
require_once '../bd/consultas.php'; // Para importar las funciones
require_once '../controllers/validar_datos/funciones.php'; // Para importar las validaciones

// Verifica si existe un parámetro'id'
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $cedula = $_SESSION['cedula'];

    // Verifica la id del cuidador y busca al cuidador mediante la id de mascota
    if (EliminarMascotaValidarCuidador($pdo,$id,$cedula) == true) {

        //Busca los datos de la mascota para luego eliminar
        liberarMascotaDeAsignadoBD($pdo,$id);
        header("Location: /adopcioncom/views/mis_mascotas.php") ;

    } else {
        header("Location: /adopcioncom/views/mis_mascotas.php?msj=" . urlencode("Hubo un error al eliminar mascota"));
    }
    
}
else {
    header("Location: /adopcioncom/views/mis_mascotas.php?msj=" . urlencode("Error: No se selecciono mascota"));
}

?>  