<?php
require "../modelo/Articulo.php";

$articulo = new Articulo();

$idarticulo = isset($_POST["idarticulo"]) ? limpiarCadena($_POST["idarticulo"]) : "" ;
$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "" ;
$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "" ;
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "" ;
$stock = isset($_POST["stock"]) ? limpiarCadena($_POST["stock"]) : "" ;
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "" ;
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "" ;

switch ($_GET["op"]) {
    case 'guardaryeditar':

            if (!file_exists($_FILES['imagen'][tmp_name]) || !is_uploaded_file($_FILES['imagen'][tmp_name]) ) {
                $imagen="";
            }else {
                $ext = explode(".", $_FILES['imagen'][tmp_name]);
                if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                    
                    $imagen = round(microtime(true)). '.' .end($ext);
                    move_uploaded_file($_FILE["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
                }
            }
          if (empty($idarticulo)) {
              $rspta = $articulo->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
              echo $rspta ? "Articulo Registrado" : "Articulo no se pudo registrar";
          }else {
              $rspta = $articulo->editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
              echo $rspta ? "Articulo Actualizado" : "Articulo no se pudo Actualizar";
          }
        
        break;
    case 'desactivar':
              $rspta = $articulo->desactivar($idarticulo);
              echo $rspta ? "Articulo Desactivado" : "Articulo no se pudo Desactivar";
        break;
    case 'activar':
              $rspta = $articulo->activar($idarticulo);
              echo $rspta ? "Articulo Activado" : "Articulo no se pudo Activar";
        break;
    case 'mostrar':
              $rspta = $articulo->mostrar($idarticulo);
              //codificando el resultado utilizando json
              echo json_encode($rspta);
        break;
    case 'listar':
              $rspta = $articulo->listar();
              //declaracion de un array
              $data = Array();
              while ($reg=$rspta->fetch_object()) {
                  $data[]=array(
                      "0"=>($reg->condicion) ? '<button type="button" class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                          ' <button type="button" class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>' :
                          ' <button type="button" class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                          ' <button type="button" class="btn btn-primary" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',
                      "1"=>$reg->nombre,
                      "2"=>$reg->ncategoria,
                      "3"=>$reg->codigo,
                      "4"=>$reg->stock,
                      "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' alt='".$reg->imagen."'>",
                      "6"=>($reg->condicion) ? '<span class="label bg-green">Activado</span>':
                                               '<span class="label bg-red">Desactivado</span>'
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