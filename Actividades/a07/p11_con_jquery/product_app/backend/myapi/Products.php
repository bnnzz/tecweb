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
        $query = "INSERT INTO products (name, price, description) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('sds', $product['name'], $product['price'], $product['description']);
        $stmt->execute();
        $stmt->close();
    }

    // Método para eliminar un producto por su ID
    public function delete($id) {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    // Método para editar un producto
    public function edit($product) {
        $query = "UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('sdsi', $product['name'], $product['price'], $product['description'], $product['id']);
        $stmt->execute();
        $stmt->close();
    }

  

    // Método para buscar productos por un término
    public function search($term) {
        $query = "SELECT * FROM products WHERE name LIKE ?";
        $term = "%$term%";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('s', $term);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    // Método para obtener un producto por su ID
    public function single($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->data = $result->fetch_assoc();
        $stmt->close();
    }

    // Método para buscar un producto por su nombre
    public function singleByName($name) {
        $query = "SELECT * FROM products WHERE name = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->data = $result->fetch_assoc();
        $stmt->close();
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