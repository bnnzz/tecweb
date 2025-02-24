
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
echo "<h3> 1.Determinar variables validas   <br /> </h3>";
$_myvar = "Test";  // Válida
$myvar = "Test";   // Válida
$var7 = "Test";    // Válida
$_element1 = "Test"; // Válida

// $_7var = "Test"; // No válida (no puede empezar con un número)

// $house*5 = "Test"; // No válida (no puede contener caracteres especiales como el asterisco)

echo "_myvar, myvar, var7, _element1 son variables válidas.<br />";
echo "_7var (no puede empezar por un número) y house*5 (no se permiten caracteres especiales como el asterisco) no son variables válidas.<br />";
unset($_myvar, $myvar, $var7, $_element1);  

echo "<h3> 2.Proporcionar valores  <br /> </h3>";
$a = "ManejadorSQL";  
$b = 'MySQL';        
$c = &$a;     
echo "a = $a, b = $b, c = $c<br />";

$a = "PHP server";
$b = &$a;
echo "a = $a, b = $b, c = $c<br />";
echo "lo que ocurrio en el segundo bloque de asignaciones es que se modifico el valor 
de  a y b, pero b hace referencia a la varibale a de igual manera que lo hace c, por lo que imprimen lo mismo <br />";
unset($a, $b, $c);  


echo "<h3> 3.Mostar contenido y verificar evolucion del tipo  <br /> </h3>";
echo"1.- " ;
$a = "PHP5";
var_dump($a);
echo "<br />";

echo"2.- ";
$z[] = &$a;
var_dump($z);
echo "<br />";

echo"3.- ";
$b = "5a version de PHP";
var_dump($b);
echo "<br />";

echo"4.- " ; 
$c = intval($b)*10;
var_dump($c);
echo "<br />";

echo "5.- ";
// **Solución:** Convertir `$b` a cadena antes de concatenar
$a .= strval($b);
var_dump($a);
echo "<br />";

echo"6.- ";
$b = intval($b);
$b *= $c;
var_dump($b);
echo "<br />";

echo"7.- "  ;
$z[0] = "MySQL";
var_dump($z);
echo "<br />";


echo "<h3>4.Acceso a variables con \$GLOBALS</h3>";

// Usamos $GLOBALS para acceder a las variables globales
echo "Valor de \$GLOBALS['a']: ";
var_dump($GLOBALS['a']);
echo "<br /><br />";

echo "Valor de \$GLOBALS['b']: ";
var_dump($GLOBALS['b']);
echo "<br /><br />";

echo "Valor de \$GLOBALS['c']: ";
var_dump($GLOBALS['c']);
echo "<br /><br />";

echo "Valor de \$GLOBALS['z']: ";
var_dump($GLOBALS['z']);
echo "<br /><br />";

// Liberar variables
unset($a, $b, $c, $z);

echo "<h3>5.Dar valor a vaiables y ver saldia del script </h3>";
$a = "7 personas";
$b = (integer) $a;
$a = "9E3";
$c = (double) $a;

echo ("a = $a, b = $b, c = $c<br />");

echo "<h3>6.Variables de tipo booleano</h3> <br />";
$a = "0";    // Cadena "0", que se considera FALSE en una evaluación booleana.
$b = "TRUE"; // Cadena "TRUE", que se considera TRUE en una evaluación booleana.
$c = FALSE;  // Es FALSE explícitamente.
$d = ($a OR $b);  // $d será TRUE porque "TRUE" es interpretado como TRUE.
$e = ($a AND $c); // $e será FALSE, porque uno de los operandos es FALSE.
$f = ($a XOR $b); // $f será TRUE, porque el operador XOR evalúa a TRUE cuando los operandos son diferentes.

echo"<br />";
var_dump($a); // "0", se considera FALSE
echo"<br />";
var_dump($b); // "TRUE", se considera TRUE
echo"<br />";
var_dump($c); // FALSE
echo"<br />";
var_dump($d); // TRUE
echo"<br />";
var_dump($e); // FALSE
echo"<br />";
var_dump($f); // TRUE
echo "<br />";
echo"mostrar con un echo: <br />";
echo"c: ";
echo var_export($c, true); // Debería mostrar: false
echo" e:";
echo var_export($e, true); // Debería mostrar: false

echo"<br />";   
echo "<h3> 7.Usando la variable predefinida _SERVER <br /> </h3>";        

// a. Versión de Apache y PHP
echo "a. Versión de Apache: " . $_SERVER['SERVER_SOFTWARE'] . "<br />";
echo "   Versión de PHP: " . phpversion() . "<br />";

// b. Nombre del sistema operativo del servidor
echo "b. Sistema operativo del servidor: " . PHP_OS . "<br />";  // También se puede usar $_SERVER['SERVER_SOFTWARE'] para obtener el software del servidor

// c. Idioma del navegador del cliente
echo "c. Idioma del navegador (cliente): " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br />";
?>
<p>
    <a href="https://validator.w3.org/markup/check?uri=referer"><img
      src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>
</body>
</html>






