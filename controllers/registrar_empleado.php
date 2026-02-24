<?php

require_once '../bd/conexion.php'; // Para conectarse a la base de datos
require_once '../bd/consultas.php'; // Para importar las funciones
require_once '../controllers/validar_datos/funciones.php'; // Para importar las validaciones

// Verifica si la pagina se cargo mediante el envio de un formulario 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $pass1 = $_POST['password'];
    $pass2 = $_POST['confirm_password'];
    
    // Guarda la fecha actual del dia que hace el registro
    $fecha_actual = date('Y-m-d');

    $password_encriptada = password_hash($pass1, PASSWORD_BCRYPT);

    // Valida el nombre, apellido, cedula y contraseña del empleado
  if (validarRegistroEmpleado($nombre, $apellido, $cedula, $pass1, $pass2)==false) {

    header("Location: /adopcioncom/views/sign_in.php?msj=" . urlencode("Campos escritos incorrectamente"));
    exit();
    
}
    // Registra los datos del empleado
    registrarEmpleadoBD($pdo,$nombre, $apellido, $cedula, $password_encriptada, $fecha_actual);
    header("Location: /adopcioncom/views/login.php?msj=" . urlencode("Empleado registrado correctamente."));
    exit();
    
}
else {
    header("Location: /adopcioncom/views/login.php");
}
?>