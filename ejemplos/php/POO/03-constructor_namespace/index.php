<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejejmplo 3 de poo</title>
</head>
<body>

<?php

use EJEMPLOS\POO\Cabecera2 as Cabecera;

require_once __DIR__ . '/Cabecera.php'; 
/*
$cab1= new Cabecera('el rincon del programador', 'center');
$cab1->graficar();  
*/


$cab1= new Cabecera('el rincon del programador', 'center', 'https://chat.deepseek.com');	
$cab1->graficar();  

?>
    
</body>
</html>