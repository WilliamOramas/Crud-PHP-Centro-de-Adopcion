<?php
require_once '../controllers/auth.php';
verificarSesion();

require_once '../bd/conexion.php'; 
require_once '../bd/consultas.php';
$titulo = "Editar Mascota - Pequeños Amigos";
include('header.php');

$mascota = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mascota = obtenerMascotaPorIdBD($pdo, $id);
}

if (!$mascota) {
    header("Location: /adopcioncom/views/mis_mascotas.php?msj=" . urlencode("Mascota no encontrada o ID no válido"));
    exit();
}
?>

<main class="max-w-7xl mx-auto p-6 lg:p-10">
    
    <div class="mb-10">
        <h2 class="serif text-4xl font-bold text-brand-dark">Editar Mascota</h2>
        <p class="text-gray-500 font-medium italic">Actualiza la información de <?= htmlspecialchars($mascota['nombre_mascota']) ?></p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden max-w-2xl">
        <form action="/adopcioncom/controllers/mascotas_editar_procesar.php" method="POST" class="p-8 lg:p-12 space-y-6">
            <input type="hidden" name="id" value="<?= $mascota['id_mascota'] ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="space-y-2">
                    <label for="nombre" class="text-sm font-bold text-gray-400 uppercase tracking-wider">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($mascota['nombre_mascota']) ?>" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all">
                </div>

                <!-- Especie -->
                <div class="space-y-2">
                    <label for="especie" class="text-sm font-bold text-gray-400 uppercase tracking-wider">Especie</label>
                    <input type="text" name="especie" id="especie" value="<?= htmlspecialchars($mascota['especie']) ?>" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all">
                </div>

                <!-- Edad (meses) -->
                <div class="space-y-2">
                    <label for="edad" class="text-sm font-bold text-gray-400 uppercase tracking-wider">Edad (meses)</label>
                    <input type="number" name="edad" id="edad" value="<?= $mascota['edad_meses'] ?>" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all">
                </div>

                <!-- Peso (gramos) -->
                <div class="space-y-2">
                    <label for="peso" class="text-sm font-bold text-gray-400 uppercase tracking-wider">Peso (gramos)</label>
                    <input type="number" name="peso" id="peso" value="<?= $mascota['peso_g'] ?>" required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all">
                </div>

                <!-- Género -->
                <div class="space-y-2">
                    <label for="genero" class="text-sm font-bold text-gray-400 uppercase tracking-wider">Género</label>
                    <select name="genero" id="genero" class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all cursor-pointer">
                        <option value="Macho" <?= $mascota['genero'] == 'Macho' ? 'selected' : '' ?>>Macho</option>
                        <option value="Hembra" <?= $mascota['genero'] == 'Hembra' ? 'selected' : '' ?>>Hembra</option>
                    </select>
                </div>

                <!-- Estado -->
                <div class="space-y-2">
                    <label for="estado" class="text-sm font-bold text-gray-400 uppercase tracking-wider">Estado</label>
                    <select name="estado" id="estado" class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all cursor-pointer">
                        <option value="Disponible" <?= $mascota['estado'] == 'Disponible' ? 'selected' : '' ?>>Disponible</option>
                        <option value="En tratamiento" <?= $mascota['estado'] == 'En tratamiento' ? 'selected' : '' ?>>En tratamiento</option>
                    </select>
                </div>
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 bg-brand-green text-white font-bold py-4 rounded-2xl hover:bg-opacity-90 transition-all shadow-lg shadow-green-900/20">
                    Guardar Cambios
                </button>
                <a href="mis_mascotas.php" class="px-8 bg-gray-100 text-gray-400 font-bold py-4 rounded-2xl hover:bg-gray-200 hover:text-gray-600 transition-all text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        let formDirty = false;

        // Detectar cambios en el formulario
        form.addEventListener('input', () => {
            formDirty = true;
        });

        // Advertir antes de salir si hay cambios
        window.addEventListener('beforeunload', (e) => {
            if (formDirty) {
                e.preventDefault();
                e.returnValue = 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?';
            }
        });

        // Al enviar el formulario, permitimos la salida
        form.addEventListener('submit', () => {
            formDirty = false;
        });
    });
</script>

</body>
</html>
