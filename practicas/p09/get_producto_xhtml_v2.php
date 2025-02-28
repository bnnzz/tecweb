<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<?php
    $data = array();

    // Verificar si el parámetro 'tope' está presente
    if(isset($_GET['tope'])) {
        $tope = $_GET['tope'];
    } else {
        die('Parámetro "tope" no detectado...');
    }

    // Conexión con la base de datos
    if (!empty($tope)) {
        @$link = new mysqli('localhost', 'root', '1w2q', 'marketzone');

        if ($link->connect_errno) {
            die('Falló la conexión: ' . $link->connect_error . '<br/>');
        }

        // Consulta de productos con unidades <= al valor de 'tope'
        if ($result = $link->query("SELECT * FROM productos WHERE unidades <= $tope")) {
            $row = $result->fetch_all(MYSQLI_ASSOC);
            foreach($row as $num => $registro) {
                foreach($registro as $key => $value) {
                    $data[$num][$key] = utf8_encode($value);
                }
            }
            $result->free();
        }

        $link->close();
    }
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos con Unidades ≤ Tope</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
          crossorigin="anonymous" />
    <script>
        // Función para mostrar los detalles de un producto
        function show(rowId) {
            var data = document.getElementById(rowId).querySelectorAll(".row-data");

            var id = data[0].innerHTML;
            var nombre = data[1].innerHTML;
            var marca = data[2].innerHTML;
            var modelo = data[3].innerHTML;
            var precio = data[4].innerHTML;
            var unidades = data[5].innerHTML;
            var detalles = data[6].innerHTML;

            alert("ID: " + id + "\nNombre: " + nombre + "\nMarca: " + marca + "\nModelo: " + modelo + 
                  "\nPrecio: " + precio + "\nUnidades: " + unidades + "\nDetalles: " + detalles);
            send2form(id, nombre, marca, modelo, precio, unidades, detalles);
        }

        // Función para enviar los datos del producto a un formulario oculto
        function send2form(id, name, brand, model, price, units, details) {
            var form = document.createElement("form");

            var idIn = document.createElement("input");
            idIn.type = 'hidden';
            idIn.name = 'id';
            idIn.value = id;
            form.appendChild(idIn);

            var nameIn = document.createElement("input");
            nameIn.type = 'hidden';
            nameIn.name = 'nombre';
            nameIn.value = name;
            form.appendChild(nameIn);

            var brandIn = document.createElement("input");
            brandIn.type = 'hidden';
            brandIn.name = 'marca';
            brandIn.value = brand;
            form.appendChild(brandIn);

            var modelIn = document.createElement("input");
            modelIn.type = 'hidden';
            modelIn.name = 'modelo';
            modelIn.value = model;
            form.appendChild(modelIn);

            var priceIn = document.createElement("input");
            priceIn.type = 'hidden';
            priceIn.name = 'precio';
            priceIn.value = price;
            form.appendChild(priceIn);

            var unitsIn = document.createElement("input");
            unitsIn.type = 'hidden';
            unitsIn.name = 'unidades';
            unitsIn.value = units;
            form.appendChild(unitsIn);

            var detailsIn = document.createElement("input");
            detailsIn.type = 'hidden';
            detailsIn.name = 'detalles';
            detailsIn.value = details;
            form.appendChild(detailsIn);

            form.method = 'POST';
            form.action = 'formulario_productos_v2.php';

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
    <h3>Productos con Unidades ≤ Tope</h3>
    <br/>

    <?php if(isset($row)): ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Detalles</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($row as $value): ?>
                    <tr id="<?= $value['id'] ?>" class="product-row">
                        <th scope="row" class="row-data"><?= $value['id'] ?></th>
                        <td class="row-data"><?= $value['nombre'] ?></td>
                        <td class="row-data"><?= $value['marca'] ?></td>
                        <td class="row-data"><?= $value['modelo'] ?></td>
                        <td class="row-data"><?= $value['precio'] ?></td>
                        <td class="row-data"><?= $value['unidades'] ?></td>
                        <td class="row-data"><?= $value['detalles'] ?></td>
                        <td><img src="<?= $value['imagen'] ?>" alt="Imagen" /></td>
                        <td><input type="button" value="Ver detalles" onclick="show('<?= $value['id'] ?>')" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif(!empty($id)): ?>
        <script>
            alert('El ID del producto no existe');
        </script>
    <?php endif; ?>
</body>
</html>
