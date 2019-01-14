var tablaPregunta;

function init() {
    Iniciar_Componentes();
    Listar_Pregunta();
    Recuperar_Datos_Encuesta();
}

function Iniciar_Componentes() {

    $("#FormularioPregunta").on("submit", function (e) {
        RegistroPregunta(e);
    });
}

function Recuperar_Datos_Encuesta(){
      var idEncuesta=$("#idEncuesta").val();
     //solicitud de recuperar Proveedor
    $.post("../../Controlador/CPregunta.php?op=RecuperarDatosEncuesta",{
        "idEncuesta": idEncuesta
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#EncuestaNombre").empty();
        $("#EncuestaNombre").text(data.TituloEncuesta);
        $("#EncuestaDetalle").empty();
        $("#EncuestaDetalle").text(data.DetalleEncuesta);
    });
}

function Listar_Tipo_Pregunta(){
	 $.post("../../Controlador/CPregunta.php?op=listar_tiposPregunta", function (ts) {
      $("#TipoPregunta").empty();
      $("#TipoPregunta").append(ts);
 });
}

function RegistroPregunta(event) {
    //cargar(true);
    event.preventDefault(); //No se activará la acción predeterminada del evento
    var error = "";
    $(".validarPanel").each(function () {
        if ($(this).val() == " " || $(this).val() == 0) {
            error = error + $(this).data("message") + "<br>";
        }
    });
    if (error == "") {
        $("#ModalPregunta #cuerpo").addClass("whirl");
        $("#ModalPregunta #cuerpo").addClass("ringed");
        AjaxRegistroPregunta();
    }
    else {
        notificar_warning("Complete :<br>" + error);
    }
}

function AjaxRegistroPregunta() {
    var idEncuesta=$("#idEncuesta").val();
    var formData = new FormData($("#FormularioPregunta")[0]);

    formData.append("idEncuesta",idEncuesta);

    $.ajax({
        url: "../../Controlador/CPregunta.php?op=AccionPregunta"
        , type: "POST"
        , data: formData
        , contentType: false
        , processData: false
        , success: function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            var Mensaje = data.Mensaje;
            var Error = data.Registro;
            if (!Error) {
                $("#ModalPregunta #cuerpo").removeClass("whirl");
                $("#ModalPregunta #cuerpo").removeClass("ringed");
                $("#ModalPregunta").modal("hide");
                swal("Error:", Mensaje);
                LimpiarPregunta();
                tablaPregunta.ajax.reload();
            }
            else {
                $("#ModalPregunta #cuerpo").removeClass("whirl");
                $("#ModalPregunta #cuerpo").removeClass("ringed");
                $("#ModalPregunta").modal("hide");
                swal("Acción:", Mensaje);
                LimpiarPregunta();
                tablaPregunta.ajax.reload();
            }
        }
    });
}

function Listar_Pregunta() {
     var idEncuesta=$("#idEncuesta").val();
    tablaPregunta = $('#tablaPregunta').dataTable({
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
                , "targets": [0, 1, 3,4]
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
            url: '../../Controlador/CPregunta.php?op=Listar_Pregunta'
            , type: "POST"
            , dataType: "JSON"
            ,data:{idEncuesta:idEncuesta}
            , error: function (e) {
                console.log(e.responseText);
            }
        }
        , // cambiar el lenguaje de datatable
        oLanguage: español
    , }).DataTable();
    //Aplicar ordenamiento y autonumeracion , index
    tablaPregunta.on('order.dt search.dt', function () {
        tablaPregunta.column(0, {
            search: 'applied'
            , order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function NuevaPregunta() {
    $("#ModalPregunta").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalPregunta").modal("show");
    $("#tituloModalPregunta").empty();
    $("#tituloModalPregunta").append("Registro de Pregunta");
    Listar_Tipo_Pregunta();
}

function EditarPregunta(idPregunta) {
    $("#ModalPregunta").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalPregunta").modal("show");
    $("#tituloModalPregunta").empty();
    $("#tituloModalPregunta").append("Edición de Pregunta");
    RecuperarPregunta(idPregunta);
}

function RecuperarPregunta(idPregunta) {
    //solicitud de recuperar Proveedor
    $.post("../../Controlador/CPregunta.php?op=RecuperarInformacion_Pregunta", {
        "idPregunta": idPregunta
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#idPregunta").val(data.idPregunta);
        $("#PreguntaTitulo").val(data.DetallePregunta);

         $.post("../../Controlador/CPregunta.php?op=listar_tiposPregunta", function (ts) {
            $("#TipoPregunta").empty();
            $("#TipoPregunta").append(ts);
            $("#TipoPregunta").val(data.idTipoPregunta);
         });
    });
}

function EliminarPregunta(idPregunta) {
    swal({
        title: "Eliminar?"
        , text: "Esta Seguro que desea Eliminar Pregunta!"
        , type: "warning"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Eliminar!"
        , closeOnConfirm: false
    }, function () {
        ajaxEliminarPregunta(idPregunta);
    });
}

function ajaxEliminarPregunta(idPregunta) {
    $.post("../../Controlador/CPregunta.php?op=Eliminar_Pregunta", {
        idPregunta: idPregunta
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Eliminado!", Mensaje, "success");
            tablaPregunta.ajax.reload();
        }
    });
}

function HabilitarPregunta(idPregunta) {
    swal({
        title: "Habilitar?"
        , text: "Esta Seguro que desea Habilitar Pregunta!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Habilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxHabilitarPregunta(idPregunta);
    });
}

function ajaxHabilitarPregunta(idPregunta) {
    $.post("../../Controlador/CPregunta.php?op=Habilitar_Pregunta", {
        idPregunta: idPregunta
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Habilitado!", Mensaje, "success");
            tablaPregunta.ajax.reload();
        }
    });
}

function InabilitarPregunta(idPregunta) {
    swal({
        title: "Inhabilitar?"
        , text: "Esta Seguro que desea Inhabilitar Pregunta!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Inhabilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxInHabilitarPregunta(idPregunta);
    });
}

function ajaxInHabilitarPregunta(idPregunta) {
    $.post("../../Controlador/CPregunta.php?op=Inhabilitar_Pregunta", {
        idPregunta: idPregunta
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Inhabilitado!", Mensaje, "success");
            tablaPregunta.ajax.reload();
        }
    });
}

function LimpiarPregunta() {
    $('#FormularioPregunta')[0].reset();
    $("#idPregunta").val("");
}

function Cancelar() {
    LimpiarPregunta();
    $("#ModalPregunta").modal("hide");
}

function volver(){
     $.redirect('../Proceso/Encuestas.php');
}

init();
