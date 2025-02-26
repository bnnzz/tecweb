<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Registro el producto</title>
  <style type="text/css">
    ol,
    ul {
      list-style-type: none;
    }
  </style>
</head>

<body>
  <h1>Registra tu producto</h1>

  <form id="formularioTenis" action="http://localhost/tecweb/practicas/p08/set_producto_v2.php" method="post" onsubmit="return validarFormulario()">

    <h2>Datos del producto</h2>

    <fieldset>
      <legend>Datos del producto</legend>

      <ul>
        <li><label for="form-name">Nombre:</label> <input type="text" name="name" id="form-name"></li>
        <li><label for="form-marca">Marca:</label>
          <select name="marca" id="form-marca">
            <option value="">Selecciona una marca</option>
            <option value="sony">sony</option>
            <option value="Microsoft">Microsoft</option>
            <option value="Nintendo">Nintendo</option>
          </select>
        </li>
        <li><label for="form-modelo">Modelo:</label> <input type="text" name="modelo" id="form-modelo"></li>
        <li><label for="form-dinero">Precio:</label> <input type="text" name="precio" id="form-dinero"></li>
        <li><label for="form-detalle">Detalles:</label><br><textarea name="detalle" rows="4" cols="60" id="form-detalle"
            placeholder="No más de 250 caracteres de longitud"></textarea></li>
        <li><label for="form-unidad">Unidades:</label> <input type="number" name="unidades" id="form-unidad"></li>
        <li><label for="form-imagen">la Imagen es predeterminada</label> <input type="hidden" name="imagen" value="imagen.png">
        </li>
      </ul>
    </fieldset>

    <p>
      <input type="submit" value="Agregar producto">
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
