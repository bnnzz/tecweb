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


// Función para procesar el formulario
function primerFormulario($edad, $sexo) {
    // Validar la condición de edad y sexo
    if ($sexo == 'femenino' && $edad >= 18 && $edad <= 35) {
        echo "<h3>Bienvenida, usted está en el rango de edad permitido.</h3>";
    } else {
        echo "<h3>Lo sentimos, su edad o sexo no cumplen con los requisitos.</h3>";
    }
}



function registro() {
    $parqueVehicular = array(
        "UBN6338" => array(
            "Auto" => array(
                "marca" => "HONDA",
                "modelo" => "2020",
                "tipo"  => "camioneta"
            ),
            "Propietario" => array(
                "nombre"    => "Alfonzo Esparza",
                "ciudad"    => "Puebla, Pue.",
                "direccion" => "C.U., Jardines de San Manuel"
            )
        ),
        "UBN6339" => array(
            "Auto" => array(
                "marca" => "MAZDA",
                "modelo" => "2019",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Ma. del Consuelo Molina",
                "ciudad"    => "Puebla, Pue.",
                "direccion" => "97 oriente"
            )
        ),
        "ABC1234" => array(
            "Auto" => array(
                "marca" => "TOYOTA",
                "modelo" => "2021",
                "tipo"  => "hachback"
            ),
            "Propietario" => array(
                "nombre"    => "Carlos López",
                "ciudad"    => "Ciudad de México",
                "direccion" => "Av. Reforma 123"
            )
        ),
        "DEF5678" => array(
            "Auto" => array(
                "marca" => "FORD",
                "modelo" => "2018",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Ana Martínez",
                "ciudad"    => "Monterrey",
                "direccion" => "Calle Juárez 456"
            )
        ),
        "GHI9012" => array(
            "Auto" => array(
                "marca" => "NISSAN",
                "modelo" => "2020",
                "tipo"  => "camioneta"
            ),
            "Propietario" => array(
                "nombre"    => "Luis Torres",
                "ciudad"    => "Guadalajara",
                "direccion" => "Av. Vallarta 789"
            )
        ),
        "JKL3456" => array(
            "Auto" => array(
                "marca" => "CHEVROLET",
                "modelo" => "2019",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Sofía Ramírez",
                "ciudad"    => "Puebla, Pue.",
                "direccion" => "Calle 5 de Mayo 101"
            )
        ),
        "MNO7890" => array(
            "Auto" => array(
                "marca" => "KIA",
                "modelo" => "2022",
                "tipo"  => "hachback"
            ),
            "Propietario" => array(
                "nombre"    => "Eduardo García",
                "ciudad"    => "Querétaro",
                "direccion" => "Calle Hidalgo 202"
            )
        ),
        "PQR2345" => array(
            "Auto" => array(
                "marca" => "SUBARU",
                "modelo" => "2020",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Mariana Ríos",
                "ciudad"    => "Toluca",
                "direccion" => "Av. Reforma 303"
            )
        ),
        "STU6789" => array(
            "Auto" => array(
                "marca" => "BMW",
                "modelo" => "2017",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Diego Fernández",
                "ciudad"    => "Cancún",
                "direccion" => "Calle Sol 404"
            )
        ),
        "VWX0123" => array(
            "Auto" => array(
                "marca" => "AUDI",
                "modelo" => "2021",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Isabel Gómez",
                "ciudad"    => "León",
                "direccion" => "Calle Reforma 505"
            )
        ),
        "YZA4567" => array(
            "Auto" => array(
                "marca" => "MERCEDES",
                "modelo" => "2018",
                "tipo"  => "camioneta"
            ),
            "Propietario" => array(
                "nombre"    => "Ricardo Sánchez",
                "ciudad"    => "Tijuana",
                "direccion" => "Av. Revolución 606"
            )
        ),
        "BCD8901" => array(
            "Auto" => array(
                "marca" => "VOLKSWAGEN",
                "modelo" => "2019",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Laura Herrera",
                "ciudad"    => "Mérida",
                "direccion" => "Calle 60 707"
            )
        ),
        "EFG2345" => array(
            "Auto" => array(
                "marca" => "HYUNDAI",
                "modelo" => "2020",
                "tipo"  => "hachback"
            ),
            "Propietario" => array(
                "nombre"    => "Javier Morales",
                "ciudad"    => "Culiacán",
                "direccion" => "Av. del Sol 808"
            )
        ),
        "HIJ6789" => array(
            "Auto" => array(
                "marca" => "SUZUKI",
                "modelo" => "2017",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Patricia Cruz",
                "ciudad"    => "Hermosillo",
                "direccion" => "Calle Libertad 909"
            )
        ),
        "KLM0123" => array(
            "Auto" => array(
                "marca" => "LEXUS",
                "modelo" => "2021",
                "tipo"  => "sedan"
            ),
            "Propietario" => array(
                "nombre"    => "Fernando Jiménez",
                "ciudad"    => "Puebla, Pue.",
                "direccion" => "Calle 16 de Septiembre 1010"
            )
        )
    );
    return $parqueVehicular;
}

// Función para mostrar el registro completo (todos los vehículos)
function mostrarRegistro() {
    $parqueVehicular = registro();
    echo "<pre>";
    print_r($parqueVehicular);
    echo "</pre>";
}

// Función para buscar y mostrar la información de un vehículo dado su matrícula.
function buscarMatricula($matricula) {
    $parqueVehicular = registro();
    if (isset($parqueVehicular[$matricula])) {
        echo "<pre>";
        print_r($parqueVehicular[$matricula]);
        echo "</pre>";
    } else {
        echo "<h3>No se encontró ningún vehículo con la matrícula $matricula</h3>";
    }
}


?>