<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Productos con Unidades ≤ Tope</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
              crossorigin="anonymous" />
	</head>
	<body>
		<h3>PRODUCTOS CON UNIDADES ≤ TOPE</h3>
		<br/>
		<?php
		// Se verifica que se haya enviado el parámetro "tope"
		if (isset($_GET['tope'])) {
			$tope = $_GET['tope'];
		}

		if (!empty($tope))
		{
			/** SE CREA EL OBJETO DE CONEXIÓN */
			@$link = new mysqli('localhost', 'root', '1w2q', 'marketzone');	

			/** Comprobar la conexión */
			if ($link->connect_errno) {
				die('Falló la conexión: ' . $link->connect_error . '<br/>');
			}

			/** Ejecutar la consulta: obtener todos los productos cuya cantidad de unidades sea menor o igual a $tope */
			if ($result = $link->query("SELECT * FROM productos WHERE unidades <= '{$tope}'")) {

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
						echo '    <tr>';
						echo '      <th scope="row">' . htmlspecialchars($row['id']) . '</th>';
						echo '      <td>' . htmlspecialchars($row['nombre']) . '</td>';
						echo '      <td>' . htmlspecialchars($row['marca']) . '</td>';
						echo '      <td>' . htmlspecialchars($row['modelo']) . '</td>';
						echo '      <td>' . htmlspecialchars($row['precio']) . '</td>';
						echo '      <td>' . htmlspecialchars($row['unidades']) . '</td>';
						// Se aplica utf8_encode en el campo detalles, como en el código original
						echo '      <td>' . utf8_encode($row['detalles']) . '</td>';
						echo '      <td><img src="' . htmlspecialchars($row['imagen']) . '" alt="Imagen" /></td>';
						echo '    </tr>';
					}

					echo '  </tbody>';
					echo '</table>';
				} else {
					// Si no se encontraron productos, se muestra una alerta
					echo '<script>alert("No se encontraron productos con unidades menores o iguales a ' . htmlspecialchars($tope) . '");</script>';
				}
				/** Se libera la memoria asociada al resultado */
				$result->free();
			}

			$link->close();
		} else {
			// Si el parámetro "tope" no se envió o está vacío
			echo '<script>alert("Parámetro \'tope\' no detectado o vacío");</script>';
		}
		?>
	</body>
</html>
