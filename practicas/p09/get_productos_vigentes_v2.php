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
					  send2form(id, nombre, marca, modelo, precio, unidades, detalles);
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


<script>
    function send2form(id, name, brand, model, price, units, details) {
        var form = document.createElement("form");

        // Crear y agregar el campo para el ID del producto
        var idIn = document.createElement("input");
        idIn.type = 'hidden';
        idIn.name = 'id';
        idIn.value = id;
        form.appendChild(idIn);

        // Crear y agregar el campo para el nombre del producto
        var nameIn = document.createElement("input");
        nameIn.type = 'hidden';
        nameIn.name = 'nombre';
        nameIn.value = name;
        form.appendChild(nameIn);

        // Crear y agregar el campo para la marca del producto
        var brandIn = document.createElement("input");
        brandIn.type = 'hidden';
        brandIn.name = 'marca';
        brandIn.value = brand;
        form.appendChild(brandIn);

        // Crear y agregar el campo para el modelo del producto
        var modelIn = document.createElement("input");
        modelIn.type = 'hidden';
        modelIn.name = 'modelo';
        modelIn.value = model;
        form.appendChild(modelIn);

        // Crear y agregar el campo para el precio del producto
        var priceIn = document.createElement("input");
        priceIn.type = 'hidden';
        priceIn.name = 'precio';
        priceIn.value = price;
        form.appendChild(priceIn);

        // Crear y agregar el campo para las unidades del producto
        var unitsIn = document.createElement("input");
        unitsIn.type = 'hidden';
        unitsIn.name = 'unidades';
        unitsIn.value = units;
        form.appendChild(unitsIn);

        // Crear y agregar el campo para los detalles del producto
        var detailsIn = document.createElement("input");
        detailsIn.type = 'hidden';
        detailsIn.name = 'detalles';
        detailsIn.value = details;
        form.appendChild(detailsIn);

        // Establecer el método y la acción del formulario
        form.method = 'POST';
        form.action = 'formulario_productos_v2.php';  

        // Adjuntar el formulario al cuerpo del documento y enviarlo
        document.body.appendChild(form);
        form.submit();
    }
</script>

	</body>
</html>
