<?php 
$titulo = "Pequeños Amigos - Centro de Adopción";
include('views/header.php'); 
?>

<nav class="p-6 flex justify-between items-center max-w-7xl mx-auto w-full">
    <div class="flex items-center gap-2">
        <div class="w-10 h-10 bg-brand-green rounded-full flex items-center justify-center text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        <span class="text-2xl font-bold text-brand-green">Pequeños Amigos</span>
    </div>
    
    <div class="space-x-4">
        <a href="views/login.php" class="px-6 py-2 bg-brand-green text-white font-semibold rounded-full hover:opacity-90 transition-all inline-block">
            Iniciar Sesión
        </a>
        <a href="views/sign_in.php" class="px-6 py-2 bg-brand-green text-white font-semibold rounded-full hover:opacity-90 transition-all inline-block">
            Registrarse
        </a>
    </div>
</nav>

<main class="flex-grow flex items-center px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-8">
            <h1 class="text-5xl lg:text-7xl leading-tight font-bold text-brand-dark">
                Encuentra a tu <br>
                <span class="text-brand-green italic">compañero ideal</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-md">
                Bienvenido al sistema de gestión de Pequeños Amigos. Facilitamos el encuentro entre corazones y patitas.
            </p>
            
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="views/sign_in.php" class="px-8 py-4 bg-brand-orange text-white font-bold rounded-2xl text-lg hover:shadow-xl transition-all active:scale-95 inline-block">
                    Comenzar Ahora
                </a>
            </div>
        </div>

        <div class="relative">
            <img 
                src="images/perro-index.avif" 
                alt="Perro" 
                class="w-full h-[500px] object-cover rounded-[3rem] shadow-2xl relative z-10"
            >
        </div>
    </div>
</main>

<footer class="p-8 text-center text-gray-400 text-sm">
    &copy; 2026 Pequeños Amigos
</footer>

</body>
</html>