<?php
session_start(); // Inicia la sesion
require_once '../bd/conexion.php'; // Para conectarse a la base de datos
require_once '../bd/consultas.php'; // Para importar las funciones
require_once '../controllers/validar_datos/funciones.php'; // Para importar las validaciones
$titulo = "Pequeños amigos";
include('header.php');

// Si no existe la variable de sesion cedula redirige al inicio de sesion
if (!isset($_SESSION['cedula'])) { header("Location: /adopcioncom/views/login.php"); exit(); }

// Verifica si existe un parámetro'id'
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Valida la id de la mascota
    if (ValidarIdMascota($id) == true) {

        $stmt = $pdo->prepare("SELECT * FROM mascotas_sin_asignar WHERE id_mascotas_sin_asignar = ?");
        $stmt->execute([$id]);
        $mascota = $stmt->fetch();
    } else {
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("error al buscar mascota a editar"));
        exit();
    }
    if (!$mascota)  {
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("error mascota no encontrada"));
        exit();
    }
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_mascotas_sin_asignar'];
    $nombre = $_POST['nombre_mascota'];
    $especie = $_POST['especie'];
    $edad = $_POST['edad_meses'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];
    $peso = $_POST['peso_g'];

    // Valida los datos de la mascota
    if (validarEditarMacotasSinAsignar($id, $nombre, $especie, $edad, $genero, $estado, $peso) == false) {
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("Datos invalidos ingresados"));
        exit();
    }
    
    // Actualiza los datos de la mascota
    editarMascotaSinAsignar($pdo, $nombre, $especie, $edad, $genero, $estado, $peso, $id);
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
                const url = new URL(window.location);
                url.searchParams.delete('msj');
                window.history.replaceState({}, document.title, url.pathname);
            }, 3000);
        </script>
    <?php endif; ?>

    <h2 class="text-center mb-4">Editar Registro de Mascota</h2>

    <form id="formEditarMascota" method="POST">
        <input type="hidden" name="id_mascotas_sin_asignar" value="<?= $mascota['id_mascotas_sin_asignar'] ?>">

        <label for="nombre_mascota">Nombre de la Mascota</label>
        <input type="text" name="nombre_mascota" id="nombre_mascota" 
               value="<?= htmlspecialchars($mascota['nombre_mascota']) ?>" 
               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" 
               title="Solo se permiten letras" required>

        <label for="especie">Especie</label>
        <input type="text" name="especie" id="especie" 
               value="<?= htmlspecialchars($mascota['especie']) ?>"
               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" 
               title="Solo se permiten letras" required>

        <label for="edad_meses">Edad (meses)</label>
        <input type="number" name="edad_meses" id="edad_meses" 
               value="<?= $mascota['edad_meses'] ?>" min="0" required>

        <label for="genero">Género</label>
        <select name="genero" id="genero">
            <option value="Macho" <?= $mascota['genero'] == 'Macho' ? 'selected' : '' ?>>Macho</option>
            <option value="Hembra" <?= $mascota['genero'] == 'Hembra' ? 'selected' : '' ?>>Hembra</option>
        </select>

        <label for="estado">Estado de Salud</label>
        <select name="estado" id="estado">
            <option value="Disponible" <?= $mascota['estado'] == 'Disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="En tratamiento" <?= $mascota['estado'] == 'En tratamiento' ? 'selected' : '' ?>>En tratamiento</option>
        </select>

        <label for="peso_g">Peso (Gramos)</label>
        <input type="number" step="0.01" name="peso_g" id="peso_g" 
               value="<?= $mascota['peso_g'] ?>" min="1" required>

        <button type="submit">Actualizar datos</button>
        <div class="text-center mt-3">
            <a href="/adopcioncom/views/mascotas_lista_sin_cuidador.php">Cancelar edición</a>
        </div>
    </form>
</div>

<script>
    // Validación de seguridad antes de enviar
    document.getElementById('formEditarMascota').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre_mascota').value.trim();
        const especie = document.getElementById('especie').value.trim();
        const peso = parseFloat(document.getElementById('peso_g').value);

        if (nombre.length < 2 || especie.length < 2) {
            e.preventDefault();
            alert("El nombre y la especie deben tener al menos 2 caracteres.");
        } else if (peso <= 0) {
            e.preventDefault();
            alert("El peso debe ser un valor positivo.");
        }
    });
</script>
</body>
</html>