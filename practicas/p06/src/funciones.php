<?php

function es_multiplo7y5($num)
{
    if ($num%5==0 && $num%7==0)
    {
        echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
    }
    else
    {
        echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
}

function generar_secuencia()
{
   // Función para generar la secuencia

    $iteraciones = 0; // Contador de iteraciones
    $numerosGenerados = 0; // Contador de números generados
    $secuencias = []; // Matriz para almacenar las secuencias generadas

    // Continuamos generando números hasta que obtenemos una secuencia válida
    while (true) {
        $secuencia = []; // Arreglo para la secuencia de 3 números
        $secuencia[] = rand(1, 100); // Generar primer número
        $secuencia[] = rand(1, 100); // Generar segundo número
        $secuencia[] = rand(1, 100); // Generar tercer número

        // Contamos cuántos números son generados en total
        $numerosGenerados += 3;

        // Verificamos si la secuencia cumple con las condiciones (impar, par, impar)
        if ($secuencia[0] % 2 != 0 && $secuencia[1] % 2 == 0 && $secuencia[2] % 2 != 0) {
            $secuencias[] = $secuencia; // Guardamos la secuencia válida
            $iteraciones++; // Incrementamos el contador de iteraciones
        }

        // Si se ha generado una secuencia válida, salimos del bucle
        if (count($secuencias) > 0) {
            break;
        }
    }

    // Mostrar las secuencias generadas
    echo "<h3>Secuencias generadas:</h3>";
    foreach ($secuencias as $secuencia) {
        echo implode(", ", $secuencia) . "<br>";
    }

    // Mostrar el número de iteraciones y números generados
    echo "<h3>Resultado:</h3>";
    echo "$numerosGenerados números obtenidos en $iteraciones iteraciones.";
}



?>