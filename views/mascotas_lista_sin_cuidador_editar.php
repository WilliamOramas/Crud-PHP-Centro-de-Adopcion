<?php
session_start();
require_once '../bd/conexion.php'; 
require_once '../bd/consultas.php'; 
require_once '../controllers/validar_datos/funciones.php'; 
$titulo = "Editar Mascota - Pequeños Amigos";
include('header.php');

if (!isset($_SESSION['cedula'])) { header("Location: /adopcioncom/views/login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
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

    if (validarEditarMacotasSinAsignar($id, $nombre, $especie, $edad, $genero, $estado, $peso) == false) {
        header("Location: /adopcioncom/views/mascotas_lista_sin_cuidador.php?msj=" . urlencode("Datos invalidos ingresados"));
        exit();
    }
    editarMascotaSinAsignar($pdo, $nombre, $especie, $edad, $genero, $estado, $peso, $id);
}
?>

<div class="flex items-center justify-center p-6 min-h-[90vh]">
    <div class="max-w-2xl w-full bg-white p-8 md:p-12 rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 relative">
        
        <?php if (isset($_GET['msj'])): ?>
            <div id="alerta-notif" class="absolute top-6 left-1/2 -translate-x-1/2 w-11/12 z-20 bg-brand-orange text-white px-6 py-3 rounded-2xl shadow-lg text-center font-bold transition-opacity duration-500">
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

        <div class="text-center mb-8">
            <h2 class="serif text-4xl font-bold text-brand-green mb-2">Editar Mascota</h2>
            <p class="text-gray-500 font-medium italic">Modificando a: <?= htmlspecialchars($mascota['nombre_mascota']) ?></p>
        </div>

        <form id="formEditarMascota" method="POST" class="space-y-5">
            <input type="hidden" name="id_mascotas_sin_asignar" value="<?= $mascota['id_mascotas_sin_asignar'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Nombre</label>
                    <input type="text" name="nombre_mascota" id="nombre_mascota" 
                           value="<?= htmlspecialchars($mascota['nombre_mascota']) ?>" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" 
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all" required>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Especie</label>
                    <input type="text" name="especie" id="especie" 
                           value="<?= htmlspecialchars($mascota['especie']) ?>"
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" 
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all" required>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Edad (Meses)</label>
                    <input type="number" name="edad_meses" id="edad_meses" 
                           value="<?= $mascota['edad_meses'] ?>" min="0"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all" required>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Peso (Gramos)</label>
                    <input type="number" step="0.01" name="peso_g" id="peso_g" 
                           value="<?= $mascota['peso_g'] ?>" min="1"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all" required>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Género</label>
                    <select name="genero" id="genero" class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all appearance-none cursor-pointer">
                        <option value="Macho" <?= $mascota['genero'] == 'Macho' ? 'selected' : '' ?>>Macho</option>
                        <option value="Hembra" <?= $mascota['genero'] == 'Hembra' ? 'selected' : '' ?>>Hembra</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Estado de Salud</label>
                    <select name="estado" id="estado" class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all appearance-none cursor-pointer">
                        <option value="Disponible" <?= $mascota['estado'] == 'Disponible' ? 'selected' : '' ?>>Disponible</option>
                        <option value="En tratamiento" <?= $mascota['estado'] == 'En tratamiento' ? 'selected' : '' ?>>En tratamiento</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-brand-green text-white font-bold rounded-2xl text-lg btn-transition shadow-lg shadow-green-900/10 mt-4 active:scale-95">
                Actualizar datos
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="/adopcioncom/views/mascotas_lista_sin_cuidador.php" class="text-sm font-bold text-gray-400 hover:text-brand-orange transition-all">
                Cancelar edición
            </a>
        </div>
    </div>
</div>

<script>
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