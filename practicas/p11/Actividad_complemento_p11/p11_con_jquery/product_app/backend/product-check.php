<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = array(
    'existe' => false
);

// SE VERIFICA HABER RECIBIDO EL NOMBRE
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];

    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
    if ($result = $conexion->query($sql)) {
        // SE OBTIENEN LOS RESULTADOS
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if (count($rows) > 0) {
            // SI SE OBTUVIERON RESULTADOS, SE CAMBIA EL VALOR DE 'existe' A TRUE
            $data['existe'] = true;
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }
    $conexion->close();
}

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data);
?>
