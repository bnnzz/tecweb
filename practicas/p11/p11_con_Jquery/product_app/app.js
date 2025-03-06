
$(function () {
    console.log('jquery listo');
});




// JSON BASE A MOSTRAR EN FORMULARIO

var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

  function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;

 // SE LISTAN TODOS LOS PRODUCTOS
 listarProductos();
}

// FUNCIÓN CALLBACK AL CARGAR LA PÁGINA O AL AGREGAR UN PRODUCTO
function listarProductos() {
    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('GET', './backend/product-list.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            //console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                let template = '';

                productos.forEach(producto => {
                    // SE COMPRUEBA QUE SE OBTIENE UN OBJETO POR ITERACIÓN
                    //console.log(producto);

                    // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("products").innerHTML = template;
            }
        }
    };
    client.send();
}







// FUNCIÓN CALLBACK DE BOTÓN "Buscar Producto"
$(document).ready(function() {
    // FUNCIÓN CALLBACK DE BOTÓN "Buscar"
    $('#buscar-btn').on('click', function(e) {
        e.preventDefault();

        // SE OBTIENE EL ID A BUSCAR
        let search = $('#search').val();

        // SE CREA LA PETICIÓN AJAX
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            data: { search: search },
            dataType: 'json',
            success: function(productos) {
                if (productos.length > 0) {
                    let template = '';
                    let template_bar = '';

                    productos.forEach(producto => {
                        let descripcion = `
                            <li>precio: ${producto.precio}</li>
                            <li>unidades: ${producto.unidades}</li>
                            <li>modelo: ${producto.modelo}</li>
                            <li>marca: ${producto.marca}</li>
                            <li>detalles: ${producto.detalles}</li>
                        `;

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>${producto.nombre}</td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;

                        template_bar += `<li>${producto.nombre}</li>`;
                    });

                    // SE HACE VISIBLE LA BARRA DE ESTADO
                    $('#product-result').removeClass('d-none').addClass('card my-4 d-block');
                    // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                    $('#container').html(template_bar);
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);
                }
            }
        });
    });
});


// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            // Mostrar el mensaje del servidor usando window.alert()
            window.alert(client.responseText); // Muestra el mensaje de respuesta
       
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}



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