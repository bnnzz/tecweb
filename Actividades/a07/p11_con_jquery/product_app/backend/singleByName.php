<?php

use TECWEB\MyApi\Products as Products;
require_once __DIR__ . '/myapi/Products.php';

// Proporcionar los tres argumentos requeridos por el constructor en el orden correcto
$prodObj = new Products('root', '1w2q', 'marketzone');

// Llamar al método singleByName con el nombre enviado por POST
$prodObj->singleByName($_POST['nombre']);

// Imprimir la respuesta en formato JSON
echo $prodObj->getData();

?>