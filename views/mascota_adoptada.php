<?php
$titulo = "¡Felicidades por tu adopción! - Pequeños Amigos";
include('header.php');
?>

<style>
    .bounce-subtle {
        animation: bounce-custom 2s infinite;
    }
    @keyframes bounce-custom {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<main class="min-h-[90vh] flex items-center justify-center p-6 bg-brand-cream/10">
    <div class="max-w-2xl w-full bg-white rounded-[3rem] shadow-2xl shadow-gray-200/60 border border-gray-100 p-8 md:p-16 text-center relative overflow-hidden">
        
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-green/5 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-brand-orange/5 rounded-full blur-3xl opacity-20"></div>

        <div class="relative z-10">
            <div class="inline-flex flex-col items-center justify-center mb-6 bounce-subtle">
                <div class="relative">
                    <i class="bi bi-dog text-brand-green" style="font-size: 4rem;"></i>
                    <i class="bi bi-heart-fill text-brand-orange absolute -top-2 -right-2 animate-pulse" style="font-size: 1.5rem;"></i>
                </div>
            </div>

            <h1 class="serif text-4xl md:text-5xl font-extrabold text-brand-dark mb-4 tracking-tight">
                ¡Adopción Exitosa!
            </h1>
            
            <p class="text-lg text-gray-500 font-medium mb-10 leading-relaxed px-4">
                ¡Qué gran noticia! Has cambiado una vida hoy. Gracias por confiar en <br>
                <span class="text-brand-green font-bold">Pequeños Amigos</span> para encontrar a tu nuevo compañero.
            </p>

            <div class="border-t border-gray-100 my-8 pt-8">
                <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-6 italic">¿Qué deseas hacer ahora?</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="/adopcioncom/views/inicio.php" 
                       class="flex flex-col items-center p-4 rounded-2xl bg-gray-50 hover:bg-brand-green hover:text-white transition-all duration-300 group border border-transparent hover:border-brand-green shadow-sm hover:shadow-md">
                        <i class="bi bi-house-door text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-bold tracking-tight">Ir al Inicio</span>
                    </a>

                    <a href="mascotas_lista.php" 
                       class="flex flex-col items-center p-4 rounded-2xl bg-gray-50 hover:bg-brand-orange hover:text-white transition-all duration-300 group border border-transparent hover:border-brand-orange shadow-sm hover:shadow-md">
                        <i class="bi bi-search text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-bold tracking-tight">Ver Mascotas</span>
                    </a>

                    <a href="mis_mascotas.php" 
                       class="flex flex-col items-center p-4 rounded-2xl bg-gray-50 hover:bg-brand-dark hover:text-white transition-all duration-300 group border border-transparent hover:border-brand-dark shadow-sm hover:shadow-md">
                        <i class="bi bi-journal-check text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm font-bold tracking-tight">Mis Cargos</span>
                    </a>
                </div>
            </div>

            <p class="text-xs text-gray-400 mt-8">
                Centro de Adopción Digital &copy; 2026
            </p>
        </div>
    </div>
</main>