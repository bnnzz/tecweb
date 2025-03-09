$(document).ready(function() {
    console.log('JQuery funciona');

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

    $('#search').keyup(function(e) {
  if($('#search').val()) {

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
                $('#product-result').show();

            },
        
        });


  }



    });



    $('#product-form').submit(function(e) {
        e.preventDefault();

        // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
        var productoJsonString = $('#description').val();
        // SE CONVIERTE EL JSON DE STRING A OBJETO
        var finalJSON = JSON.parse(productoJsonString);
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        finalJSON['nombre'] = $('#name').val();
        // SE OBTIENE EL STRING DEL JSON FINAL
        productoJsonString = JSON.stringify(finalJSON, null, 2);

        $.ajax({
            url: 'backend/product-add.php',
            type: 'POST',
            contentType: 'application/json',
            data: productoJsonString,
            success: function(response) {
                console.log('Datos enviados:', response);
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

                // SE LISTAN TODOS LOS PRODUCTOS
                //listarProductos();
            }
        });
    });


    $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        success: function(response) {
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
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.nombre}</td>
                        <td>${description}</td>
                    </tr>
                `;
            });
            $('#products').html(template);
        },
    });








    // Inicializar la función init
    init();
});