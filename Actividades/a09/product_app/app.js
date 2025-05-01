// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };
  $(document).ready(function () {
    let edit = false;

    let JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: 'http://localhost/tecweb/actividades/a09/backend/products', type: 'GET',
            success: function (response) {
                console.log(response);
                const productos = JSON.parse(response);

                if (Object.keys(productos).length > 0) {
                    let template = '';

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
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function () {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: `http://localhost/tecweb/actividades/a09/backend/product/search?search=${search}`, // Ruta Slim para buscar productos
                type: 'GET',
                success: function (response) {
                    if (!response.error) {
                        const productos = JSON.parse(response);

                        if (Object.keys(productos).length > 0) {
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
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</li>
                                `;
                            });
                            $('#product-result').show();
                            $('#container').html(template_bar);
                            $('#products').html(template);
                        }
                    }
                }
            });
        } else {
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        let postData = JSON.parse($('#description').val());
        postData['nombre'] = $('#name').val();
        postData['id'] = $('#productId').val();

        const url = edit === false ? 'http://localhost/tecweb/actividades/a09/backend/product' : 'http://localhost/tecweb/actividades/a09/backend/product';
        const method = edit === false ? 'POST' : 'PUT'; // Método HTTP según la acción

        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(postData),
            contentType: 'application/json',
            success: function (response) {
                console.log(response);
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $('#name').val('');
                $('#description').val(JsonString);
                $('#product-result').show();
                $('#container').html(template_bar);
                listarProductos();
                edit = false;
            }
        });
    });

    $(document).on('click', '.product-delete', function () {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');

            $.ajax({
                url: `http://localhost/tecweb/actividades/a09/backend/product/${id}`, // Ruta Slim para eliminar producto
                type: 'DELETE',
                success: function (response) {
                    console.log(response);
                    listarProductos();
                }
            });
        }
    });

    $(document).on('click', '.product-item', function (e) {
        e.preventDefault();
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');

        $.get(`http://localhost/tecweb/actividades/a09/backend/product/${id}`, function (data) { // Ruta Slim para obtener un producto por ID
            let product = JSON.parse(data);
            $('#name').val(product.nombre);
            $('#productId').val(product.id);
            delete product.nombre;
            delete product.eliminado;
            delete product.id;
            let JsonString = JSON.stringify(product, null, 2);
            $('#description').val(JsonString);
            edit = true;
        });
    });
});