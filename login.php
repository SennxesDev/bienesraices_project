<?php
require 'includes/config/database.php';
require 'includes/funciones.php';

// Incluir el header
incluirTemplate('header', $inicio = false);

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (empty($correo) || empty($password)) {
        $error = 'Por favor, ingresa tu correo y contraseña.';
    } else {
        // Verificar si el correo está registrado en la base de datos
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Si el correo existe en la base de datos, verificar la contraseña
        if ($resultado->num_rows > 0) {
            $usuario_bd = $resultado->fetch_assoc();
            
            // Verificar que la contraseña es correcta
            if (password_verify($password, $usuario_bd['contrasena'])) {
                // Si la contraseña es correcta, iniciar sesión
                $_SESSION['usuario_id'] = $usuario_bd['id'];
                $_SESSION['usuario_correo'] = $usuario_bd['correo'];
                $_SESSION['usuario_nombre'] = $usuario_bd['nombre']; // Si necesitas el nombre del usuario
                header('Location: index.php'); // Redirigir a la página principal
                exit;
            } else {
                $error = 'Contraseña incorrecta.';
            }
        } else {
            $error = 'El correo no está registrado.';
        }
    }
}
?>

<main class="contenedor seccion">
    <h1>Iniciar sesión</h1>

    <!-- Formulario de inicio de sesión -->
    <form class="formulario" method="POST">
        <fieldset>
            <legend>Accede a tu cuenta</legend>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>

        </fieldset>
        <input type="submit" value="Iniciar sesión" class="boton boton-verde">
    </form>

    <!-- Mostrar mensaje de error si es necesario -->
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <p>No tienes cuenta? <a href="registro.php">Regístrate</a></p>
</main>

<?php
// Incluir el footer
incluirTemplate('footer');
?>
