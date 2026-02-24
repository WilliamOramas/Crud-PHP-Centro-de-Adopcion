<?php
session_start();
if (!isset($_SESSION['cedula'])) { header("Location: /adopcioncom/views/login.php"); exit(); }

require_once '../bd/conexion.php';
require_once '../bd/consultas.php';
require_once '../controllers/validar_datos/funciones.php';

$titulo = "Pequeños amigos";
include('../views/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cedula_empleado = $_SESSION['cedula'];

    if (ValidarIdMascota($id) == true) {
        if (BuscarCuidadorXidMascota($pdo,$id,$cedula_empleado)== true) {
            eliminarMascotaPorEncargadoBD($pdo,$id,$cedula_empleado);
        } else {
            header("Location: /adopcioncom/views/mis_mascotas.php?msj=" . urlencode("error al dar en adopcion"));
            exit();
        }
        
    }else {
        header("Location: /adopcioncom/views/mis_mascotas.php?msj=" . urlencode("error al buscar mascota a adoptar"));
        exit();
    }
    

    
} 

header("Location:/adopcioncom/views/mascota_adoptada.php");

?>  