<?php
require_once '../controllers/auth.php';
verificarSesion();

require_once '../bd/conexion.php'; 
require_once '../bd/consultas.php';
$titulo = "Lista de Mascotas - Pequeños Amigos";
include('header.php');

$por_pagina = 5;
$pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $por_pagina) - $por_pagina : 0;

$mascotas = obtenerMascotasPaginadasBD($pdo, $inicio, $por_pagina);

$total = contarMascotasBD($pdo);
$paginas_totales = ceil($total / $por_pagina);
?>

<main class="max-w-7xl mx-auto p-6 lg:p-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="serif text-4xl font-bold text-brand-dark">Lista de Mascotas</h2>
            <p class="text-gray-500 font-medium">Gestiona los residentes actuales del centro.</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="/adopcioncom/views/dashboard.php" class="px-5 py-2 bg-white text-brand-dark font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all text-sm">
                ← Inicio
            </a>
            <a href="/adopcioncom/views/mis_mascotas.php" class="px-5 py-2 bg-brand-green text-white font-bold rounded-xl hover:opacity-90 transition-all text-sm shadow-md shadow-green-900/10">
                Mis Mascotas
            </a>
            <a href="/adopcioncom/views/mascotas_lista_sin_cuidador.php" class="px-5 py-2 bg-brand-orange text-white font-bold rounded-xl hover:opacity-90 transition-all text-sm shadow-md shadow-orange-900/10">
                Sin Asignar
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
                        <th class="px-6 py-5 text-xs font-bold uppercase text-gray-400 tracking-wider">Cuidador</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (!empty($mascotas)): ?>
                        <?php foreach ($mascotas as $m): ?>
                        <tr class="hover:bg-brand-cream/20 transition-colors">
                            <td class="px-6 py-5 font-bold text-brand-dark"><?= $m['nombre_mascota'] ?></td>
                            <td class="px-6 py-5 text-gray-600">
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold uppercase italic">
                                    <?= $m['especie'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-gray-600"><?= $m['edad_meses'] ?> meses</td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 <?= $m['estado'] === 'Disponible' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' ?> rounded-full text-xs font-bold uppercase">
                                    <?= $m['estado'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-gray-600"><?= $m['genero'] ?></td>
                            <td class="px-6 py-5 text-gray-600"><?= $m['peso_g'] ?>g</td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-brand-green/20 text-brand-green rounded-full flex items-center justify-center text-[10px] font-bold">
                                        <?= strtoupper(substr($m['cuidador'], 0, 1)) ?>
                                    </div>
                                    <span class="text-sm font-medium text-brand-dark"><?= $m['cuidador'] ?></span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">
                                No hay mascotas registradas con cuidador.
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
               class="w-10 h-10 flex items-center justify-center rounded-xl font-bold transition-all <?= $i == $pagina ? 'bg-brand-green text-white shadow-lg shadow-green-900/20' : 'bg-white text-gray-400 hover:text-brand-green border border-gray-100' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

</main>

</body>
</html>
