<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Productos con Unidades ≤ Tope</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
              crossorigin="anonymous" />
	</head>
	<body>

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
     
        echo "<div class='alert alert-danger'>Error: El producto ya existe en la base de datos.</div>";
               
    } else {
        //$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalle}', {$unidades}, '{$imagen}', 0)";
        $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
        VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalle}', {$unidades}, '{$imagen}')";

        if ($link->query($sql)) {
            echo "Producto insertado con ID: " . $link->insert_id;
           
                // Mostrar los datos insertados
                echo "<div class='alert alert-success'>";
                echo "<h4>Producto insertado con éxito</h4>";
                echo "<p><strong>Nombre:</strong> $nombre</p>";
                echo "<p><strong>Marca:</strong> $marca</p>";
                echo "<p><strong>Modelo:</strong> $modelo</p>";
                echo "<p><strong>Precio:</strong> $precio</p>";
                echo "<p><strong>Detalle:</strong> $detalle</p>";
                echo "<p><strong>Unidades:</strong> $unidades</p>";
                echo "</div>";
    
    
    
        } else {
            echo "El Producto no pudo ser insertado =(";
            
        }
    }
    

  

    $link->close();
} else {
    echo "Acceso no permitido.";
}
?>


</body>
</html>