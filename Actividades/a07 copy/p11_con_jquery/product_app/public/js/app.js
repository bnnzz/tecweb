$(document).ready(function(){
    let edit = false;
    
    // Inicializamos los campos con valores por defecto (los que tenías en tu baseJSON)
    $('#precio').val("0.0");
    $('#unidades').val("1");
    $('#modelo').val("XX-000");
    $('#marca').val("NA");
    $('#detalles').val("NA");
    $('#imagen').val("img/default.png");

    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                const productos = JSON.parse(response);
                if(Object.keys(productos).length > 0) {
                    let template = '';
                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>precio: ' + producto.precio + '</li>';
                        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>marca: ' + producto.marca + '</li>';
                        descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    
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

    $('#search').keyup(function() {
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + search,
                data: { search },
                type: 'GET',
                success: function(response) {
                    if(!response.error) {
                        const productos = JSON.parse(response);
                        if(Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';
                            productos.forEach(producto => {
                                let descripcion = '';
                                descripcion += '<li>precio: ' + producto.precio + '</li>';
                                descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                                descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                                descripcion += '<li>marca: ' + producto.marca + '</li>';
                                descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                            
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
                                template_bar += `<li>${producto.nombre}</li>`;
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

        // Validar el formulario antes de enviar
        if (!validarFormulario()) {
            return;
        }


        

        // Se arma el objeto JSON a enviar, obteniendo los datos directamente de los campos
        let postData = {
            nombre: $('#name').val(),
            precio: parseFloat($('#precio').val()),
            unidades: parseInt($('#unidades').val()),
            modelo: $('#modelo').val(),
            marca: $('#marca').val(),
            detalles: $('#detalles').val(),
            imagen: $('#imagen').val() ? $('#imagen').val() : "img/default.png",
            id: $('#productId').val()  // Campo oculto para edición
        };

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            // Reiniciamos el formulario con los valores por defecto
            $('#name').val('');
            $('#precio').val("0.0");
            $('#unidades').val("1");
            $('#modelo').val("XX-000");
            $('#marca').val("NA");
            $('#detalles').val("NA");
            $('#imagen').val("img/default.png");
            $('#product-result').show();
            $('#container').html(template_bar);
            listarProductos();
            edit = false;
            $('button.btn-primary').text("Agregar Producto");
        });
    });

    $(document).on('click', '.product-delete', (e) => {
        if(confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(e.target).closest('tr');
            const id = element.attr('productId');
            $.post('./backend/product-delete.php', { id }, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', (e) => {
        e.preventDefault();
        const element = $(e.target).closest('tr');
        const id = element.attr('productId');
        $.post('./backend/product-single.php', { id }, (response) => {
            let product = JSON.parse(response);
            // Rellenamos cada campo del formulario con los datos del producto
            $('#name').val(product.nombre);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#modelo').val(product.modelo);
            $('#marca').val(product.marca);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);
            edit = true;
            $('button.btn-primary').text("Modificar Producto");
        });
    });



    

    function validarFormulario() {
        // Validar nombre
        var nombre = document.getElementById("name").value;
        if (nombre === "" || nombre.length > 100) {
            alert("El nombre es obligatorio y debe tener máximo 100 caracteres.");
            return false;
        }

        // Validar marca
        var marca = document.getElementById("marca").value;
        if (marca === "") {
            alert("Seleccione la marca en la lista de opciones.");
            return false;
        }

        // Validar modelo
        var modelo = document.getElementById("modelo").value;
        var modeloRegex = /^[a-zA-Z0-9]*$/;
        if (modelo === "" || modelo.length > 25 || !modeloRegex.test(modelo)) {
            alert("El modelo es requerido, alfanumérico y debe tener máximo 25 caracteres.");
            return false;
        }

        // Validar precio
        var precio = parseFloat(document.getElementById("precio").value);
        if (isNaN(precio) || precio <= 99.99) {
            alert("El precio es obligatorio y debe ser mayor a 99.99.");
            return false;
        }

        // Validar detalles (opcionales, pero si se usa, no debe exceder 250 caracteres)
        var detalles = document.getElementById("detalles").value;
        if (detalles.length > 250) {
            alert("Los detalles son opcionales pero deben tener máximo 250 caracteres.");
            return false;
        }

        // Validar unidades
        var unidades = parseInt(document.getElementById("unidades").value);
        if (isNaN(unidades) || unidades < 0) {
            alert("Las unidades son obligatorias y el número registrado debe ser mayor o igual a 0.");
            return false;
        }

        // Validar imagen: se asigna imagen predeterminada si no se proporciona ruta
        var imagen = document.getElementById("imagen").value;
        if (imagen === "") {
            document.getElementById("imagen").value = "img/default.png";
        }

        return true;
    }

    function actualizarEstado(mensaje, esValido) {
        let template_bar = `<li style="list-style: none; color: ${esValido ? 'blue' : 'red'};">${mensaje}</li>`;
        $('#product-result').show();
        $('#container').html(template_bar);
    }
    
    $('#name, #marca, #modelo, #precio, #detalles, #unidades').on('input', function () {
        let id = $(this).attr('id');
        let valor = $(this).val();
        let mensaje = '';
        let esValido = true;
    
        switch (id) {
            case 'name':
                if (valor === '' || valor.length > 100) {
                    mensaje = 'El nombre es obligatorio y debe tener máximo 100 caracteres.';
                    esValido = false;
                } else {
                    // Validación asíncrona para el nombre
                    $.ajax({
                        url: './backend/product-check.php',
                        method: 'POST',
                        data: { nombre: valor },
                        dataType: 'json',
                        success: function (data) {
                            if (data.existe) {
                                mensaje = 'El nombre del producto ya existe en la base de datos.';
                                esValido = false;
                            } else {
                                mensaje = 'Nombre válido(sin coincidencias en la BD).';
                                esValido = true;
                            }
                            actualizarEstado(mensaje, esValido);  // Actualiza el estado con el mensaje
                        },
                        error: function (xhr, status, error) {
                            console.error('Error al verificar el nombre:', error);
                            mensaje = 'Hubo un error al verificar el nombre.';
                            esValido = false;
                            actualizarEstado(mensaje, esValido);  // Actualiza el estado con el mensaje de error
                        }
                    });
                    return;  // Detener el flujo aquí para no mostrar un mensaje de validación predeterminado mientras se espera la respuesta
                }
                break;
            case 'marca':
                if (valor === '') {
                    mensaje = 'Seleccione una marca.';
                    esValido = false;
                } else {
                    mensaje = 'Marca válida.';
                }
                break;
            case 'modelo':
                if (valor === '' || valor.length > 25 || !/^[a-zA-Z0-9]*$/.test(valor)) {
                    mensaje = 'El modelo debe ser alfanumérico y tener máximo 25 caracteres.';
                    esValido = false;
                } else {
                    mensaje = 'Modelo válido.';
                }
                break;
            case 'precio':
                if (isNaN(parseFloat(valor)) || parseFloat(valor) <= 99.99) {
                    mensaje = 'El precio debe ser mayor a 99.99.';
                    esValido = false;
                } else {
                    mensaje = 'Precio válido.';
                }
                break;
            case 'detalles':
                if (valor.length > 250) {
                    mensaje = 'Los detalles deben tener máximo 250 caracteres.';
                    esValido = false;
                } else {
                    mensaje = 'Detalles válidos.';
                }
                break;
            case 'unidades':
                if (isNaN(parseInt(valor)) || parseInt(valor) < 0) {
                    mensaje = 'Las unidades deben ser 0 o más.';
                    esValido = false;
                } else {
                    mensaje = 'Unidades válidas.';
                }
                break;
        }
    
        // Actualizar estado para los casos no asíncronos
        if (id !== 'name') {
            actualizarEstado(mensaje, esValido);
        }
    });
    
    // Ocultar barra de estado cuando el usuario deja de interactuar
    $('#name, #marca, #modelo, #precio, #detalles, #unidades').on('blur', function () {
        $('#product-result').hide();
    });
    
    


});
