<?php
namespace TECWEB\BACKEND\Controllers;

require_once __DIR__ . '/../models/Products.php';

use TECWEB\MODELS\Products;

/**
 * Lista todos los productos no eliminados.
 */
function listarProductos() {
    $prod_Obj = new Products('marketzone');
    $prod_Obj->list();
    echo $prod_Obj->getData();
}

/**
 * Agrega un nuevo producto.
 * Se espera que los datos se envíen vía POST.
 */
function agregarProducto() {
    $prod_Obj = new Products();
    $prod_Obj->add((object)$_POST);
    echo $prod_Obj->getData();
}

/**
 * Elimina un producto.
 * Se espera que se envíe el ID mediante POST.
 */
function eliminarProducto() {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $prod_Obj = new Products('marketzone');
    $prod_Obj->delete($id);
    echo $prod_Obj->getData();
}

/**
 * Edita un producto.
 * Se espera que los datos se envíen vía POST.
 */
function editarProducto() {
    $prod_Obj = new Products();
    $prod_Obj->edit((object)$_POST);
    echo $prod_Obj->getData();
}

/**
 * Busca productos por término.
 * Se espera que el término se envíe mediante GET (por ejemplo, ?search=...).
 */
function buscarProducto() {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $prod_Obj = new Products('marketzone');
    $prod_Obj->search($search);
    echo $prod_Obj->getData();
}

/**
 * Obtiene un producto por ID.
 * Se espera que el ID se envíe mediante POST.
 */
function obtenerProducto() {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $prod_Obj = new Products();
    if ($id !== null) {
        $prod_Obj->single($id);
    } else {
        $prod_Obj->data = ['status' => 'error', 'message' => 'ID no proporcionado'];
    }
    echo $prod_Obj->getData();
}

/**
 * Obtiene un producto por nombre.
 * Se espera que el nombre se envíe mediante GET (por ejemplo, ?nombre=...).
 */
function obtenerProductoPorNombre() {
    $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
    $prod_Obj = new Products();
    $prod_Obj->singleByName($nombre);
    echo $prod_Obj->getData();
}
?>
