<?php
 




use TECWEB\MyApi\Products as Products;
require_once __DIR__ . '/myapi/Products.php';

// Proporcionar los tres argumentos requeridos por el constructor en el orden correcto
$prodObj = new Products('root', '1w2q', 'marketzone');

// Llamar al método add con los datos enviados por POST
$prodObj->add($_POST);

// Imprimir la respuesta en formato JSON
echo $prodObj->getData();

?>
