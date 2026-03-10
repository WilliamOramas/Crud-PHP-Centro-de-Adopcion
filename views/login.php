<?php
session_start();
if (isset($_SESSION['cedula'])) {
    header("Location: inicio.php");
    exit();
}
$titulo = "Iniciar Sesión";
include('header.php');
?>

<div class="flex items-center justify-center p-4 min-h-[80vh]">
    <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-50 relative overflow-hidden">
        
        <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-green/5 rounded-full"></div>
        <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-brand-orange/5 rounded-full"></div>

        <div class="text-center mb-10 relative">
            <h1 class="text-4xl font-bold text-brand-green mb-2">Hola de nuevo</h1>
            <p class="text-gray-500 font-medium">Ingresa a tu cuenta</p>
        </div>

        <form id="loginForm" action="/adopcioncom/controllers/login_procesar.php" method="POST" class="space-y-6 relative">
            <div class="space-y-2">
                <label for="cedula" class="block text-sm font-bold text-brand-dark">Cédula de Identidad</label>
                <input type="text" name="cedula" id="cedula" required
                       class="w-full px-5 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-brand-green outline-none transition-all">
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label for="password" class="text-sm font-bold text-brand-dark">Contraseña</label>
                </div>
                <input type="password" name="password" id="password" required
                       class="w-full px-5 py-4 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:border-brand-green outline-none transition-all">
            </div>

            <button type="submit" class="w-full py-4 bg-brand-green text-white font-bold rounded-2xl text-lg hover:opacity-90 transition-all shadow-lg active:scale-95">
                Ingresar al Sistema
            </button>
        </form>
        
        <div class="mt-10 pt-8 border-t border-gray-100 text-center space-y-4">
            <p class="text-gray-600">¿Aún no eres parte? <a href="sign_in.php" class="text-brand-orange font-bold">Crea tu cuenta</a></p> 
            <a href="/adopcioncom/index.php" class="text-sm font-bold text-gray-400 hover:text-brand-green block">← Volver al inicio</a>
        </div>
    </div>
</div>

</body>
</html>