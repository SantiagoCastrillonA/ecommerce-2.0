<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/CategoriaProducto.php';
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
            $sql = "SELECT C.*, CJ.nombre_cargo AS jefe FROM cargos  C JOIN cargos CJ ON C.id_jefe = CJ.id WHERE C.nombre_cargo LIKE :consulta AND C.id>1";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        } else {
            $sql = "SELECT C.*, CJ.nombre_cargo AS jefe FROM cargos C JOIN cargos  CJ ON C.id_jefe = CJ.id WHERE C.nombre_cargo NOT LIKE '' AND C.id>1 ORDER BY C.nombre_cargo ASC";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }

    /**
     * La función "cargarCargo" recupera un objeto de carga de la base de datos en función de su ID.
     * 
     * @param Cargo obj El parámetro "obj" es una instancia de la clase "Cargo".
     * 
     * @return una serie de objetos de tipo "Carga".
     */
    function cargarCargo(Cargo $obj)
    {
        $sql = "SELECT C.*, CJ.nombre_cargo AS jefe FROM cargos C JOIN cargos  CJ ON C.id_jefe = CJ.id WHERE C.id=:id";
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
    function editar_cargo(Cargo $obj)
    {
        $sql = "UPDATE cargos SET nombre_cargo=:nombre_cargo, descripcion=:descripcion, historias=:historias, soporte=:soporte, estado=:estado, id_jefe=:id_jefe WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':nombre_cargo' => $obj->getNombreCargo(), ':descripcion' => $obj->getDescripcion(), ':historias' => $obj->getHistorias(), ':soporte' => $obj->getSoporte(),':estado' => $obj->getEstado(), ':id_jefe' => $obj->getIdJefe()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar el cargo';
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
    function crear(CategoriaProducto $obj)
    {
        $sql = "INSERT INTO categoria_producto(nombre) 
        VALUES (:nombre)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':nombre' => $obj->getNombre()))) {
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
