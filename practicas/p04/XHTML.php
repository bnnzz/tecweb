
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title> Una página PHP </title>
</head>
<body>
<?php
// 1. Determina cuál de las siguientes variables son válidas y explica por qué:

$_myvar = "Test";  // Válida
$myvar = "Test";   // Válida
$var7 = "Test";    // Válida
$_element1 = "Test"; // Válida

// $_7var = "Test"; // No válida (no puede empezar con un número)

// $house*5 = "Test"; // No válida (no puede contener caracteres especiales como el asterisco)

echo "_myvar, myvar, var7, _element1 son variables válidas.<br />";
echo "_7var (no puede empezar por un número) y house*5 (no se permiten caracteres especiales como el asterisco) no son variables válidas.<br />";
?>
</body>
</html>






