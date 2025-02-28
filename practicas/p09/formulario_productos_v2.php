<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Actualizar el producto</title>
    <style type="text/css">
        ol,
        ul {
            list-style-type: none;
        }
    </style>
</head>

<body>
    <h1>Actualiza tu producto</h1>

    <?php
    // Verificar si el ID del producto está presente
    if (empty($_POST['id']) && empty($_GET['id'])) {
        echo "<p>Error: No se proporcionó un ID de producto válido.</p>";
        exit;
    }
    ?>

    <form id="formularioTenis" action="update_producto.php" method="post" onsubmit="return validarFormulario()">
        <h2>Datos del producto</h2>

        <fieldset>
            <legend>Datos del producto</legend>

            <ul>
                <!-- Campo oculto para el ID del producto -->
                <li><label for="form-id">ID:</label>
                    <input type="text" id="form-id" value="<?= !empty($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '') ?>" disabled>
                    <input type="hidden" name="id" value="<?= !empty($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '') ?>">
                </li>

                <li><label for="form-name">Nombre:</label> 
                    <input type="text" name="nombre" id="form-name" value="<?= !empty($_POST['nombre']) ? $_POST['nombre'] : (isset($_GET['nombre']) ? $_GET['nombre'] : '') ?>">
                </li>
                <li><label for="form-marca">Marca:</label>
                    <select name="marca" id="form-marca">
                        <option value="">Selecciona una marca</option>
                        <option value="sony" <?= (isset($_POST['marca']) && $_POST['marca'] == 'sony') || (isset($_GET['marca']) && $_GET['marca'] == 'sony') ? 'selected' : '' ?>>Sony</option>
                        <option value="Microsoft" <?= (isset($_POST['marca']) && $_POST['marca'] == 'Microsoft') || (isset($_GET['marca']) && $_GET['marca'] == 'Microsoft') ? 'selected' : '' ?>>Microsoft</option>
                        <option value="Nintendo" <?= (isset($_POST['marca']) && $_POST['marca'] == 'Nintendo') || (isset($_GET['marca']) && $_GET['marca'] == 'Nintendo') ? 'selected' : '' ?>>Nintendo</option>
                    </select>
                </li>
                <li><label for="form-modelo">Modelo:</label>
                    <input type="text" name="modelo" id="form-modelo" value="<?= !empty($_POST['modelo']) ? $_POST['modelo'] : (isset($_GET['modelo']) ? $_GET['modelo'] : '') ?>">
                </li>
                <li><label for="form-dinero">Precio:</label>
                    <input type="text" name="precio" id="form-dinero" value="<?= !empty($_POST['precio']) ? $_POST['precio'] : (isset($_GET['precio']) ? $_GET['precio'] : '') ?>">
                </li>
                <li><label for="form-detalle">Detalles:</label><br>
                    <textarea name="detalles" rows="4" cols="60" id="form-detalle" placeholder="No más de 250 caracteres de longitud"><?= !empty($_POST['detalles']) ? $_POST['detalles'] : (isset($_GET['detalles']) ? $_GET['detalles'] : '') ?></textarea>
                </li>
                <li><label for="form-unidad">Unidades:</label>
                    <input type="number" name="unidades" id="form-unidad" value="<?= !empty($_POST['unidades']) ? $_POST['unidades'] : (isset($_GET['unidades']) ? $_GET['unidades'] : '') ?>">
                </li>
                <li><label for="form-imagen">Imagen:</label>
                    <input type="hidden" name="imagen" value="<?= !empty($_POST['imagen']) ? $_POST['imagen'] : (isset($_GET['imagen']) ? $_GET['imagen'] : 'imagen.png') ?>">
                </li>
            </ul>
        </fieldset>

        <p>
            <input type="submit" value="Actualizar producto">
            <input type="reset">
        </p>

    </form>

    <script type="text/javascript">
        function validarFormulario() {
            // Validar nombre
            var nombre = document.getElementById("form-name").value;
            if (nombre === "" || nombre.length > 100) {
                alert("El nombre es obligatorio y debe tener maximo 100 caracteres.");
                return false;
            }

            // Validar marca
            var marca = document.getElementById("form-marca").value;
            if (marca === "") {
                alert("Seleccione la marca en la lista de opciones.");
                return false;
            }

            // Validar modelo
            var modelo = document.getElementById("form-modelo").value;
            var modeloRegex = /^[a-zA-Z0-9]*$/;
            if (modelo === "" || modelo.length > 25 || !modeloRegex.test(modelo)) {
                alert("El modelo es requerido, alfanumérico y debe tener maximo 25 caracteres .");
                return false;
            }

            // Validar precio
            var precio = parseFloat(document.getElementById("form-dinero").value);
            if (isNaN(precio) || precio <= 99.99) {
                alert("El precio es obligatorio y debe ser mayor a 99.99.");
                return false;
            }

            // Validar detalles (opcionales, pero si se usa, no debe exceder 250 caracteres)
            var detalles = document.getElementById("form-detalle").value;
            if (detalles.length > 250) {
                alert("Los detalles son  opcionales pero debe tener maximo 250 caracteres.");
                return false;
            }

            // Validar unidades
            var unidades = parseInt(document.getElementById("form-unidad").value);
            if (isNaN(unidades) || unidades < 0) {
                alert("Las unidades son obligatorias y el número registrado debe ser mayor o igual a 0.");
                return false;
            }

            // Validar imagen
            var imagen = document.getElementById("form-imagen").value;
            if (imagen === "") {
                document.getElementById("form-imagen").value = "imagen.png"; // Asignar imagen predeterminada si no se proporciona ruta
            }

            return true; // Si pasa todas las validaciones
        }
    </script>
</body>

</html>
