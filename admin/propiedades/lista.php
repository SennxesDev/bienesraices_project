<?php
require '../../includes/config/database.php';
require '../../includes/funciones.php';
incluirTemplate('header');

// Obtener propiedades de la base de datos
$query = "SELECT p.id, p.titulo, p.precio, p.imagen, p.descripcion, v.nombre AS vendedor
          FROM propiedades p
          JOIN vendedores v ON p.id_vendedor = v.id";
$resultado = mysqli_query($conn, $query);
?>

<main class="contenedor seccion">
    <h2>Casas y Depas en Venta</h2>

    <div class="contenedor-anuncios">
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($propiedad = mysqli_fetch_assoc($resultado)): ?>
                <div class="anuncio">
                    <div class="imagen-anuncio">
                        <img src="../../<?php echo $propiedad['imagen']; ?>" alt="Imagen propiedad" class="imagen-propiedad">
                    </div>

                    <div class="contenido-anuncio">
                        <h3><?php echo $propiedad['titulo']; ?></h3>
                        <p class="descripcion"><?php echo $propiedad['descripcion']; ?></p>
                        <p class="precio">$<?php echo number_format($propiedad['precio'], 2); ?></p>

                        <ul class="iconos-caracteristicas">
                            <li><img class="icono" src="../../build/img/icono_wc.svg" alt="icono wc"><p>3</p></li>
                            <li><img class="icono" src="../../build/img/icono_estacionamiento.svg" alt="icono estacionamiento"><p>3</p></li>
                            <li><img class="icono" src="../../build/img/icono_dormitorio.svg" alt="icono habitaciones"><p>4</p></li>
                        </ul>

                        <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton">Ver Propiedad</a>
                    </div><!--.contenido-anuncio-->
                </div><!--.anuncio-->
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay propiedades disponibles.</p>
        <?php endif; ?>
    </div><!--.contenedor-anuncios-->
</main>

<?php incluirTemplate('footer'); ?>

<style>
    /* Estilo para asegurar que las imágenes sean más grandes y centradas */
    .imagen-anuncio {
        width: 300px;  /* Establecer un tamaño más grande para las imágenes */
        height: 300px; /* Establecer el alto fijo */
        overflow: hidden; /* Ocultar el contenido que sobrepasa */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .imagen-anuncio img {
        width: 100%; /* Ajustar el ancho de la imagen al contenedor */
        height: 100%; /* Ajustar la altura de la imagen al contenedor */
        object-fit: cover; /* Mantener la proporción y cubrir el contenedor */
    }
</style>
