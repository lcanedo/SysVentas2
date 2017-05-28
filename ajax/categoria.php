<?php
require "../modelo/Categoria.php";

$categoria = new Categoria();

$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "" ;
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "" ;
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "" ;


switch ($_GET["op"]) {
    case 'guardaryeditar':
          if (empty($idcategoria)) {
              $rspta = $categoria->insertar($nombre,$descripcion);
              echo $rspta ? "Categoria Registrada" : "Categoria no se pudo registrar";
          }else {
              $rspta = $categoria->editar($idcategoria,$nombre,$descripcion);
              echo $rspta ? "Categoria Actualizada" : "Categoria no se pudo Actualizar";
          }
        
        break;
    case 'desactivar':
              $rspta = $categoria->desactivar($idcategoria);
              echo $rspta ? "Categoria Desactivada" : "Categoria no se pudo Desactivar";
        break;
    case 'activar':
              $rspta = $categoria->activar($idcategoria);
              echo $rspta ? "Categoria Activada" : "Categoria no se pudo Activar";
        break;
    case 'mostrar':
              $rspta = $categoria->mostrar($idcategoria);
              //codificando el resultado utilizando json
              echo json_encode($rspta);
        break;
    case 'listar':
              $rspta = $categoria->listar();
              //declaracion de un array
              $data = Array();
              while ($reg=$rspta->fetch_object()) {
                  $data[]=array(
                      "0"=>$reg->idcategoria,
                      "1"=>$reg->nombre,
                      "2"=>$reg->descripcion,
                      "3"=>$reg->condicion
                  );
              }
              $results = array(
                  "sEcho"=>1,//informacion para el datatables
                  "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
                  "iTotalDisplayRecords"=>count($data),//enviamos el total regisros a visualizar
                  "aaData"=>$data
              );
              echo json_encode($results);
        break;
}

?>