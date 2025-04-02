<?php
// backend/index.php

// Configura la cabecera para respuestas en JSON.
header('Content-Type: application/json; charset=utf-8');

// Incluye el controlador de productos.
require_once __DIR__ . '/controllers/productController.php';

// Usa las funciones definidas en el controlador.
use function TECWEB\BACKEND\Controllers\listarProductos;
use function TECWEB\BACKEND\Controllers\agregarProducto;
use function TECWEB\BACKEND\Controllers\eliminarProducto;
use function TECWEB\BACKEND\Controllers\editarProducto;
use function TECWEB\BACKEND\Controllers\buscarProducto;
use function TECWEB\BACKEND\Controllers\obtenerProducto;
use function TECWEB\BACKEND\Controllers\obtenerProductoPorNombre;

// Se obtiene la acción a ejecutar. Si no se especifica, se lista por defecto.
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch ($action) {
    case 'list':
        listarProductos();
        break;
    case 'add':
        agregarProducto();
        break;
    case 'delete':
        eliminarProducto();
        break;
    case 'edit':
        editarProducto();
        break;
    case 'search':
        buscarProducto();
        break;
    case 'single':
        obtenerProducto();
        break;
    case 'singlebyname':
        obtenerProductoPorNombre();
        break;
    default:
        echo json_encode(["status" => "error", "message" => "Acción no válida"]);
        break;
}
?>
