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

<div class="flex items-center justify-center p-6 min-h-[80vh]">
    <div class="max-w-2xl w-full bg-white p-10 md:p-14 rounded-[3rem] shadow-2xl shadow-gray-200/50 border border-gray-50 relative overflow-hidden text-center">
        
        <div class="absolute -top-16 -right-16 w-40 h-40 bg-brand-green/10 rounded-full"></div>
        <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-brand-orange/10 rounded-full"></div>

        <div class="inline-flex items-center justify-center w-20 h-20 bg-brand-green/10 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h1 class="serif text-4xl font-bold text-brand-dark mb-4">
            Bienvenido(a), <span class="text-brand-green"><?php echo $_SESSION['nombre_completo']; ?></span>
        </h1> 
        
        <p class="text-gray-500 text-lg mb-10 max-w-md mx-auto">
            Este es el panel administrativo del centro de adopción "Pequeños Amigos".
        </p>
        
        <nav class="flex flex-col md:flex-row items-center justify-center gap-4">
            <a href="mascotas_lista.php" class="w-full md:w-auto px-8 py-3 bg-brand-green text-white font-bold rounded-2xl btn-transition shadow-lg">
                Gestionar Mascotas
            </a>
            
            <a href="/adopcioncom/controllers/loginout.php" class="w-full md:w-auto px-8 py-3 border-2 border-brand-orange text-brand-orange font-bold rounded-2xl hover:bg-brand-orange hover:text-white transition-all">
                Cerrar Sesión
            </a>
        </nav>
        
    </div>
</div>

</body>
</html>