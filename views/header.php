<?php 
if (!isset($titulo)) {
    $titulo = "Pequeños Amigos";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#7C9070',
                        'brand-orange': '#D98C5F',
                        'brand-cream': '#FFFBF2',
                        'brand-dark': '#2D2727',
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="styles/tailwind_index.css">
</head>
<body class="bg-brand-cream min-h-screen flex flex-col">

<?php if (isset($_GET['msj'])): ?>
    <div class="fixed top-4 left-0 right-0 z-50 px-4">
        <div id="notificacion-msj" class="max-w-md mx-auto bg-white border-l-4 border-brand-orange shadow-xl p-4 rounded-r-lg" style="transition: opacity 0.5s ease;">
            <div class="flex items-center">
                <div class="py-1 text-brand-orange">
                    <svg class="fill-current h-6 w-6 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm1-5h-2v-2h2v2zm0-4h-2V5h2v6z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-brand-dark">Notificación</p>
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($_GET['msj']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alerta = document.getElementById('notificacion-msj');
            if (alerta) {
                setTimeout(() => {
                    alerta.style.opacity = '0';
                    setTimeout(() => alerta.remove(), 500);
                }, 4000);
                const url = new URL(window.location);
                url.searchParams.delete('msj');
                window.history.replaceState({}, document.title, url.pathname);
            }
        });
    </script>
<?php endif; ?>