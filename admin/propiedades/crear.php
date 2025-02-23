<?php
require '../../includes/config/database.php';
require '../../includes/funciones.php';
incluirTemplate('header');

// Definir variables vacías
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedor = '';
$imagen = '';

// Comprobamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrar y obtener datos del formulario
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($conn, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($conn, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($conn, $_POST['estacionamiento']);
    $vendedor = mysqli_real_escape_string($conn, $_POST['vendedor']);

    // Subir imagen
    if ($_FILES['imagen']['name']) {
        $imagen = 'imagenes/' . $_FILES['imagen']['name'];  // Ruta donde se guardará la imagen
        move_uploaded_file($_FILES['imagen']['tmp_name'], '../../' . $imagen);
    }

    // Insertar propiedad en la base de datos
    $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, id_vendedor) 
              VALUES ('$titulo', '$precio', '$imagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedor')";

    $resultado = mysqli_query($conn, $query);

    if ($resultado) {
        // Redirigir a la lista de propiedades
        header('Location: lista.php');
        exit; // Asegura que no se ejecute más código después de la redirección
    } else {
        echo "Error al guardar la propiedad: " . mysqli_error($conn);
    }
}

// Obtener vendedores de la base de datos
$vendedoresQuery = "SELECT id, nombre, apellido FROM vendedores";
$vendedoresResult = mysqli_query($conn, $vendedoresQuery);
?>

<main class="contenedor seccion">
    <h1>Crear Propiedad</h1>
    <a href="../../" class="boton boton-verde">Volver</a>
    <form class="formulario" method="POST" action="crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información general</legend>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad" required>

            <label for="precio">Precio:</label>
            <input type="text" id="precio" name="precio" placeholder="Precio Propiedad" required>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción de la propiedad" required></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" required>

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" required>

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" required>
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor" required>
                <option value="">--Selecciona el vendedor--</option>
                <?php while ($vendedor = mysqli_fetch_assoc($vendedoresResult)): ?>
                    <option value="<?php echo $vendedor['id']; ?>">
                        <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>
