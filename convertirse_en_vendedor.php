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

$usuario_id = $_SESSION['usuario_id'];

// Verificar si el usuario ya está registrado como vendedor
$sql = "SELECT * FROM vendedores WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // El usuario ya es vendedor, redirigir al perfil o donde desees
    $esVendedor = true;
} else {
    $esVendedor = false;
}

// Si el formulario de convertirse en vendedor ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];

    // Insertar al usuario como vendedor en la base de datos
    $sql = "INSERT INTO vendedores (nombre, apellido, telefono, id_usuario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $nombre, $apellido, $telefono, $usuario_id);

    if ($stmt->execute()) {
        // Redirigir al usuario a la página de crear.php donde puede publicar propiedades
        header('Location: admin/propiedades/crear.php');
        exit;
    } else {
        $error = 'Error al convertirte en vendedor.';
    }
}
?>

<main class="contenedor seccion">
    <h1>Convertirse en Vendedor</h1>

    <!-- Mensaje de error si es necesario -->
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <!-- Formulario para convertirse en vendedor -->
    <?php if (!$esVendedor) : ?>
        <form method="POST">
            <fieldset>
                <legend>Datos del Vendedor</legend>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre del vendedor" required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" placeholder="Apellido del vendedor" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" placeholder="Teléfono del vendedor" required>

            </fieldset>
            <input type="submit" value="Convertirse en vendedor" class="boton boton-verde">
        </form>
    <?php else : ?>
        <!-- Botón de añadir propiedad si ya es vendedor -->
        <a href="admin/propiedades/crear.php" class="boton boton-amarillo">Añadir Propiedad</a>
    <?php endif; ?>
</main>

<?php
// Incluir el footer
incluirTemplate('footer');
?>
