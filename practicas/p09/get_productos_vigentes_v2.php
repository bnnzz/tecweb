<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Productos con Unidades ≤ Tope</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
              crossorigin="anonymous" />



			  <script>
            function show(rowId) {
                // Se obtiene los datos de la fila en forma de arreglo
                var data = document.getElementById(rowId).querySelectorAll(".row-data");

                // Se obtienen los valores de las celdas
                var id = data[0].innerHTML;
                var nombre = data[1].innerHTML;
                var marca = data[2].innerHTML;
                var modelo = data[3].innerHTML;
                var precio = data[4].innerHTML;
                var unidades = data[5].innerHTML;
                var detalles = data[6].innerHTML;

                // Se muestra la información en una alerta
                alert("ID: " + id + "\nNombre: " + nombre + "\nMarca: " + marca + "\nModelo: " + modelo + 
                      "\nPrecio: " + precio + "\nUnidades: " + unidades + "\nDetalles: " + detalles);
            }
        </script>
	</head>
	<body>
		<h3>Productos no eliminados</h3>
		<br/>
		<?php
	
			/** SE CREA EL OBJETO DE CONEXIÓN */
			@$link = new mysqli('localhost', 'root', '1w2q', 'marketzone');	

			/** Comprobar la conexión */
			if ($link->connect_errno) {
				die('Falló la conexión: ' . $link->connect_error . '<br/>');
			}

			/** Ejecutar la consulta: obtener todos los productos cuya cantidad de unidades sea menor o igual a $tope */
		
				if ($result = $link->query("SELECT * FROM productos WHERE eliminado = 0")) {


				// Si se encontraron productos, se muestra la tabla
				if ($result->num_rows > 0) {
					echo '<table class="table">';
					echo '  <thead class="thead-dark">';
					echo '    <tr>';
					echo '      <th scope="col">#</th>';
					echo '      <th scope="col">Nombre</th>';
					echo '      <th scope="col">Marca</th>';
					echo '      <th scope="col">Modelo</th>';
					echo '      <th scope="col">Precio</th>';
					echo '      <th scope="col">Unidades</th>';
					echo '      <th scope="col">Detalles</th>';
					echo '      <th scope="col">Imagen</th>';
					echo '    </tr>';
					echo '  </thead>';
					echo '  <tbody>';

				// Se recorren todos los registros obtenidos
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo '    <tr id="' . htmlspecialchars($row['id']) . '">';  // Se le asigna un id único a la fila
    echo '      <th scope="row" class="row-data">' . htmlspecialchars($row['id']) . '</th>';
    echo '      <td class="row-data">' . htmlspecialchars($row['nombre']) . '</td>';
    echo '      <td class="row-data">' . htmlspecialchars($row['marca']) . '</td>';
    echo '      <td class="row-data">' . htmlspecialchars($row['modelo']) . '</td>';
    echo '      <td class="row-data">' . htmlspecialchars($row['precio']) . '</td>';
    echo '      <td class="row-data">' . htmlspecialchars($row['unidades']) . '</td>';
    echo '      <td class="row-data">' . utf8_encode($row['detalles']) . '</td>';
    echo '      <td><img src="' . htmlspecialchars($row['imagen']) . '" alt="Imagen" /></td>';

    // Aquí agregamos el botón y le pasamos el id de la fila como parámetro a la función show()
    echo '      <td><input type="button" value="submit" onclick="show(' . htmlspecialchars($row['id']) . ')" /></td>';

}

					echo '  </tbody>';
					echo '</table>';
				} 
				/** Se libera la memoria asociada al resultado */
				$result->free();
			}

			$link->close();
		
		?>



	</body>
</html>
