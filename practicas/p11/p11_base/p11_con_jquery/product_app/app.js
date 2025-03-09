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
        let search = $('#search').val();
        console.log('Valor de búsqueda:', search);

        $.ajax({
            url: 'backend/product-search.php',
            type: 'GET',
            data: { search: search },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                // Aquí puedes agregar más lógica para manejar la respuesta
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    // Inicializar la función init
    init();
});