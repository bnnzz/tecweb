<?php
    include_once __DIR__.'/database.php';

    $response = array('exists' => false);

    if (isset($_GET['nombre'])) {
        $nombre = $_GET['nombre'];
        $sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        if ($result = $conexion->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                $response['exists'] = true;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }

    echo json_encode($response);
?>