<?php
include 'database.php';

header('Content-Type: application/json');

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $query = "SELECT COUNT(*) as count FROM productos WHERE nombre = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    } else {
        echo json_encode(['error' => 'Error en la consulta']);
    }
} else {
    echo json_encode(['error' => 'Nombre no proporcionado']);
}
?>