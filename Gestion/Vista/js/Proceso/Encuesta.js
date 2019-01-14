var tablaEncuesta;

function init() {
    Iniciar_Componentes();
    Listar_Encuesta();
}

function Iniciar_Componentes() {
    $("#FormularioEncuesta").on("submit", function (e) {
        RegistroEncuesta(e);
    });
}

function RegistroEncuesta(event) {
    //cargar(true);
    event.preventDefault(); //No se activará la acción predeterminada del evento
    var error = "";
    $(".validarPanel").each(function () {
        if ($(this).val() == " " || $(this).val() == 0) {
            error = error + $(this).data("message") + "<br>";
        }
    });
    if (error == "") {
        $("#ModalEncuesta #cuerpo").addClass("whirl");
        $("#ModalEncuesta #cuerpo").addClass("ringed");
        AjaxRegistroEncuesta();
    }
    else {
        notificar_warning("Complete :<br>" + error);
    }
}

function AjaxRegistroEncuesta() {
    var formData = new FormData($("#FormularioEncuesta")[0]);
    console.log(formData);
    $.ajax({
        url: "../../Controlador/CEncuesta.php?op=AccionEncuesta"
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
                $("#ModalEncuesta #cuerpo").removeClass("whirl");
                $("#ModalEncuesta #cuerpo").removeClass("ringed");
                $("#ModalEncuesta").modal("hide");
                swal("Error:", Mensaje);
                LimpiarEncuesta();
                tablaEncuesta.ajax.reload();
            }
            else {
                $("#ModalEncuesta #cuerpo").removeClass("whirl");
                $("#ModalEncuesta #cuerpo").removeClass("ringed");
                $("#ModalEncuesta").modal("hide");
                swal("Acción:", Mensaje);
                LimpiarEncuesta();
                tablaEncuesta.ajax.reload();
            }
        }
    });
}

