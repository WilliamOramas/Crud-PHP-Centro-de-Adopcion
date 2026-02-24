<?php
session_start(); // Inicia la sesion
require_once '../bd/conexion.php'; // Para conectarse a la base de datos
require_once '../bd/consultas.php';  // Para importar las funciones
require_once '../controllers/validar_datos/funciones.php'; // Para importar las validaciones
$titulo = "Pequeños amigos";
include('header.php');

// Si no existe la variable de sesion cedula redirige al inicio de sesion
if (!isset($_SESSION['cedula'])) { header("Location: /adopcioncom/views/login.php"); exit(); }

// Verifica si la pagina se cargo mediante el envio de un formulario 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_mascota = $_POST['nombre_mascota'];
    $especie = $_POST['especie'];
    $edad = $_POST['edad_meses'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];
    $peso = $_POST['peso_g'];
    $emp_id = $_SESSION['cedula'];

    // Validacion de la creacion de la mascota
    if (validarCreacionDeMascotasSinAsignar($nombre_mascota, $especie, $edad, $genero, $estado, $peso)==false) {
    
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("Datos escritos incorrectamente"));
        exit();

    }
    // Registra la mascota 
    registrarMascotaConValidacionBD($pdo,$emp_id,$estado,$nombre_mascota,$especie, $edad, $genero, $peso);
}
?>

<div class="container">
    <?php if (isset($_GET['msj'])): ?>
        <div id="alerta-notif" class="alert alert-secondary text-center shadow-sm border-0" 
             style="background-color: #f8f9fa; color: #343a40; transition: opacity 0.5s ease;">
            <i class="bi bi-info-circle-fill me-2"></i>
            <?php echo htmlspecialchars($_GET['msj']); ?>
        </div>
        <script>
            setTimeout(() => {
                const alerta = document.getElementById('alerta-notif');
                if(alerta) {
                    alerta.style.opacity = '0';
                    setTimeout(() => alerta.remove(), 500);
                }
                // Limpia la URL para evitar que el msj vuelva al recargar
                const url = new URL(window.location);
                url.searchParams.delete('msj');
                window.history.replaceState({}, document.title, url.pathname);
            }, 3000);
        </script>
    <?php endif; ?>

    <h2 class="text-center mb-4">Registrar Mascota</h2>

    <form id="formMascota" method="POST">
        <label for="nombre_mascota">Nombre de la Mascota</label>
        <input type="text" name="nombre_mascota" id="nombre_mascota" 
               placeholder="Nombre de la mascota (ej: Firulais)" 
               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" 
               title="Solo se permiten letras" required>

        <label for="especie">Especie</label>
        <input type="text" name="especie" id="especie" 
               placeholder="Especie (ej: Perro)" 
               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" 
               title="Solo se permiten letras" required>

        <label for="edad_meses">Edad (Meses)</label>
        <input type="number" name="edad_meses" id="edad_meses" 
               placeholder="Edad en meses" min="0" max="600" required>

        <label for="genero">Género</label>
        <select name="genero" id="genero">
            <option value="Macho">Macho</option>
            <option value="Hembra">Hembra</option>
        </select>

        <label for="estado">Estado de Salud</label>
        <select name="estado" id="estado">
            <option value="Disponible">Disponible</option>
            <option value="En tratamiento">En tratamiento</option>
        </select>

        <label for="peso_g">Peso (Gramos)</label>
        <input type="number" step="0.01" name="peso_g" id="peso_g" 
               placeholder="Peso en g (ej: 500.50)" min="1" required>

        <button type="submit">Registrar mascota</button>
    </form>

    <div class="text-center mt-3">
        <a href="/adopcioncom/views/mascotas_lista_sin_cuidador.php">Volver a la lista</a>
    </div>
</div>

<script>
    // Validación de seguridad en el front
    document.getElementById('formMascota').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre_mascota').value.trim();
        const especie = document.getElementById('especie').value.trim();
        const peso = parseFloat(document.getElementById('peso_g').value);

        if (nombre.length < 2 || especie.length < 2) {
            e.preventDefault();
            alert("Por favor, ingresa nombres y especies válidos (mínimo 2 letras).");
        } else if (peso <= 0) {
            e.preventDefault();
            alert("El peso debe ser mayor a 0 gramos.");
        }
    });
</script>