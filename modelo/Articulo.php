<?php
//incluyendo la conexion a la base de datos

require "../config/Conexion.php";

//creando un clase

class Articulo
{
    //implementacion de contructor vacio
    public function __construct(){}

    //implementacion de metodo para insertar registros
    public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
    {
        $sql = "INSERT INTO articulo (idcategoria, codigo, nombre, stock, descripcion, imagen, condicion)
        VALUES ('$idcategoria', '$codigo', '$nombre', '$stock', '$descripcion', '$imagen', '1')";
        return ejecutarConsulta($sql);
    }

    //implementacion del metodo editar
    public function editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
    {
        $sql ="UPDATE articulo SET idcategoria='$idcategoria', codigo='$codigo', nombre='$nombre', stock='$stock', descripcion='$descripcion', imagen='$imagen' 
        WHERE idarticulo='$idarticulo' ";
        return ejecutarConsulta($sql);
    }

    //implementacion del metodo eliminar pero este no elimina si no que desactiva los articulos
    public function desactivar($idarticulo)
    {
        $sql = "UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo' ";
        return ejecutarConsulta($sql);
    }

    //implementacion del metodo activar los articulos desactivados
    public function activar($idarticulo)
    {
        $sql = "UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo' ";
        return ejecutarConsulta($sql);
    }

    //Implementacion del metodo mostrar los datos de un registro a modificar
    public function mostrar($idarticulo)
    {
        $sql = "SELECT * FROM articulo WHERE idarticulo='$idarticulo' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementacion del metodo listar todos los registros
    public function listar()
    {
        $sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as ncategoria, a.codigo, a.nombre as narticulo, a.stock, a.descripcion, a.imagen, a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria = c.idcategoria";
        return ejecutarConsulta($sql);
    }

}

?>