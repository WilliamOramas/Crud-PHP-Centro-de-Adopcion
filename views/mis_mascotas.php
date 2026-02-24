<?php
session_start(); // Inicia la sesion

// Si no existe la variable de sesion cedula redirige al inicio de sesion
if (!isset($_SESSION['cedula'])) { header("Location: /adopcioncom/views/login.php"); exit(); }
require_once '../bd/conexion.php'; // Para conectarse a la base de datos
$titulo = "Pequeños amigos";
include('header.php');

$por_pagina = 5;
$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $por_pagina) - $por_pagina : 0;
$cedula_empleado = $_SESSION['cedula'];

$sql = "SELECT m.*, e.nombre as cuidador 
        FROM mascotas m 
        JOIN empleados e ON m.cedula_empleado_encargado = e.cedula 
        WHERE m.cedula_empleado_encargado = $cedula_empleado
        LIMIT $inicio, $por_pagina";
$mascotas = $pdo->query($sql)->fetchAll();

$total = $pdo->query("SELECT COUNT(*) FROM mascotas")->fetchColumn();
$paginas_totales = ceil($total / $por_pagina);
?>
        <a href="/adopcioncom/views/mascotas_lista_sin_cuidador.php">Lista de mascotas sin asignar</a>|
        <a href="/adopcioncom/views/dashboard.php">Inicio</a> 
        <a href="mascotas_lista.php">Lista de mascotas</a> 
<table border="1">
    <tr>
          <th>Nombre de la mascota</th><th>Especie</th><th>Edad</th><th>Estado</th><th>Genero</th><th>Peso_g</th><th>Acciones</th>
    </tr>
    <?php foreach ($mascotas as $m): ?>
    <tr>
        <td><?= $m['nombre_mascota'] ?></td>
        <td><?= $m['especie'] ?></td>
        <td><?= $m['edad_meses'] ?> meses</td>
        <td><?= $m['estado'] ?></td>
        <td><?= $m['genero'] ?></td>
        <td><?= $m['peso_g'] ?></td>
        <td>
            <a href="/adopcioncom/controllers/adopcion.php?id=<?= $m['id_mascota'] ?>"onclick="return confirm('¿Seguro que desea dar en adopcion esta mascota?')">Dar en adopcion</a>
            <a href="mascotas_editar.php?id=<?= $m['id_mascota'] ?>">Editar</a>
            <a href="/adopcioncom/controllers/mascotas_eliminar.php?id=<?= $m['id_mascota'] ?>" onclick="return confirm('¿Seguro que desea eliminar este registro?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
