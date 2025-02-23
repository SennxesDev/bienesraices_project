<?php
session_start();
require 'includes/config/database.php';
require 'includes/funciones.php';

// Incluir header
incluirTemplate('header', $inicio = false); 

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        // Verificar si el correo ya está registrado
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $error = 'El correo ya está registrado.';
        } else {
            // Encriptar la contraseña
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $nombre, $correo, $password_hash);

            if ($stmt->execute()) {
                // Registrar la sesión
                $_SESSION['usuario_id'] = $conn->insert_id;
                header('Location: perfil.php');
                exit;
            } else {
                $error = 'Error al registrar el usuario.';
            }
        }
    }
}
?>

<main class="contenedor seccion">
    <h1>Registrarse</h1>

    <!-- Formulario de registro -->
    <form class="formulario" method="POST">
        <fieldset>
            <legend>Crea tu cuenta</legend>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar contraseña" required>

        </fieldset>
        <input type="submit" value="Registrarse" class="boton boton-verde">
    </form>

    <!-- Mostrar mensaje de error si es necesario -->
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
</main>

<?php
// Incluir footer
incluirTemplate('footer');
?>
