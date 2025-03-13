<?php
include_once __DIR__.'/database.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    $query = "SELECT * FROM productos WHERE id = {$id}";

    $result = mysqli_query($conexion, $query);
    if (!$result) {
        die('Query Failed: ' . mysqli_error($conexion));
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'nombre' => $row['nombre'],
            'precio' => $row['precio'],
            'unidades' => $row['unidades'],
            'modelo' => $row['modelo'],
            'marca' => $row['marca'],
            'detalles' => $row['detalles'],
            'imagen' => $row['imagen'],
            'id' => $row['id']
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado']);
}

?>