<?php
session_start(); // Inicia la sesion
$titulo = "Inicio";
include('header.php'); 

// Si no existe la variable de sesion cedula redirige al inicio de sesion
if (!isset($_SESSION['cedula'])) { 
    header("Location: /adopcioncom/views/login.php");
    exit();
}
?>

<body>
    <h1>Bienvenido(a), <?php echo $_SESSION['nombre_completo']; ?></h1> 
    <p>Este es el panel administrativo del centro de adopción "Pequeños Amigos"".</p>
    <nav>
        <a href="mascotas_lista.php">Gestionar Mascotas</a> | 
        <a href="/adopcioncom/controllers/loginout.php">Cerrar Sesión</a>
    </nav>
    
</body>
