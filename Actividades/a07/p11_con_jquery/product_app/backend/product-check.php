<?php
/*include_once __DIR__.'/database.php';

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
*/

use TECWEB\MyApi\Products as Products;
require_once __DIR__ . '/myapi/Products.php';

// Proporcionar los tres argumentos requeridos por el constructor en el orden correcto
$prodObj = new Products('root', '1w2q', 'marketzone');

// Llamar al método check con el nombre enviado por POST
$prodObj->check($_POST['nombre']);

// Imprimir la respuesta en formato JSON
echo $prodObj->getData();

?>
