<?php
include_once __DIR__.'/database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $id = mysqli_real_escape_string($conexion, $data['id']);
    $nombre = mysqli_real_escape_string($conexion, $data['nombre']);
    $precio = mysqli_real_escape_string($conexion, $data['precio']);
    $unidades = mysqli_real_escape_string($conexion, $data['unidades']);
    $modelo = mysqli_real_escape_string($conexion, $data['modelo']);
    $marca = mysqli_real_escape_string($conexion, $data['marca']);
    $detalles = mysqli_real_escape_string($conexion, $data['detalles']);
    $imagen = mysqli_real_escape_string($conexion, $data['imagen']);

    $sql = "UPDATE productos SET nombre='$nombre', precio='$precio', unidades='$unidades', modelo='$modelo', marca='$marca', detalles='$detalles', imagen='$imagen' WHERE id='$id'";
    if ($conexion->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Producto actualizado']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el producto: ' . $conexion->error]);
    }
    $conexion->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado']);
}
?>