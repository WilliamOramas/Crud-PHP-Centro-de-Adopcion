<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo ?>
 </title>
    
<link rel="stylesheet" href="/adopcioncom/views/styles/bootstrap_patch.css">

</head>

<?php if (isset($_GET['msj'])): ?>
    <div class="container mt-3">
        <div id="notificacion-msj" class="alert alert-secondary shadow-sm text-center border-0" role="alert" style="transition: opacity 0.5s ease;">
            <i class="bi bi-info-circle-fill me-2"></i>
            <?php echo htmlspecialchars($_GET['msj']); ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alerta = document.getElementById('notificacion-msj');
            
            if (alerta) {
                // 1. Programar la desaparición visual tras 3 segundos
                setTimeout(() => {
                    alerta.style.opacity = '0';
                    setTimeout(() => alerta.remove(), 500); // Elimina del DOM tras el desvanecimiento
                }, 3000);

                // 2. LIMPIAR URL: Borra el "?msj=..." de la barra de direcciones
                // Esto evita que el mensaje salga de nuevo si el usuario pulsa F5
                const url = new URL(window.location);
                url.searchParams.delete('msj');
                window.history.replaceState({}, document.title, url.pathname);
            }
        });
    </script>
<?php endif; ?>