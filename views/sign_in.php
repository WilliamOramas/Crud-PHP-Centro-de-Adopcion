<?php
$titulo = "Registro de Empleado";
include('header.php');
?>

<body>
    <div class="container mt-4">
        <h2>Registro - Pequeños Amigos</h2>
        <form id="registroForm" action="/adopcioncom/controllers/registrar_empleado.php" method="POST">
            
            <input type="text" name="nombre" id="nombre" placeholder="Nombre" 
                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" title="Solo se permiten letras" required>
            
            <input type="text" name="apellido" id="apellido" placeholder="Apellido" 
                   pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+" title="Solo se permiten letras" required>

            <input type="text" name="cedula" id="cedula" placeholder="Cédula" 
                   pattern="\d{7,10}" title="La cédula debe tener entre 7 y 10 números" required>

            <input type="password" name="password" id="password" placeholder="Contraseña (Mín. 6 caracteres)" 
                   minlength="6" required>
            
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar Contraseña" 
                   minlength="6" required>

            <button type="submit">Registrarse</button>
        </form>

        <div class="text-center mt-3">
            ¿Ya tienes cuenta? <a href="/adopcioncom/views/login.php">Inicia Sesión Aquí</a> 
            <a href="/adopcioncom/index.php">Inicio</a>
        </div>
    </div>

    <script>
        document.getElementById('registroForm').addEventListener('submit', function(event) {
            const pass = document.getElementById('password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();

            // 1. Validar que las contraseñas sean idénticas
            if (pass !== confirmPass) {
                event.preventDefault(); // Detener envío
                alert("¡Ups! Las contraseñas no coinciden. Por favor, verifícalas.");
                return;
            }

            // 2. Validar que nombre y apellido no sean solo espacios
            if (nombre.length < 2 || apellido.length < 2) {
                event.preventDefault();
                alert("Por favor, ingresa un nombre y apellido válidos.");
                return;
            }
        });
    </script>
</body>
</html>