<?php
session_start(); // Inicia la sesion
require_once("../bd/conexion.php");  // Para conectarse a la base de datos
require_once '../bd/consultas.php'; // Para importar las funciones
require_once '../controllers/validar_datos/funciones.php'; // Para importar las validaciones

// Verifica si la pagina se cargo mediante el envio de un formulario 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $pass_usuario = $_POST['password'];

    // Valida la cedula y contraseña
    if (validarLogin($cedula, $pass_usuario)==false) {
        
    //Redirige al login cuando se escribe mal el usuario o la contraseña
    header("Location: /adopcioncom/views/login.php?msj=" . urlencode("Usuario o contraseña mal escrito"));
    exit();

    }
    // Verifica en la base de datos si coincide los datos ingresados 
    autenticarEmpleadoBD($pdo,$cedula,$pass_usuario);
}
else {
    header("Location: /adopcioncom/views/login.php");
    }
?>
