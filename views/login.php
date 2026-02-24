<?php
$titulo = "Iniciar Sesion";
include('header.php');
?>

<body>
    <div class="container mt-4">
        <h2>Inicio de Sesión - Pequeños Amigos</h2>
        
        <form id="loginForm" action="/adopcioncom/controllers/login_procesar.php" method="POST" class="needs-validation">
            
            <label for="cedula">Cédula</label>
            <input type="text" 
                   name="cedula" 
                   id="cedula"
                   placeholder="Ej: 25123456" 
                   pattern="\d+" 
                   title="La cédula debe contener solo números"
                   minlength="7" 
                   maxlength="10" 
                   required>

            <label for="password">Contraseña</label>
            <input type="password" 
                   name="password" 
                   id="password"
                   placeholder="Mínimo 6 caracteres" 
                   minlength="6" 
                   required>

            <button type="submit">Ingresar</button>
        </form>
        
        <div class="text-center mt-3">
            <p>¿No tienes cuenta? <a href="sign_in.php">Regístrate aquí</a></p> 
            <a href="/adopcioncom/index.php" class="btn btn-link">Volver al Inicio</a>
        </div>
    </div>

    <script>
        // Validación extra con JavaScript
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const cedula = document.getElementById('cedula').value.trim();
            const password = document.getElementById('password').value;

            // 1. Evitar que envíen solo espacios en blanco
            if (cedula === "" || password.trim() === "") {
                event.preventDefault(); // Detiene el envío
                alert("Por favor, rellena todos los campos correctamente.");
                return;
            }

            // 2. Opcional: Validar que la cédula no tenga letras si el pattern falla
            if (isNaN(cedula)) {
                event.preventDefault();
                alert("La cédula debe ser solo números.");
            }
        });
    </script>
</body>
</html>