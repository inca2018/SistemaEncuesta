var tablaClientesDisponibles;
function init(){
    Listar_Encuestas_Disponibles();
    Listar_Clientes();
}

function Listar_Encuestas_Disponibles(){
     $.post("../../Controlador/CEncuesta.php?op=ListarEncuestasDisponibles", function (ts) {
          $("#EncuestasDisponibles").empty();
          $("#EncuestasDisponibles").append(ts);
     });

}
function Listar_Clientes(){

     tablaClientesDisponibles = $('#tablaClientesSeleccion').dataTable({
        "aProcessing": true
        , "aServerSide": true
        , "processing": true
        , "paging": true, // Paginacion en tabla
        "ordering": true, // Ordenamiento en columna de tabla
        "info": true, // Informacion de cabecera tabla
        "responsive": true, // Accion de responsive
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        , "order": [[0, "asc"]]
        , "bDestroy": true
        , "columnDefs": [
            {
                "className": "text-center"
                , "targets": [0, 1,2]
            }
            , {
                "className": "text-left"
                , "targets": []
            }, {
                "className": "text-right"
                , "targets": []
            }
         , ]
        , "ajax": { //Solicitud Ajax Servidor
            url: '../../Controlador/CEncuesta.php?op=ListarClientesDisponibles'
            , type: "POST"
            , dataType: "JSON"
            , error: function (e) {
                console.log(e.responseText);
            }
        }, // cambiar el lenguaje de datatable
        oLanguage: español
    , }).DataTable();
    //Aplicar ordenamiento y autonumeracion , index
    tablaClientesDisponibles.on('order.dt search.dt', function () {
        tablaClientesDisponibles.column(0, {
            search: 'applied'
            , order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function EnviarEncuesta(){

    var ArregloClientes=new Array();

    var CadenaClientes="";

    $('.Seleccionar:checked').each(function () {
        var id = $(this).data("id");
        ArregloClientes.push(id);
        CadenaClientes=CadenaClientes+id+"-";
    });

    CadenaClientes=CadenaClientes.slice(0,-1);
    console.log(CadenaClientes);
    var idEncuesta=$("#EncuestasDisponibles").val();

    if(idEncuesta==0 || idEncuesta==""){
          notificar_warning("Seleccione Encuesta!");
    }else{
       if(CadenaClientes.length==0){
           notificar_warning("Seleccione Al menos un Cliente para Envio!");
          }else{
              EnviarEncuestasAviso(idEncuesta,CadenaClientes);
          }
    }
}


function EnviarEncuestasAviso(idEncuesta,CadenaClientes) {
    swal({
        title: "Enviar?"
        , text: "Esta Seguro que desea Enviar Encuesta!"
        , type: "warning"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Enviar!"
        , closeOnConfirm: false
    }, function () {
        ajaxEnviarEncuesta(idEncuesta,CadenaClientes);
    });
}

function ajaxEnviarEncuesta(idEncuesta,CadenaClientes) {
    $.post("../../Controlador/CEncuesta.php?op=Enviar_Encuesta", {
        idEncuesta: idEncuesta,
        ArregloClientes:CadenaClientes,
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        var CodigoEnvio = data.CodigoEnvio;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            EnvioCorreoClientes(CodigoEnvio);
            console.log("Codigo Envio:"+CodigoEnvio);
        }
    });
}

function EnvioCorreoClientes(CodigoEnvio){
     $.post("../../Controlador/CEncuesta.php?op=Enviar_Correo_Cliente", {
        CodigoEnvio: CodigoEnvio,
    }, function (data, e) {
        data = JSON.parse(data);
        var Enviar = data.Enviar;
        var Mensaje = data.Mensaje;
        var CodigoEnvio = data.CodigoEnvio;
        if (!Enviar) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal({
              title: "Encuesta Enviada!",
               text: Mensaje,
               type: "success"
              },
              function(){
              $.redirect('../Proceso/EnvioEncuesta.php');
            });

        }
    });
}

init();
