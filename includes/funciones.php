<?php
function incluirTemplate($nombre) {
    $rutaBase = obtenerRutaBase();
    include __DIR__ . "/templates/{$nombre}.php";
}

function obtenerRutaBase() {
    $protocolo = isset($_SERVER['HTTPS']) ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $raiz = "/bienesraices_project/"; // Ajusta según la estructura de tu proyecto
    return "{$protocolo}://{$host}{$raiz}";
}
