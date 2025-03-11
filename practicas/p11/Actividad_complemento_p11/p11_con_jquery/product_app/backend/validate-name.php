<?php
include_once __DIR__.'/database.php';

// Arreglo de respuesta en JSON
$data = array("exists" => false);

// Se verifica si se recibió el parámetro 'name'
if (isset($_GET['name'])) {
    $name = $conexion->real_escape_string($_GET['name']); // Escapar el nombre para evitar inyección SQL

    // Consulta para verificar si el nombre ya existe en la BD y no está eliminado
    $sql = "SELECT COUNT(*) AS count FROM productos WHERE nombre = '{$name}' AND eliminado = 0";
    
    if ($result = $conexion->query($sql)) {
        $row = $result->fetch_assoc();
        $data["exists"] = ($row["count"] > 0);
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }

    $conexion->close();
}

// Retorna la respuesta en JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>