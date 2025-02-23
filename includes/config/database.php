<?php
$servidor = 'localhost';  // Dirección del servidor de base de datos (localhost en XAMPP)
$usuario = 'root';        // Usuario predeterminado de MySQL en XAMPP
$contraseña = '';         // Contraseña predeterminada de MySQL en XAMPP (vacía por defecto)
$base_de_datos = 'bienes_raices_db';  // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos";
?>
