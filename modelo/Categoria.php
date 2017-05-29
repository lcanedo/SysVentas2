<?php
//incluyendo la conexion a la base de datos

require "../config/Conexion.php";

//creando un clase

class Categoria
{
    //implementacion de contructor vacio
    public function __construct(){}

    //implementacion de metodo para insertar registros
    public function insertar($nombre, $descripcion)
    {
        $sql = "INSERT INTO categoria (nombre, descripcion, condicion)
        VALUES ('$nombre','$descripcion','1')";
        return ejecutarConsulta($sql);
    }

    //implementacion del metodo editar
    public function editar($idcategoria, $nombre, $descripcion)
    {
        $sql ="UPDATE categoria SET nombre='$nombre', descripcion='$descripcion' 
        WHERE idcategoria='$idcategoria' ";
        return ejecutarConsulta($sql);
    }

    //implementacion del metodo eliminar pero este no elimina si no que desactiva las categorias
    public function desactivar($idcategoria)
    {
        $sql = "UPDATE categoria SET condicion='0' WHERE idcategoria='$idcategoria' ";
        return ejecutarConsulta($sql);
    }

    //implementacion del metodo activar las categorias desactivadas
    public function activar($idcategoria)
    {
        $sql = "UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria' ";
        return ejecutarConsulta($sql);
    }

    //Implementacion del metodo mostrar los datos de un registro a modificar
    public function mostrar($idcategoria)
    {
        $sql = "SELECT * FROM categoria WHERE idcategoria='$idcategoria' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementacion del metodo listar todos los registros
    public function listar()
    {
        $sql = "SELECT * FROM categoria ";
        return ejecutarConsulta($sql);
    }

}

?>