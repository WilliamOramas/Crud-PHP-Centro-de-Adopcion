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

$sql = "SELECT m.*  
        FROM mascotas_sin_asignar m 
        LIMIT $inicio, $por_pagina";
$mascotas_sin_asignar = $pdo->query($sql)->fetchAll();

$total = $pdo->query("SELECT COUNT(*) FROM mascotas_sin_asignar")->fetchColumn();
$paginas_totales = ceil($total / $por_pagina);
?>
<a href="mascotas_crear.php">Agregar mascota</a>| 
<a href="mascotas_lista.php">Volver a lista de mascotas</a>
<table border="1">
    <tr>
         <th>Nombre de la mascota</th><th>Especie</th><th>Edad</th><th>Estado</th><th>Genero</th><th>Peso_g</th><th>Acciones</th>

    </tr>
    <?php foreach ($mascotas_sin_asignar as $m): ?>
    <tr>
        <td><?= $m['nombre_mascota'] ?></td>
        <td><?= $m['especie'] ?></td>
        <td><?= $m['edad_meses'] ?> meses</td>
        <td><?= $m['estado'] ?></td>
        <td><?= $m['genero'] ?></td>
        <td><?= $m['peso_g'] ?></td>
         <td>
            <a href="/adopcioncom/controllers/mis_mascotas_asignar.php?id=<?= $m['id_mascotas_sin_asignar'] ?>">Asignar</a> 
            <a href="mascotas_lista_sin_cuidador_editar.php?id=<?= $m['id_mascotas_sin_asignar'] ?>">Editar</a>
            <a href="/adopcioncom/controllers/mascotas_lista_sin_cuidador_eliminar.php?id=<?= $m['id_mascotas_sin_asignar'] ?>" onclick="return confirm('¿Seguro que desea eliminar este registro?')">Eliminar</a>
        </td>
       </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php for($i=1; $i<=$paginas_totales; $i++): ?>
    <a href="?p=<?= $i ?>"><?= $i ?></a>
<?php endfor; ?>