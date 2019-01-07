var tablaUsuario;

function init() {
    Iniciar_Componentes();
    Listar_Usuario();
}

function Iniciar_Componentes() {
    //var fecha=hoyFecha();
    //$('#date_fecha_comprobante').datepicker('setDate',fecha);
    $("#FormularioUsuario").on("submit", function (e) {
        RegistroUsuario(e);
    });
}

function RegistroUsuario(event) {
    //cargar(true);
    event.preventDefault(); //No se activará la acción predeterminada del evento
    var error = "";
    $(".validarPanel").each(function () {
        if ($(this).val() == " " || $(this).val() == 0) {
            error = error + $(this).data("message") + "<br>";
        }
    });
    if (error == "") {
        $("#ModalUsuario #cuerpo").addClass("whirl");
        $("#ModalUsuario #cuerpo").addClass("ringed");
        setTimeout('AjaxRegistroUsuario()', 2000);
    }
    else {
        notificar_warning("Complete :<br>" + error);
    }
}

function AjaxRegistroUsuario() {
    var formData = new FormData($("#FormularioUsuario")[0]);
    console.log(formData);
    $.ajax({
        url: "../../Controlador/CUsuario.php?op=AccionUsuario"
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
                $("#ModalUsuario #cuerpo").removeClass("whirl");
                $("#ModalUsuario #cuerpo").removeClass("ringed");
                $("#ModalUsuario").modal("hide");
                swal("Error:", Mensaje);
                LimpiarUsuario();
                tablaUsuario.ajax.reload();
            }
            else {
                $("#ModalUsuario #cuerpo").removeClass("whirl");
                $("#ModalUsuario #cuerpo").removeClass("ringed");
                $("#ModalUsuario").modal("hide");
                swal("Acción:", Mensaje);
                LimpiarUsuario();
                tablaUsuario.ajax.reload();
            }
        }
    });
}

function Listar_Usuario() {
    tablaUsuario = $('#tablaUsuario').dataTable({
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
                , "targets": [2]
            }
         , ]
        , "ajax": { //Solicitud Ajax Servidor
            url: '../../Controlador/CUsuario.php?op=Listar_Usuario'
            , type: "POST"
            , dataType: "JSON"
            , error: function (e) {
                console.log(e.responseText);
            }
        }
        , // cambiar el lenguaje de datatable
        oLanguage: español
    , }).DataTable();
    //Aplicar ordenamiento y autonumeracion , index
    tablaUsuario.on('order.dt search.dt', function () {
        tablaUsuario.column(0, {
            search: 'applied'
            , order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function NuevoUsuario() {
    $("#ModalUsuario").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalUsuario").modal("show");
    $("#tituloModalUsuario").empty();
    $("#tituloModalUsuario").append("Registro de Usuario");
    $("#UsuarioPass").addClass("validarPanel");
}

function EditarUsuario(idUsuario) {
    $("#ModalUsuario").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalUsuario").modal("show");
    $("#tituloModalUsuario").empty();
    $("#tituloModalUsuario").append("Edición de Usuario");

    $("#UsuarioPass").removeClass("validarPanel");
    RecuperarUsuario(idUsuario);
}

function RecuperarUsuario(idUsuario) {
    //solicitud de recuperar Proveedor
    $.post("../../Controlador/CUsuario.php?op=RecuperarInformacion_Usuario", {
        "idUsuario": idUsuario
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#idUsuario").val(data.idUsuario);
        $("#UsuarioNombre").val(data.NombreUsuario);
        $("#UsuarioUsuario").val(data.usuario);

    });
}

function EliminarUsuario(idUsuario) {
    swal({
        title: "Eliminar?"
        , text: "Esta Seguro que desea Eliminar Usuario!"
        , type: "warning"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Eliminar!"
        , closeOnConfirm: false
    }, function () {
        ajaxEliminarUsuario(idUsuario);
    });
}

function ajaxEliminarUsuario(idUsuario) {
    $.post("../../Controlador/CUsuario.php?op=Eliminar_Usuario", {
        idUsuario: idUsuario
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Eliminado!", Mensaje, "success");
            tablaUsuario.ajax.reload();
        }
    });
}

function HabilitarUsuario(idUsuario) {
    swal({
        title: "Habilitar?"
        , text: "Esta Seguro que desea Habilitar Usuario!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Habilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxHabilitarUsuario(idUsuario);
    });
}

function ajaxHabilitarUsuario(idUsuario) {
    $.post("../../Controlador/CUsuario.php?op=Habilitar_Usuario", {
        idUsuario: idUsuario
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Habilitado!", Mensaje, "success");
            tablaUsuario.ajax.reload();
        }
    });
}

function InabilitarUsuario(idUsuario) {
    swal({
        title: "Inhabilitar?"
        , text: "Esta Seguro que desea Inhabilitar Usuario!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Inhabilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxInHabilitarUsuario(idUsuario);
    });
}

function ajaxInHabilitarUsuario(idUsuario) {
    $.post("../../Controlador/CUsuario.php?op=Inhabilitar_Usuario", {
        idUsuario: idUsuario
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Inhabilitado!", Mensaje, "success");
            tablaUsuario.ajax.reload();
        }
    });
}

function LimpiarUsuario() {
    $('#FormularioUsuario')[0].reset();
    $("#idUsuario").val("");
}

function Cancelar() {
    LimpiarUsuario();
    $("#ModalUsuario").modal("hide");
}
init();
