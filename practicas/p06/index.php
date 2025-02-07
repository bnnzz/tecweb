<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1.-</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
     require_once __DIR__ . '/src/funciones.php';
        if(isset($_GET['numero']))
        {
            es_multiplo7y5($_GET['numero']);
        }
    ?>

  <h2>Ejercicio 2.-</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
    secuencia compuesta por: imparr, par, impar</p>
    <?php
     require_once __DIR__ . '/src/funciones.php';
     generar_secuencia(); 
    ?>

<h2>Ejercicio 3.- </h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
    pero que además sea múltiplo de un número dado.</p>
    <?php
     require_once __DIR__ . '/src/funciones.php';
     multiplo(); 
    ?>


<h2>Ejercicio 4.- </h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
el valor en cada índice.</p>
    <?php
     require_once __DIR__ . '/src/funciones.php';
     ArregloLet(); 

     $arreglo = ArregloLet();
    ?>
       <h3>Tabla de caracteres ASCII</h3>
    <table>
        <?php
        // Leer el arreglo y generar la tabla con foreach
        foreach ($arreglo as $key => $value) {
            echo "<tr><td>[ $key ]</td><td>=>$value</td></tr>";
        }
        ?>
    </table>


    <h2>Ejercicio 5.- </h2>
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de
      sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de
      bienvenida apropiado.</p>
      <h2>Formulario de Validación</h2>
    <form action="index.php" method="POST">
        <label for="edad">Edad: </label>
        <input type="number" id="edad" name="edad" required><br><br>

        <label for="sexo">Sexo: </label>
        <select id="sexo" name="sexo" required>
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select><br><br>

        <input type="submit" value="Enviar">
    </form>



    <?php
     require_once __DIR__ . '/src/funciones.php';
   
     
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];

        // Llamar a la función de validación
        primerFormulario($edad, $sexo);
    }
    ?>


<h2>Ejercicio 6.- </h2>
    <p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de
    una ciudad.</p>
    <h2>Registro del Parque Vehicular</h2>


<h2>Consultar por Matrícula</h2>
<form action="index.php" method="POST">
    <label for="matricula">Matrícula:</label>
    <input type="text" name="matricula" id="matricula" required>
    <input type="submit" name="consulta" value="Consultar">
</form>

<h2>Mostrar Todos los Vehículos</h2>
<form action="index.php" method="POST">
    <input type="submit" name="consultaTodos" value="Mostrar todos">
</form>

<?php
require_once __DIR__ . '/src/funciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['consultaTodos'])) {
        // Mostrar todos los registros
        mostrarRegistro();
    } elseif (isset($_POST['consulta'])) {
        // Consultar por matrícula
        $matricula = $_POST['matricula'];
        buscarMatricula($matricula);
    }
}
?>

</body>
</html>