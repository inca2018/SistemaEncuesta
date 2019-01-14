var tablaEntidad;

function init() {
    Iniciar_Componentes();
    Listar_Entidad();
}

function Iniciar_Componentes() {
    //var fecha=hoyFecha();
    //$('#date_fecha_comprobante').datepicker('setDate',fecha);
    $("#FormularioEntidad").on("submit", function (e) {
        RegistroEntidad(e);
    });
}

function RegistroEntidad(event) {
    //cargar(true);
    event.preventDefault(); //No se activará la acción predeterminada del evento
    var error = "";
    $(".validarPanel").each(function () {
        if ($(this).val() == " " || $(this).val() == 0) {
            error = error + $(this).data("message") + "<br>";
        }
    });
    if (error == "") {
        $("#ModalEntidad #cuerpo").addClass("whirl");
        $("#ModalEntidad #cuerpo").addClass("ringed");
        AjaxRegistroEntidad();
    }
    else {
        notificar_warning("Complete :<br>" + error);
    }
}

function AjaxRegistroEntidad() {
    var formData = new FormData($("#FormularioEntidad")[0]);
    console.log(formData);
    $.ajax({
        url: "../../Controlador/CEntidad.php?op=AccionEntidad"
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
                $("#ModalEntidad #cuerpo").removeClass("whirl");
                $("#ModalEntidad #cuerpo").removeClass("ringed");
                $("#ModalEntidad").modal("hide");
                swal("Error:", Mensaje);
                LimpiarEntidad();
                tablaEntidad.ajax.reload();
            }
            else {
                $("#ModalEntidad #cuerpo").removeClass("whirl");
                $("#ModalEntidad #cuerpo").removeClass("ringed");
                $("#ModalEntidad").modal("hide");
                swal("Acción:", Mensaje);
                LimpiarEntidad();
                tablaEntidad.ajax.reload();
            }
        }
    });
}

function Listar_Entidad() {
    tablaEntidad = $('#tablaEntidad').dataTable({
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
            url: '../../Controlador/CEntidad.php?op=Listar_Entidad'
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
    tablaEntidad.on('order.dt search.dt', function () {
        tablaEntidad.column(0, {
            search: 'applied'
            , order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function NuevoEntidad() {
    $("#ModalEntidad").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalEntidad").modal("show");
    $("#tituloModalEntidad").empty();
    $("#tituloModalEntidad").append("Registro de Entidad");
}

function EditarEntidad(idEntidad) {
    $("#ModalEntidad").modal({
        backdrop: 'static'
        , keyboard: false
    });
    $("#ModalEntidad").modal("show");
    $("#tituloModalEntidad").empty();
    $("#tituloModalEntidad").append("Edición de Entidad");
    RecuperarEntidad(idEntidad);
}

function RecuperarEntidad(idEntidad) {
    //solicitud de recuperar Proveedor
    $.post("../../Controlador/CEntidad.php?op=RecuperarInformacion_Entidad", {
        "idEntidad": idEntidad
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#idEntidad").val(data.idEntidad);
        $("#EntidadRazonSocial").val(data.RazonSocial);
        $("#EntidadRUC").val(data.RUC);
        $("#EntidadContacto").val(data.NombreContacto);
        $("#EntidadCorreo").val(data.CorreoContacto);
        $("#EntidadDireccion").val(data.Direccion);
    });
}

function EliminarEntidad(idEntidad) {
    swal({
        title: "Eliminar?"
        , text: "Esta Seguro que desea Eliminar Entidad!"
        , type: "warning"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Eliminar!"
        , closeOnConfirm: false
    }, function () {
        ajaxEliminarEntidad(idEntidad);
    });
}

function ajaxEliminarEntidad(idEntidad) {
    $.post("../../Controlador/CEntidad.php?op=Eliminar_Entidad", {
        idEntidad: idEntidad
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Eliminado!", Mensaje, "success");
            tablaEntidad.ajax.reload();
        }
    });
}

function HabilitarEntidad(idEntidad) {
    swal({
        title: "Habilitar?"
        , text: "Esta Seguro que desea Habilitar Entidad!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Habilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxHabilitarEntidad(idEntidad);
    });
}

function ajaxHabilitarEntidad(idEntidad) {
    $.post("../../Controlador/CEntidad.php?op=Habilitar_Entidad", {
        idEntidad: idEntidad
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Habilitado!", Mensaje, "success");
            tablaEntidad.ajax.reload();
        }
    });
}

function InabilitarEntidad(idEntidad) {
    swal({
        title: "Inhabilitar?"
        , text: "Esta Seguro que desea Inhabilitar Entidad!"
        , type: "info"
        , showCancelButton: true
        , confirmButtonColor: "#DD6B55"
        , confirmButtonText: "Si, Inhabilitar!"
        , closeOnConfirm: false
    }, function () {
        ajaxInHabilitarEntidad(idEntidad);
    });
}

function ajaxInHabilitarEntidad(idEntidad) {
    $.post("../../Controlador/CEntidad.php?op=Inhabilitar_Entidad", {
        idEntidad: idEntidad
    }, function (data, e) {
        data = JSON.parse(data);
        var Error = data.Error;
        var Mensaje = data.Mensaje;
        if (Error) {
            swal("Error", Mensaje, "error");
        }
        else {
            swal("Inhabilitado!", Mensaje, "success");
            tablaEntidad.ajax.reload();
        }
    });
}

function LimpiarEntidad() {
    $('#FormularioEntidad')[0].reset();
    $("#idEntidad").val("");
}

function Cancelar() {
    LimpiarEntidad();
    $("#ModalEntidad").modal("hide");
}

function Clientes(idEntidad){
    $.redirect('../Mantenimiento/Cliente.php', {
        'idEntidad': idEntidad
    });
}

init();
