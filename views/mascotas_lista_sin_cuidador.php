<?php
session_start();

if (!isset($_SESSION['cedula'])) { 
    header("Location: /adopcioncom/views/login.php"); 
    exit(); 
}

require_once '../bd/conexion.php'; 
$titulo = "Mascotas sin Asignar - Pequeños Amigos";
include('header.php');

$por_pagina = 5;
$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $por_pagina) - $por_pagina : 0;

$sql = "SELECT m.* FROM mascotas_sin_asignar m LIMIT $inicio, $por_pagina";
$mascotas_sin_asignar = $pdo->query($sql)->fetchAll();

$total = $pdo->query("SELECT COUNT(*) FROM mascotas_sin_asignar")->fetchColumn();
$paginas_totales = ceil($total / $por_pagina);
?>

<main class="max-w-7xl mx-auto p-6 lg:p-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="serif text-4xl font-bold text-brand-dark">Mascotas sin Asignar</h2>
            <p class="text-gray-500 font-medium">Animalitos esperando por un cuidador encargado.</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="mascotas_lista.php" class="px-5 py-2 bg-white text-brand-dark font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all text-sm shadow-sm">
                ← Volver a la lista
            </a>
            <a href="mascotas_crear.php" class="px-5 py-2 bg-brand-green text-white font-bold rounded-xl hover:opacity-90 transition-all text-sm shadow-md shadow-green-900/10">
                + Agregar Mascota
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider">Nombre</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider">Especie</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider">Edad</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider">Estado</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider">Género</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider">Peso</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (!empty($mascotas_sin_asignar)): ?>
                        <?php foreach ($mascotas_sin_asignar as $m): ?>
                        <tr class="hover:bg-brand-cream/20 transition-colors text-sm">
                            <td class="px-6 py-5 font-bold text-brand-dark"><?= htmlspecialchars($m['nombre_mascota']) ?></td>
                            <td class="px-6 py-5">
                                <span class="px-2 py-1 bg-gray-100 rounded-lg text-[10px] font-bold uppercase text-gray-500 italic">
                                    <?= htmlspecialchars($m['especie']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-gray-600"><?= $m['edad_meses'] ?> meses</td>
                            <td class="px-6 py-5 text-gray-600"><?= htmlspecialchars($m['estado']) ?></td>
                            <td class="px-6 py-5 text-gray-600"><?= htmlspecialchars($m['genero']) ?></td>
                            <td class="px-6 py-5 text-gray-600"><?= $m['peso_g'] ?>g</td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                <a href="/adopcioncom/controllers/mis_mascotas_asignar.php?id=<?= $m['id_mascotas_sin_asignar'] ?>" 
                                class="px-3 py-1 bg-brand-green/10 text-brand-green font-bold rounded-lg hover:bg-brand-green hover:!text-white transition-all text-xs" title="Asignarme">
                                    Asignar
                                </a>
                                    <a href="mascotas_lista_sin_cuidador_editar.php?id=<?= $m['id_mascotas_sin_asignar'] ?>" 
                                       class="px-3 py-1 bg-blue-50 text-blue-600 font-bold rounded-lg hover:bg-blue-600 hover:text-white transition-all text-xs">
                                        Editar
                                    </a>
                                    <a href="/adopcioncom/controllers/mascotas_lista_sin_cuidador_eliminar.php?id=<?= $m['id_mascotas_sin_asignar'] ?>" 
                                       onclick="return confirm('¿Seguro que desea eliminar este registro?')"
                                       class="px-3 py-1 bg-red-50 text-red-600 font-bold rounded-lg hover:bg-red-600 hover:text-white transition-all text-xs">
                                        Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">
                                No hay mascotas pendientes de asignación.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($paginas_totales > 1): ?>
    <div class="mt-8 flex justify-center gap-2">
        <?php for($i=1; $i<=$paginas_totales; $i++): ?>
            <a href="?p=<?= $i ?>" 
               class="w-10 h-10 flex items-center justify-center rounded-xl font-bold transition-all <?= $i == $pagina ? 'bg-brand-orange text-white shadow-lg shadow-orange-900/20' : 'bg-white text-gray-400 border border-gray-100' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

</main>

</body>
</html>