<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['name']);
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $precio = trim($_POST['precio']);
    $detalle = trim($_POST['detalle']);
    $unidades = trim($_POST['unidades']);
    $imagen = "imagen.png";


    @$link = new mysqli('localhost', 'root', '1w2q', 'marketzone');
    if ($link->connect_errno) {
        die('Falló la conexión: '.$link->connect_error.'<br/>');
    }

    $sql = "SELECT COUNT(*) FROM productos WHERE nombre = '$nombre' AND marca = '$marca' AND modelo = '$modelo'";
    $result = $link->query($sql);
    $row = $result->fetch_array();

    if ($row[0] > 0) {
        die("Error: El producto ya existe en la base de datos.");
    }

    $sql = "INSERT INTO productos VALUES (null, '$nombre', '$marca', '$modelo', $precio, '$detalle', $unidades, '$imagen')";
    if ($link->query($sql)) {
        echo "Producto insertado con ID: " . $link->insert_id;
    } else {
        echo "El Producto no pudo ser insertado =(";
    }

    $link->close();
} else {
    echo "Acceso no permitido.";
}
?>
