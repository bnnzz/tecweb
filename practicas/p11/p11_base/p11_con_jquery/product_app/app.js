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

                // Mostrar el contenedor de resultados si hay productos
                if (products.length > 0) {
                    $('#product-result').removeClass('d-none');
                } else {
                    $('#product-result').addClass('d-none');
                }
            },
        
        });


  }



    });

    // Inicializar la función init
    init();
});