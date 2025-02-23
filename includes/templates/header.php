<?php
$rutaBase = obtenerRutaBase(); // Asegúrate de que esta función esté configurada correctamente
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="<?php echo $rutaBase; ?>build/css/app.css"> <!-- Aquí agregamos el CSS -->
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="<?php echo $rutaBase; ?>index.php">
                    <img src="<?php echo $rutaBase; ?>build/img/logo.svg" alt="Logotipo de Bienes Raíces">
                </a>

                <div class="mobile-menu">
                    <img src="<?php echo $rutaBase; ?>build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="<?php echo $rutaBase; ?>build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="<?php echo $rutaBase; ?>nosotros.php">Nosotros</a>
                        <a href="<?php echo $rutaBase; ?>anuncios.php">Anuncios</a>
                        <a href="<?php echo $rutaBase; ?>blog.php">Blog</a>
                        <a href="<?php echo $rutaBase; ?>contacto.php">Contacto</a>
                        <a href="<?php echo $rutaBase; ?>admin/propiedades/lista.php" class="boton">Lista de Propiedades</a>

                        <?php if (isset($_SESSION['usuario_id'])): ?>
                            <a href="<?php echo $rutaBase; ?>perfil.php">Mi Perfil</a>
                            <a href="<?php echo $rutaBase; ?>logout.php">Cerrar sesión</a> <!-- Ruta de cierre de sesión -->
                        <?php else: ?>
                            <a href="<?php echo $rutaBase; ?>login.php">Iniciar sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div> <!-- .barra -->
        </div>
    </header>
</body>
</html>
