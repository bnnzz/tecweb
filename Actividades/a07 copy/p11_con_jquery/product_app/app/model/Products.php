<?php
namespace TECWEB\MyApi; 
use TECWEB\MyApi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data=NULL; // Atributo privado para almacenar los datos

    // Constructor 
    public function __construct($user = 'root', $pass = '1w2q', $db) {
          $this->data = array(); // Inicializa el atributo data como un array vacío
          parent::__construct($user, $pass, $db); // Llama al constructor de la superclase
     
    }

    // Método para agregar un producto
public function add($product) {
    // Inicializa el arreglo de respuesta
    $this->data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );

    // Verifica si el nombre del producto está definido
    if (isset($_POST['nombre'])) {
        // Transforma el POST a un objeto JSON
        $jsonOBJ = json_decode(json_encode($_POST));

        // Verifica si el producto ya existe
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
        $result = $this->conexion->query($sql);

        if ($result->num_rows == 0) {
            $this->conexion->set_charset("utf8");
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto agregado";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . $this->conexion->error;
            }
        }

        $result->free();
    } else {
        $this->data['message'] = "ERROR: Datos del producto incompletos.";
    }

    // Cierra la conexión
    $this->conexion->close();
}

// Método para eliminar un producto por su ID
public function delete($id) {
    // Inicializa el arreglo de respuesta
    $this->data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );

    // Verifica si se recibió el ID a través de $_POST
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $this->conexion->set_charset("utf8");

        // Realiza la consulta para marcar el producto como eliminado
        $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";
        if ($this->conexion->query($sql)) {
            $this->data['status'] = "success";
            $this->data['message'] = "Producto eliminado";
        } else {
            $this->data['message'] = "ERROR: No se ejecutó la consulta.";
        }
    } else {
        $this->data['message'] = "ERROR: ID del producto no proporcionado.";
    }

    // Cierra la conexión
    $this->conexion->close();
}

// Método para editar un producto
public function edit($product) {
    // Inicializa el arreglo de respuesta
    $this->data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );

    // Verifica si se recibió el ID
    if (isset($_POST['id'])) {
        $jsonOBJ = json_decode(json_encode($_POST));
        $this->conexion->set_charset("utf8");

        // Realiza la consulta para actualizar el producto
        $sql = "UPDATE productos SET 
                    nombre='{$jsonOBJ->nombre}', 
                    marca='{$jsonOBJ->marca}', 
                    modelo='{$jsonOBJ->modelo}', 
                    precio={$jsonOBJ->precio}, 
                    detalles='{$jsonOBJ->detalles}', 
                    unidades={$jsonOBJ->unidades}, 
                    imagen='{$jsonOBJ->imagen}' 
                WHERE id={$jsonOBJ->id}";

        if ($this->conexion->query($sql)) {
            $this->data['status'] = "success";
            $this->data['message'] = "Producto actualizado";
        } else {
            $this->data['message'] = "ERROR: No se ejecutó la consulta.";
        }
    } else {
        $this->data['message'] = "ERROR: ID del producto no proporcionado.";
    }

    // Cierra la conexión
    $this->conexion->close();
}

 // Método para buscar productos por un término
public function search($term) {
    // Inicializa el arreglo de respuesta
    $this->data = array(
        'status' => 'error',
        'message' => 'La consulta falló',
        'products' => [] // Asegura que siempre haya una clave 'products'
    );

    // Verifica si se recibió el término de búsqueda
    if (!empty($term)) {
        $this->conexion->set_charset("utf8");

        // Realiza la consulta para buscar productos
        $sql = "SELECT * FROM productos WHERE (id = '{$term}' OR nombre LIKE '%{$term}%' OR marca LIKE '%{$term}%' OR detalles LIKE '%{$term}%') AND eliminado = 0";
        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!empty($rows)) {
                $this->data['status'] = 'success';
                $this->data['products'] = $rows;
            } else {
                $this->data['message'] = "No se encontraron productos con el término proporcionado.";
            }
            $result->free();
        } else {
            $this->data['message'] = "ERROR: No se ejecutó la consulta.";
        }
    } else {
        $this->data['message'] = "ERROR: Término de búsqueda no proporcionado.";
    }

    // Cierra la conexión
    $this->conexion->close();
}

// Método para obtener un producto por su ID
public function single($id) {
    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $this->data = array();

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $this->conexion->set_charset("utf8");

        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}")) {
            // SE OBTIENEN LOS RESULTADOS
            $row = $result->fetch_assoc();

            if (!is_null($row)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach ($row as $key => $value) {
                    $this->data[$key] = utf8_encode($value);
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . $this->conexion->error);
        }
        $this->conexion->close();
    }
}

 // Método para buscar un producto por su nombre
public function singleByName($name) {
    // Inicializa el arreglo de respuesta
    $this->data = array(
        'status' => 'error',
        'message' => 'La consulta falló'
    );

    // Verifica si se recibió el nombre
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $this->conexion->set_charset("utf8");

        // Realiza la consulta para buscar el producto por su nombre
        $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        if ($result = $this->conexion->query($sql)) {
            $row = $result->fetch_assoc();

            if (!is_null($row)) {
                // Mapea los datos al arreglo de respuesta
                $this->data = array(
                    'status' => 'success',
                    'product' => $row
                );
            } else {
                $this->data['message'] = "No se encontró el producto con el nombre proporcionado.";
            }
            $result->free();
        } else {
            $this->data['message'] = "ERROR: No se ejecutó la consulta.";
        }
    } else {
        $this->data['message'] = "ERROR: Nombre del producto no proporcionado.";
    }

    // Cierra la conexión
    $this->conexion->close();
}


    public function check($name) {
        // Inicializa el arreglo de respuesta
        $this->data = array(
            'existe' => false
        );
    
        // Verifica si se recibió el nombre a través de $_POST
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $this->conexion->set_charset("utf8");
    
            // Realiza la consulta para verificar si el producto existe
            $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
            if ($result = $this->conexion->query($sql)) {
                // Si se obtienen resultados, cambia el valor de 'existe' a true
                if ($result->num_rows > 0) {
                    $this->data['existe'] = true;
                }
                $result->free();
            } else {
                $this->data['message'] = "ERROR: No se ejecutó la consulta.";
            }
        } else {
            $this->data['message'] = "ERROR: Nombre del producto no proporcionado.";
        }
    
        // Cierra la conexión
        $this->conexion->close();
    }


  // Método para listar todos los productos
  public function list() {
     
    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $this->data = array(); // Inicializa correctamente el array

   
    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    if ( $result =$this->conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
        // SE OBTIENEN LOS RESULTADOS
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if(!is_null($rows)) {
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
            foreach($rows as $num => $row) {
                foreach($row as $key => $value) {
                    $this->data[$num][$key]=$value;
                }
            }
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($this->conexion));
    }
    $this->conexion->close();
    }


    // Método para convertir el atributo data a JSON
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT); 
    }
}