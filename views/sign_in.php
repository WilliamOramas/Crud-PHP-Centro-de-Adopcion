<?php
session_start();
if (isset($_SESSION['cedula'])) {
    header("Location: inicio.php");
    exit();
}
$titulo = "Registro de Empleado";
include('header.php');
?>

<div class="flex items-center justify-center p-4 min-h-[90vh]">
    <div class="max-w-md w-full bg-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-50 relative overflow-hidden">
        
        <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-green/5 rounded-full"></div>
        <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-brand-orange/5 rounded-full"></div>

        <div class="text-center mb-8 relative">
            <h1 class="serif text-4xl font-bold text-brand-green mb-2">Únete al equipo</h1>
            <p class="text-gray-500 font-medium">Crea tu cuenta de empleado</p>
        </div>

        <form id="registroForm" action="/adopcioncom/controllers/registrar_empleado.php" method="POST" class="space-y-4 relative">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Ej: Ana" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" title="Solo se permiten letras" required
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Apellido</label>
                    <input type="text" name="apellido" id="apellido" placeholder="Ej: Pérez" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" title="Solo se permiten letras" required
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all text-sm">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Cédula de Identidad</label>
                <input type="text" name="cedula" id="cedula" placeholder="Ej: 25123456" 
                       pattern="\d{6,8}" title="La cédula debe tener entre 6 y 8 números" required
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all text-sm">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres, una mayúscula y un número" 
                       pattern="^(?=.*[A-Z])(?=.*\d).{8,40}$" 
                       title="Mínimo 8 caracteres, debe incluir al menos una mayúscula y un número" required
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all text-sm">
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-brand-dark ml-1 uppercase">Confirmar Contraseña</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Repite tu contraseña" 
                       required
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-green outline-none transition-all text-sm">
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-brand-green text-white font-bold rounded-2xl text-lg btn-transition shadow-lg shadow-green-900/10 active:scale-[0.98] mt-4">
                Crear mi cuenta
            </button>
        </form>
        
        <div class="mt-8 pt-6 border-t border-gray-100 text-center space-y-4">
            <p class="text-gray-600 font-medium text-sm">
                ¿Ya tienes cuenta? 
                <a href="/adopcioncom/views/login.php" class="text-brand-orange font-bold hover:underline underline-offset-4 ml-1">Inicia sesión</a>
            </p> 
            
            <a href="/adopcioncom/index.php" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-brand-green transition-all group">
                <span class="group-hover:-translate-x-1 transition-transform">&larr;</span> 
                Volver al inicio
            </a>
        </div>
    </div>
</div>

<script>
    document.getElementById('registroForm').addEventListener('submit', function(event) {
        const pass = document.getElementById('password').value;
        const confirmPass = document.getElementById('confirm_password').value;
        const passRegex = /^(?=.*[A-Z])(?=.*\d).{8,40}$/;

        if (!passRegex.test(pass)) {
            event.preventDefault();
            window.location.href = `sign_in.php?msj=${encodeURIComponent("La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.")}&tipo=error`;
            return;
        }

        if (pass !== confirmPass) {
            event.preventDefault();
            window.location.href = `sign_in.php?msj=${encodeURIComponent("¡Ups! Las contraseñas no coinciden.")}&tipo=error`;
            return;
        }
    });
</script>

</body>
</html>