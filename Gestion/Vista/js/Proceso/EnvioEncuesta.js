var tablaEnvioRealizados;
function init(){
    Listar_Envios_Realizados();
}

function NuevoEnvio(){
     $.redirect('../Proceso/EnvioClientes.php');
}

function Listar_Envios_Realizados(){

     tablaEnvioRealizados = $('#tablaEnviosRealizados').dataTable({
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
                , "targets": [0, 1,2,3]
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
            url: '../../Controlador/CEncuesta.php?op=ListarEnviosRealizados'
            , type: "POST"
            , dataType: "JSON"
            , error: function (e) {
                console.log(e.responseText);
            }
        }, // cambiar el lenguaje de datatable
        oLanguage: español
    , }).DataTable();
    //Aplicar ordenamiento y autonumeracion , index
    tablaEnvioRealizados.on('order.dt search.dt', function () {
        tablaEnvioRealizados.column(0, {
            search: 'applied'
            , order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function ResultadoEnvio(CodigoEnvio){
    $.redirect('../Proceso/ResultadoEncuesta.php',{
        'CodigoEnvio':CodigoEnvio
    });
}

init();