function Listar_Encuesta() {
    tablaEncuesta = $('#tablaEncuesta').dataTable({
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
                , "targets": [0, 1, 3, 4, 5]
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
            url: '../../Controlador/CEncuesta.php?op=Listar_Encuesta'
            , type: "POST"
            , dataType: "JSON"
            , error: function (e) {
                console.log(e.responseText);
            }
        }, // cambiar el lenguaje de datatable
        oLanguage: español
    , }).DataTable();
    //Aplicar ordenamiento y autonumeracion , index
    tablaEncuesta.on('order.dt search.dt', function () {
        tablaEncuesta.column(0, {
            search: 'applied'
            , order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function NuevoEncuesta() {
    $("#ModalEncuesta").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalEncuesta").modal("show");
    $("#tituloModalEncuesta").empty();
    $("#tituloModalEncuesta").append("Registro de Encuesta");
}

function EditarEncuesta(idEncuesta) {
    $("#ModalEncuesta").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalEncuesta").modal("show");
    $("#tituloModalEncuesta").empty();
    $("#tituloModalEncuesta").append("Edición de Encuesta");
    RecuperarEncuesta(idEncuesta);
}

function RecuperarEncuesta(idEncuesta) {
    //solicitud de recuperar Proveedor
    $.post("../../Controlador/CEncuesta.php?op=RecuperarInformacion_Encuesta", {
        "idEncuesta": idEncuesta
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#idEncuesta").val(data.idEncuesta);
        $("#EncuestaTitulo").val(data.TituloEncuesta);
        $("#EncuestaDetalle").val(data.DetalleEncuesta);
    });
}

function EliminarEncuesta(idEncuesta) {
    swal({
        title: "Eliminar?"
        , text: "Esta Seguro que desea Eliminar Encuesta!"
        , type: "warning"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Eliminar!"
        , closeOnConfirm: false
    }, function () {
        ajaxEliminarEncuesta(idEncuesta);
    });
}

function ajaxEliminarEncuesta(idEncuesta) {
    $.post("../../Controlador/CEncuesta.php?op=Eliminar_Encuesta", {
        idEncuesta: idEncuesta
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Eliminado!", Mensaje, "success");
            tablaEncuesta.ajax.reload();
        }
    });
}

function HabilitarEncuesta(idEncuesta) {
    swal({
        title: "Habilitar?"
        , text: "Esta Seguro que desea Habilitar Encuesta!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Habilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxHabilitarEncuesta(idEncuesta);
    });
}

function ajaxHabilitarEncuesta(idEncuesta) {
    $.post("../../Controlador/CEncuesta.php?op=Habilitar_Encuesta", {
        idEncuesta: idEncuesta
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Habilitado!", Mensaje, "success");
            tablaEncuesta.ajax.reload();
        }
    });
}

function InabilitarEncuesta(idEncuesta) {
    swal({
        title: "Inhabilitar?"
        , text: "Esta Seguro que desea Inhabilitar Encuesta!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Inhabilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxInHabilitarEncuesta(idEncuesta);
    });
}

function ajaxInHabilitarEncuesta(idEncuesta) {
    $.post("../../Controlador/CEncuesta.php?op=Inhabilitar_Encuesta", {
        idEncuesta: idEncuesta
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Inhabilitado!", Mensaje, "success");
            tablaEncuesta.ajax.reload();
        }
    });
}

function LimpiarEncuesta() {
    $('#FormularioEncuesta')[0].reset();
    $("#idEncuesta").val("");
}

function Cancelar() {
    LimpiarEncuesta();
    $("#ModalEncuesta").modal("hide");
}

function Preguntas(idEncuesta) {
    $.redirect('../Proceso/GeneracionEncuesta.php', {
        'idEncuesta': idEncuesta
    });
}

function Ver(idEncuesta) {
    $("#ModalVistaPrevia").modal("show");
    $.post("../../Controlador/CEncuesta.php?op=RecuperarEncuestaCompleta", {
        "idEncuesta": idEncuesta
    }, function (data, status) {
        data = JSON.parse(data);
        var Encuesta = "";
        var TituloEncuesta = data.EncuestaNombre;
        var Detalle = data.EncuestaDetalle;
        $("#tituloEncuesta").empty();
        $("#tituloEncuesta").text(TituloEncuesta);
        $("#DetalleEncuesta").empty();
        $("#DetalleEncuesta").text(Detalle);
        var ArregloPreguntas = data.Preguntas.split("&");
        ArregloPreguntas.pop();
        debugger;
        for (var i = 0; i < ArregloPreguntas.length; i++) {
            var Pregunta = ArregloPreguntas[i].split("|");
          Encuesta = AgregarTipoPregunta(Pregunta, Encuesta);
        }
         Encuesta=Encuesta+"<br><br><br><br>";
        $("#CuerpoEncuesta").html(Encuesta);
    });
}

function AgregarTipoPregunta(Pregunta, Encuesta) {
    Encuesta=Encuesta+' <div class="row Titulopregunta center_element">'+
                           '<div class="col-10 col-12-xsmall">'+
                               '<p class="texto-12px" align="justify">'+Pregunta[1]+'</p>'+
                           '</div>'+
                      ' </div>';
    if (Pregunta[2] == 1) {
      Encuesta=Encuesta+'<div class="row Titulopregunta center_element m-5">'+
                             '<div class="col-2 col-2-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion1-'+Pregunta[0]+'" name="satisfaccion-'+Pregunta[0]+'" value="1" checked>'+
                                '<label class="texto-12px" for="opcion1-'+Pregunta[0]+'">1</label>'+
                             '</div>'+
                             '<div class="col-2 col-2-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion2-'+Pregunta[0]+'" name="satisfaccion-'+Pregunta[0]+'" value="2">'+
                                '<label class="texto-12px"  for="opcion2-'+Pregunta[0]+'">2</label>'+
                             '</div>'+
                             '<div class="col-2 col-2-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion3-'+Pregunta[0]+'" name="satisfaccion-'+Pregunta[0]+'" value="3">'+
                                '<label class="texto-12px"  for="opcion3-'+Pregunta[0]+'">3</label>'+
                             '</div>'+
                             '<div class="col-2 col-2-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion4-'+Pregunta[0]+'" name="satisfaccion-'+Pregunta[0]+'" value="4">'+
                                '<label class="texto-12px"  for="opcion4-'+Pregunta[0]+'">4</label>'+
                             '</div>'+
                             '<div class="col-2 col-2-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion5-'+Pregunta[0]+'" name="satisfaccion-'+Pregunta[0]+'" value="5">'+
                                '<label class="texto-12px"  for="opcion5-'+Pregunta[0]+'">5</label>'+
                             '</div>' +
                        '</div>';
    }
    else if (Pregunta[2] == 2) {
      Encuesta=Encuesta+' <div class="row Titulopregunta center_element m-5">'+
                             '<div class="col-4 col-4-small">'+
                                '<input class="pregunta2" data-tipo="2" data-pregunta="'+Pregunta[0]+'" type="radio" id="opcionA-'+Pregunta[0]+'" name="condicion-'+Pregunta[0]+'" value="1" checked>'+
                                '<label class="texto-12px"  for="opcionA-'+Pregunta[0]+'">SI</label>'+
                             '</div>'+
                             '<div class="col-4 col-4-small">'+
                                '<input class="pregunta2" data-tipo="2" data-pregunta="'+Pregunta[0]+'" type="radio" id="opcionB-'+Pregunta[0]+'" name="condicion-'+Pregunta[0]+'" value="2">'+
                                '<label class="texto-12px"  for="opcionB-'+Pregunta[0]+'">NO</label> '+
                             '</div>'+
                             '<div class="col-4 col-4-small">'+
                                '<input class="pregunta2" data-tipo="2" data-pregunta="'+Pregunta[0]+'" type="radio" id="opcionC-'+Pregunta[0]+'" name="condicion-'+Pregunta[0]+'" value="3">'+
                                '<label class="texto-12px" for="opcionC-'+Pregunta[0]+'">NO SABE/NO OPINA</label>'+
                             '</div>'+
                        '</div>';
    }
    else if (Pregunta[2] == 3) {
        Encuesta=Encuesta+'<div class="row Titulopregunta center_element m-5">'+
                                 '<div class="col-10 col-12-xsmall">'+
                                   ' <textarea class="pregunta3" data-tipo="3" data-pregunta="'+Pregunta[0]+'" required placeholder="Ingrese Respuesta" rows="2" name="descripcion-'+Pregunta[0]+'"></textarea>'+
                                '</div> '+
                            '</div>';
    }else if(Pregunta[2] == 4){
        Encuesta=Encuesta+'<div class="row Titulopregunta center_element m-5">'+
                             '<div class="col-3 col-3-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion1-'+Pregunta[0]+'" name="satisfaccion2-'+Pregunta[0]+'" value="1" checked>'+
                                '<label class="texto-12px" for="opcion1-'+Pregunta[0]+'">MALO</label>'+
                             '</div>'+
                             '<div class="col-3 col-3-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion2-'+Pregunta[0]+'" name="satisfaccion2-'+Pregunta[0]+'" value="2">'+
                                '<label class="texto-12px"  for="opcion2-'+Pregunta[0]+'">REGULAR</label>'+
                             '</div>'+
                             '<div class="col-3 col-3-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion3-'+Pregunta[0]+'" name="satisfaccion2-'+Pregunta[0]+'" value="3">'+
                                '<label class="texto-12px"  for="opcion3-'+Pregunta[0]+'">BUENO</label>'+
                             '</div>'+
                             '<div class="col-3 col-3-small">'+
                                '<input class="pregunta1" data-tipo="1" data-pregunta="'+Pregunta[0]+'"  type="radio" id="opcion4-'+Pregunta[0]+'" name="satisfaccion2-'+Pregunta[0]+'" value="4">'+
                                '<label class="texto-12px"  for="opcion4-'+Pregunta[0]+'">MUY BUENO</label>'+
                             '</div>'+

                        '</div>';
    }

    return Encuesta;
}
init();
