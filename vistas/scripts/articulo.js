var tabla;

//funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    })
}

//funcion para limpiar
function limpiar() {
    $("#codigo").val("");
    $("#nombre").val("");
    $("#stock").val("");
    $("#descripcion").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
    }
    else
    {
       $("#listadoregistros").show();
       $("#formularioregistros").hide(); 
    }
}

//funcion cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//funcion listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,//activamos el procesamiento del datatable
        "aServerSide": true,//Paginacion y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax":
            {
                url :  '../ajax/articulo.php?op=listar',
                type : "get",
                dataType : "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },

            "bDestroy":true,//
            "iDisplayLength":5,//paginacion de 5 en 5
            "order": [[0, "desc"]]//ordenar d emanera descendente

    }).DataTable();
}

//funcion para guardar y editar
function guardaryeditar(e) {
    e.preventDefault();//No se activara la accion predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });

    limpiar();
}

//funcion para mostrar los registro a editar enlos compos de input
function mostrar(idarticulo) {
    $.post("../ajax/articulo.php?op=mostrar",{idarticulo : idarticulo}, function (data, status) 
    {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idcategoria").val(data.idcategoria);
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#idarticulo").val(data.idarticulo);

    })
}

//funcion para desactivar registros
function desactivar(idarticulo) {
    bootbox.confirm("Esta Seguro de desactivar el Articulo ? ", function (result) {
        if (result) {
            $.post("../ajax/articulo.php?op=desactivar", {idarticulo : idarticulo}, function (e) {
               bootbox.alert(e);
               tabla.ajax.reload(); 
            });
        }
    })
}

//funcion para activar registros
function activar(idarticulo) {
    bootbox.confirm("Esta Seguro de activar el Articulo ? ", function (result) {
        if (result) {
            $.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function (e) {
               bootbox.alert(e);
               tabla.ajax.reload(); 
            });
        }
    })
}

init();