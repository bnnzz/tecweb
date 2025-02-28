<?php
/* MySQL Conexion */
$link = mysqli_connect("localhost", "root", "1w2q", "marketzone");

// Chequea conexión
if($link === false){
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Obtener datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$unidades = $_POST['unidades'];
$detalles = $_POST['detalles'];
$imagen = $_POST['imagen'];

// Actualizar el producto en la base de datos
$sql = "UPDATE productos SET nombre='$nombre', marca='$marca', modelo='$modelo', precio='$precio', unidades='$unidades', detalles='$detalles', imagen='$imagen' WHERE id='$id'";

if(mysqli_query($link, $sql)){
    echo "Registro actualizado.";
} else {
    echo "ERROR: No se ejecutó $sql. " . mysqli_error($link);
}

// Cierra la conexión
mysqli_close($link);
?>