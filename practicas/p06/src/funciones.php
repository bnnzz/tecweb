<?php

function es_multiplo7y5($num)
{
    if ($num%5==0 && $num%7==0)
    {
        echo '<h3>El número '.$num.' es un múltiplo de 5 y 7.</h3>';
    }
    else
    {
        echo '<h3>El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
}

function generar_secuencia()
{

$iteraciones = 0;
$numerosGenerados = 0;
$matriz = [];

// Generamos secuencias hasta obtener al menos una válida
do {
    $fila = [];
    for ($i = 0; $i < 3; $i++) {
        $fila[] = rand(1, 100);
        $numerosGenerados++;
    }

    // Agregar la fila a la matriz
    $matriz[] = $fila;
    $iteraciones++;

    // Revisamos si la última fila generada cumple la condición (impar, par, impar)
} while (!($fila[0] % 2 != 0 && $fila[1] % 2 == 0 && $fila[2] % 2 != 0));

// Mostramos el número total de iteraciones y números generados
echo "<h3>$numerosGenerados números obtenidos en $iteraciones iteraciones.</h3>";
}

function multiplo()
{
    if (isset($_GET['num']) && is_numeric($_GET['num']) && $_GET['num'] > 0) {
        $num = intval($_GET['num']); 

        // usando while
        $aleatorio = rand(1, 100);
        while ($aleatorio % $num !== 0) {
            $aleatorio = rand(1, 100);
        }
        echo "<h3> múltiplo con while de $num es: $aleatorio</h3>";

        // usando do-while
        do {
            $aleatorio = rand(1, 100);
        } while ($aleatorio % $num !== 0);
        echo "<h3> múltiplo con do-while de $num es: $aleatorio</h3>";

    } else {
        echo "<h3>proporciona un número válido</h3>";
    }
}


function ArregloLet() {
    $arreglo = [];
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }
    return $arreglo;
}









?>