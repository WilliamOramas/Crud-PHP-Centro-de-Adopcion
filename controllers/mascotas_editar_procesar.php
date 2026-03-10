<?php
session_start();
require_once '../bd/conexion.php';

require_once '../bd/consultas.php';

require_once '../controllers/validar_datos/funciones.php';

require_once '../controllers/auth.php';
verificarSesion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $especie = trim($_POST['especie']);
    $edad = $_POST['edad'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];
    $peso = $_POST['peso'];

    if (validarEditarMisMacotas($id, $nombre, $especie, $edad, $genero, $estado, $peso) == false) {
        header("Location: /adopcioncom/views/mascotas_editar.php?id=$id&msj=" . urlencode("Datos invalidos ingresados") . "&tipo=error");
        exit();
    }
    actualizarMascotaConProtocoloBD($pdo, $nombre, $especie, $edad, $genero, $estado, $peso, $id);
    header("Location: /adopcioncom/views/mis_mascotas.php?msj=" . urlencode("Mascota actualizada exitosamente"));
    exit();
}
else {
    header("Location: /adopcioncom/views/mis_mascotas.php");
    exit();
}
?>
