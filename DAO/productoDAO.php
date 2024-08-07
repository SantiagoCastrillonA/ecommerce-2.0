<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Producto.php';
class CategoriadDAO
{
    var $objetos;
    private $acceso = "";
    public function __CONSTRUCT()
    {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    /**
     * La función "buscar_datos" recupera datos de una tabla de base de datos llamada "cargos" en base
     * a una consulta de búsqueda y devuelve los resultados.
     * 
     * @return una serie de objetos.
     */
    function buscar_datos()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "select * from categoria_producto cp where cp.nombre like :consulta order by cp.nombre asc";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
        else {
            $sql = "select * from categoria_producto cp order by cp.nombre ASC";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }

    /**
     * La función "categoriaProducto" recupera un objeto de carga de la base de datos en función de su ID.
     * 
     * @param Cargo obj El parámetro "obj" es una instancia de la clase "Cargo".
     * 
     * @return una serie de objetos de tipo "Carga".
     */
    function cargar(CategoriaProducto $obj)
    {
        $sql = "select * from categoria_producto cp where cp.id = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "editar_cargo" actualiza un registro en la tabla "cargos" con las propiedades del
     * objeto Cargo proporcionado.
     * 
     * @param Cargo obj El parámetro "obj" es un objeto de la clase "Cargo". Se utiliza para pasar los
     * detalles de la carga que deben actualizarse en la base de datos. El objeto debe tener las
     * siguientes propiedades:
     */
    function editar(Producto $obj)
    {
        $sql = "UPDATE productos P SET P.nombre_producto = :nombre_producto, P.id_categoria = :id_categoria, P.precio = :precio, P.descripcion = :descripcion where P.id =:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':nombre_producto' => $obj->getNombre_producto(), ':id_categoria' => $obj->getId_categoria(), ':precio' => $obj->getPrecio(), ':descripcion' => $obj->getDescripcion()))){
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * La función "crear_cargo" inserta un nuevo registro en la tabla "cargos" con las propiedades del
     * objeto Cargo proporcionado.
     * 
     * @param Cargo obj El parámetro `` es un objeto de la clase `Cargo`. Se utiliza para pasar los
     * valores de las propiedades del cargo (como `charge_name`, `description`, `state`, `histories` y
     * `support`) a la función `create_charge`. Estos valores
     */
    function crear(Producto $obj)
    {
        $sql = "INSERT INTO productos (nombre,  precio, id_categoria, estado) 
        VALUES (:nombre, :precio, :id_categoria, :estado)"; 
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':nombre' => $obj->getNombre_producto(), ':precio' => $obj->getPrecio(), ':id_categoria' => $obj->getId_categoria(), ':estado' => $obj->getEstado()))){ 
            return true;
        } else {
            return false;
        }
    }

    /**
     * La función "change_state" actualiza el estado de un objeto Cargo en la base de datos.
     * 
     * @param Cargo obj El parámetro "obj" es un objeto de la clase "Cargo".
     */
    function cambiar_estado(Cargo $obj)
    {
        $sql = "UPDATE cargos SET estado=:estado WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':estado' => $obj->getEstado()))) {
            echo 'update';
        } else {
            echo 'Error al cambiar el estado del cargo';
        }
    }
}
