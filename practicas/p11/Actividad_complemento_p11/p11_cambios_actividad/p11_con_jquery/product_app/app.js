$(document).ready(function () {
   
   let edit=false;
    console.log('JQuery funciona');
listarProductos();

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
        var JsonString = JSON.stringify(baseJSON, null, 2);
        document.getElementById("description").value = JsonString;

        // SE LISTAN TODOS LOS PRODUCTOS
        //listarProductos();
    }

    $('#search').keyup(function (e) {
     
        if ($('#search').val()) {

            let search = $('#search').val();
            console.log('Valor de búsqueda:', search);

            $.ajax({
                url: 'backend/product-search.php',
                type: 'GET',
                data: { search: search },
                success: function (response) {

                    let products = JSON.parse(response);

                    let template = '';

                    products.forEach(product => {
                        console.log('Producto:', product);
                        template += `
                        <li>
                            ${product.nombre}
                        </li>
                    `;
                    });

                    $('#container').html(template);
                    console.log('Contenido del contenedor actualizado');
                    $('#product-result').removeClass('d-none').addClass('d-block');
                    //$('#product-result').show();

                },

            });


        }



    });




    
    // Agregar evento submit al formulario de búsqueda
    $('form').submit(function(e) {
        e.preventDefault();
        let search = $('#search').val();
        console.log('Valor de búsqueda:', search);

        $.ajax({
            url: 'backend/product-search.php',
            type: 'GET',
            data: { search: search },
            success: function(response) {
                let products = JSON.parse(response);
                let template = '';

                products.forEach(product => {
                    console.log('Producto:', product);
                    template += `
                        <li>
                            ${product.nombre}
                        </li>
                    `;
                });

                $('#container').html(template);
                console.log('Contenido del contenedor actualizado');
                $('#product-result').removeClass('d-none').addClass('d-block');
            },
        });
    });





    $('#product-form').submit(function (e) {
        e.preventDefault();

        // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
        var productoJsonString = $('#description').val();
        // SE CONVIERTE EL JSON DE STRING A OBJETO
        var finalJSON = JSON.parse(productoJsonString);
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        finalJSON['nombre'] = $('#name').val();
        // SE OBTIENE EL STRING DEL JSON FINAL
        productoJsonString = JSON.stringify(finalJSON, null, 2);

  // Comprobación para determinar si es una adición o una edición
  const url = edit === false ? 'backend/product-add.php' : 'backend/product-edit.php';
  console.log(finalJSON, url);



        $.ajax({
            url:url,
            type: 'POST',
            contentType: 'application/json',
            data: productoJsonString,
            success: function (response) {
                listarProductos();  
                //console.log('Datos enviados:', response);
                let respuesta = JSON.parse(response);
                
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;

                // SE HACE VISIBLE LA BARRA DE ESTADO
                $('#product-result').removeClass('d-none').addClass('d-block');
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                $('#container').html(template_bar);

        // Mostrar mensaje de éxito
        $('#success-message').html('<div class="alert alert-success">Producto agregado exitosamente</div>');

                
                // Restablecer el formulario
                $('#product-form').trigger('reset');
                // Volver a establecer el JSON base en el campo de descripción
                document.getElementById("description").value = JSON.stringify(baseJSON, null, 2);

                $('button.btn-primary').text("Agregar Producto");
       

                // SE LISTAN TODOS LOS PRODUCTOS
                //listarProductos();
            }
        });
    });



    function listarProductos() {

        $.ajax({
            url: 'backend/product-list.php',
            type: 'GET',
            success: function (response) {
                
                let products = JSON.parse(response);
                let template = '';
                products.forEach(product => {
                    let description = `
                    <ul>
                        <li>precio: ${product.precio}</li>
                        <li>unidades: ${product.unidades}</li>
                        <li>modelo: ${product.modelo}</li>
                        <li>marca: ${product.marca}</li>
                        <li>detalles: ${product.detalles}</li>
                    </ul>
                `;
                    template += `
                    <tr  productid= "${product.id}">
                        <td>${product.id}</td>
                        <td>
                        <a href="#" class="product-item" >${product.nombre}  </a>
                        
                        </td>
                        <td>${description}</td>
                        <td>
                        <button class="product-delete btn btn-danger">
                        Eliminar</button>
                        </td>
                    </tr>
                `;
                });
                $('#products').html(template);
            },
        });





    }

$(document).on('click', '.product-delete', function () {
if (confirm('¿Estás seguro de querer eliminar este producto?')) {
    let element=$(this)[0].parentElement.parentElement;
let id= $(element).attr('productid');  
$.get('backend/product-delete.php', {id}, function (response) {
listarProductos();

});
}

});



$(document).on('click', '.product-item', function () {
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr('productid');   

    $.get('backend/product-single.php', { id }, function (response) {
        console.log(response); // Verifica qué devuelve el servidor

        let product = (typeof response === 'string') ? JSON.parse(response) : response;

        // Verifica si el producto tiene datos antes de mostrarlo
        if (product) {
            $('#name').val(product.nombre); // Agrega el nombre al campo de texto
            $('#description').val(JSON.stringify(product, null, 2)); // Agrega el JSON formateado
            $('#productId').val(id); // Guarda el ID para futuras actualizaciones
            edit = true; // Activa la bandera de edición   
            $('button.btn-primary').text("Modificar Producto"); 
        }
    });
});




    // Inicializar la función init
    init();
});