<?php

require 'includes/config/database.php';
require 'includes/funciones.php';

// Incluir el header
incluirTemplate('header', $inicio = false);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit;
}

// Obtener datos del usuario desde la base de datos
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
?>

<main class="contenedor seccion">
    <h1>Mi Perfil</h1>

    <!-- Mostrar información del perfil -->
    <div class="perfil">
        <div class="perfil-info">
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
            <p><strong>Correo electrónico:</strong> <?php echo htmlspecialchars($usuario['correo']); ?></p>
            <!-- Aquí puedes añadir más información si lo deseas -->
        </div>

        <h2>Opciones</h2>
        <ul class="perfil-opciones">
            <li><a href="editar_perfil.php" class="boton boton-verde">Editar mi perfil</a></li>
            <li><a href="convertirse_en_vendedor.php" class="boton boton-verde">Conviértete en vendedor</a></li>
            <li><a href="logout.php" class="boton boton-verde">Cerrar sesión</a></li>
        </ul>
    </div>
</main>

<?php
// Incluir el footer
incluirTemplate('footer');
?>
