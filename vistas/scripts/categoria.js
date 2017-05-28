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
    $("#idcategoria").val("");
    $("#nombre").val("");
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
                url :  '../ajax/categoria.php?op=listar',
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
        url: "../ajax/categoria.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
           // alert(datos);
            //mostrarform(false);
            //tabla.ajax.reload();
        }
    });

    limpiar();
}

init();