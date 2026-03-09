<?php
session_start();
require_once '../bd/conexion.php';

require_once '../bd/consultas.php';

require_once '../controllers/validar_datos/funciones.php';

require_once '../controllers/auth.php';
verificarSesion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_mascota'];
    $nombre = trim($_POST['nombre_mascota']);
    $especie = trim($_POST['especie']);
    $edad = $_POST['edad_meses'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];
    $peso = $_POST['peso_g'];

    if (validarEditarMisMacotas($id, $nombre, $especie, $edad, $genero, $estado, $peso) == false) {
        header("Location: /adopcioncom/views/mis_mascotas.php?msj=" . urlencode("Datos invalidos ingresados"));
        exit();
    }
    actualizarMascotaConProtocoloBD($pdo, $nombre, $especie, $edad, $genero, $estado, $peso, $id);
}
else {
    header("Location: /adopcioncom/views/mis_mascotas.php");
    exit();
}
?>
