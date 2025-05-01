// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function(){
    let edit = false;

    let JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    $('#product-result').hide();

    listarProductos();

    function listarProductos() {
        $.ajax({
            url: 'http://localhost/tecweb/Actividades/a09/product_app/backend/products',
            type: 'GET',
            dataType: 'json',
            success: function(productos) {
                let template = '';
                if (productos.length > 0) {
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
                                <td><button class="product-delete btn btn-danger">Eliminar</button></td>
                            </tr>
                        `;
                    });
                } else {
                    template = `<tr><td colspan="4">No hay productos disponibles</td></tr>`;
                }
                $('#products').html(template);
            },
            error: function(xhr, status, error) {
                console.error("Error al listar productos:", error);
                $('#products').html('<tr><td colspan="4">Error al cargar productos</td></tr>');
            }
        });
    }

    $('#search').keyup(function() {
        const searchTerm = $(this).val().trim();

        if (searchTerm) {
            $.ajax({
                url: `http://localhost/tecweb/Actividades/a09/product_app/backend/products/${encodeURIComponent(searchTerm)}`,
                type: 'GET',
                dataType: 'json',
                success: function(productos) {
                    let template = '';
                    let template_bar = '';
                    if (productos.length > 0) {
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
                                    <td><button class="product-delete btn btn-danger">Eliminar</button></td>
                                </tr>
                            `;
                            template_bar += `<li>${producto.nombre}</li>`;
                        });
                    } else {
                        template = `<tr><td colspan="4">No se encontraron productos</td></tr>`;
                    }
                    $('#product-result').show();
                    $('#container').html(template_bar);
                    $('#products').html(template);
                },
                error: function(xhr, status, error) {
                    console.error("Error en búsqueda:", error);
                    $('#product-result').hide();
                    $('#products').html('<tr><td colspan="4">Error en la búsqueda</td></tr>');
                }
            });
        } else {
            $('#product-result').hide();
            listarProductos();
        }
    });

    $('#product-form').submit(function(e) {
        e.preventDefault();

        try {
            const postData = JSON.parse($('#description').val());
            postData.nombre = $('#name').val();
            postData.id = $('#productId').val(); // vacío si es nuevo

            const method = edit ? 'PUT' : 'POST';
            const url = 'http://localhost/tecweb/Actividades/a09/product_app/backend/product';

            $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify(postData),
                success: function(respuesta) {
                    const template_bar = `
                        <li style="list-style:none;">status: ${respuesta.status}</li>
                        <li style="list-style:none;">message: ${respuesta.message}</li>
                    `;
                    $('#name').val('');
                    $('#productId').val('');
                    $('#description').val(JSON.stringify(baseJSON, null, 2));
                    $('#product-result').show();
                    $('#container').html(template_bar);
                    listarProductos();
                    edit = false;
                },
                error: function(xhr, status, error) {
                    console.error("Error al guardar:", error);
                    alert("No se pudo guardar el producto.");
                }
            });
        } catch (e) {
            alert("Error en el formato JSON del campo de descripción.");
        }
    });

    $(document).on('click', '.product-delete', function(e) {
        e.preventDefault();
        if (confirm("¿Deseas eliminar este producto?")) {
            const id = $(this).closest('tr').attr('productId');
            $.ajax({
                url: 'http://localhost/tecweb/Actividades/a09/product_app/backend/product',
                type: 'DELETE',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({ id }),
                success: function(response) {
                    $('#product-result').hide();
                    listarProductos();
                },
                error: function(xhr, status, error) {
                    console.error("Error al eliminar:", error);
                    alert("No se pudo eliminar el producto.");
                }
            });
        }
    });

    $(document).on('click', '.product-item', function(e) {
        e.preventDefault();
        const id = $(this).closest('tr').attr('productId');

        $.ajax({
            url: `http://localhost/tecweb/Actividades/a09/product_app/backend/product/${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(product) {
                $('#name').val(product.nombre);
                $('#productId').val(product.id);
                const { nombre, eliminado, id: _, ...productDetails } = product;
                $('#description').val(JSON.stringify(productDetails, null, 2));
                edit = true;
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener producto:", error);
                alert("No se pudo cargar el producto.");
            }
        });
    });
});
