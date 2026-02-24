<?php
session_start(); // Inicia la de sesion
session_unset(); // Limpia las variables
session_destroy(); // Destruye la sesión
header("Location: /adopcioncom/views/login.php");
exit();
?>