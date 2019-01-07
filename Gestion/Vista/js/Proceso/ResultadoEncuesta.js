var tablaResultadoCliente;
var tablaResultadoPregunta;
var tablaResultadoTipo3;

function init() {
    var CodigoEnvio = $("#CodigoEnvio").val();
    MostrarGrafico(CodigoEnvio);
    ListarClientesEnvio(CodigoEnvio);
    ListarPreguntaEnvio(CodigoEnvio);
}

function ListarPreguntaEnvio(CodigoEnvio) {
    tablaResultadoPregunta = $('#tablaPreguntasResultados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "processing": true,
        "paging": true, // Paginacion en tabla
        "ordering": true, // Ordenamiento en columna de tabla
        "info": true, // Informacion de cabecera tabla
        "responsive": true, // Accion de responsive
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "order": [[0, "asc"]],
        "bDestroy": true,
        "columnDefs": [
            {
                "className": "centrar_texto",
                "targets": [0, 1, 2, 3, 4]
            }
            , {
                "className": "text-left",
                "targets": []
            }, {
                "className": "text-right",
                "targets": []
            }
         , ],
        "ajax": { //Solicitud Ajax Servidor
            url: '../../Controlador/CEncuesta.php?op=ListarResultadosPregunta',
            type: "POST",
            dataType: "JSON",
            data: {
                CodigoEnvio: CodigoEnvio
            },
            error: function (e) {
                console.log(e.responseText);
            }
        }, // cambiar el lenguaje de datatable
        oLanguage: español,
    }).DataTable();
    //Aplicar ordenamiento y autonumeracion , index
    tablaResultadoPregunta.on('order.dt search.dt', function () {
        tablaResultadoPregunta.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function ListarClientesEnvio(CodigoEnvio) {
    tablaResultadoCliente = $('#tablaClientesResultados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "processing": true,
        "paging": true, // Paginacion en tabla
        "ordering": true, // Ordenamiento en columna de tabla
        "info": true, // Informacion de cabecera tabla
        "responsive": true, // Accion de responsive
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "order": [[0, "asc"]],
        "bDestroy": true,
        "columnDefs": [
            {
                "className": "centrar_texto",
                "targets": [0, 1, 2, 3]
            }
            , {
                "className": "text-left",
                "targets": []
            }, {
                "className": "text-right",
                "targets": []
            }
         , ],
        "ajax": { //Solicitud Ajax Servidor
            url: '../../Controlador/CEncuesta.php?op=ListarResultadosCliente',
            type: "POST",
            dataType: "JSON",
            data: {
                CodigoEnvio: CodigoEnvio
            },
            error: function (e) {
                console.log(e.responseText);
            }
        }, // cambiar el lenguaje de datatable
        oLanguage: español,
    }).DataTable();
    //Aplicar ordenamiento y autonumeracion , index
    tablaResultadoCliente.on('order.dt search.dt', function () {
        tablaResultadoCliente.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

function MostrarGrafico(CodigoEnvio) {

    //solicitud de recuperar
    $.post("../../Controlador/CEncuesta.php?op=RecuperarGraficoResultado", {
        "CodigoEnvio": CodigoEnvio
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);


        $("#EncuestaNombre").empty();
        $("#EncuestaEstado").empty();

        $("#EncuestaNombre").text(data.TituloEncuesta);
        var numClientes = data.NuMClientes;
        var respuesta = data.CantidadResultado;

        $("#EncuestaEstado").text(Formato_Moneda((respuesta * 100) / numClientes, 2) + " %");

        var Activo = (respuesta * 100) / numClientes;
        var noActivo = 100 - Activo;



        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                      Activo,
                      noActivo,
					],
                    backgroundColor: [
						window.chartColors.green,
						window.chartColors.red,
					],
                    label: 'Dataset 1'
				}],
                labels: [
					'Encuestas Resueltas',
					'Encuestas No Resueltas',
				]
            },
            options: {
                responsive: true,
                showAllTooltips: true,
                animationSteps: 100,
                animationEasing: 'easeInOutQuart',
                scaleShowLabels: true,

                // Draw the tooltips when the animation is completed
                onAnimationComplete: function () {
                    this.showTooltip(this.segments);
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var precentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            var respues = Formato_Moneda(currentValue, 2);
                            return respues + " %";
                        }
                    }
                }
            }
        };



        window.onload = function () {
            var ctx = document.getElementById('chart-area').getContext('2d');
            window.myPie = new Chart(ctx, config);
        };
    });


}

function RegresarEnvios() {
    $.redirect('../Proceso/EnvioEncuesta.php');
}

function InformacionPregunta(idPregunta, TipoPregunta) {


    var CodigoEnvio = $("#CodigoEnvio").val();

    console.log(TipoPregunta);
    $("#tipo_pregunta_1").hide();
    $("#tipo_pregunta_2").hide();
    $("#tipo_pregunta_3").hide();
    $("#tipo_pregunta_4").hide();
    if (TipoPregunta == 1) {
        $("#tipo_pregunta_1").show();
        TipoPregunta1(CodigoEnvio, idPregunta);
    } else if (TipoPregunta == 2) {
        $("#tipo_pregunta_2").show();
        TipoPregunta2(CodigoEnvio, idPregunta);
    } else if (TipoPregunta == 3) {
        $("#tipo_pregunta_3").show();
        TipoPregunta3(CodigoEnvio, idPregunta);
    } else if(TipoPregunta == 4){
        $("#tipo_pregunta_4").show();
        TipoPregunta4(CodigoEnvio, idPregunta);
    }

}

function TipoPregunta1(CodigoEnvio, idPregunta) {
    $("#ModalResultado").modal("show");
    //solicitud de recuperar Proveedor
    $.post("../../Controlador/CEncuesta.php?op=RecuperarGraficoResultadoPregunta1", {
        "CodigoEnvio": CodigoEnvio,
        "idPregunta": idPregunta
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);

        if (window.myPie2 != null) {
            window.myPie2.destroy();
        }

        $("#PreguntaNombre").empty();
        $("#PreguntaNombre").text(data.DetallePregunta);

        var TotalRespuestas = data.TotalRespuestas;
        var TotalOpcion1 = data.Opcion1;
        var TotalOpcion2 = data.Opcion2;
        var TotalOpcion3 = data.Opcion3;
        var TotalOpcion4 = data.Opcion4;
        var TotalOpcion5 = data.Opcion5;

        $("#respuesta_opcion1").empty();
        $("#respuesta_opcion1").text(TotalOpcion1);
        $("#respuesta_opcion2").empty();
        $("#respuesta_opcion2").text(TotalOpcion2);
        $("#respuesta_opcion3").empty();
        $("#respuesta_opcion3").text(TotalOpcion3);
        $("#respuesta_opcion4").empty();
        $("#respuesta_opcion4").text(TotalOpcion4);
        $("#respuesta_opcion5").empty();
        $("#respuesta_opcion5").text(TotalOpcion5);

        var GraficoOpcion1 = (TotalOpcion1 * 100) / TotalRespuestas;
        var GraficoOpcion2 = (TotalOpcion2 * 100) / TotalRespuestas;
        var GraficoOpcion3 = (TotalOpcion3 * 100) / TotalRespuestas;
        var GraficoOpcion4 = (TotalOpcion4 * 100) / TotalRespuestas;
        var GraficoOpcion5 = (TotalOpcion5 * 100) / TotalRespuestas;


        var configuracion = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                      GraficoOpcion1,
                      GraficoOpcion2,
                      GraficoOpcion3,
                      GraficoOpcion4,
                      GraficoOpcion5,

					],
                    backgroundColor: [
						window.chartColors.green,
						window.chartColors.red,
                  window.chartColors.orange,
                  window.chartColors.purple,
                  window.chartColors.yellow,
					],
                    label: 'Resultado'
				}],
                labels: [
					 'Opcion 1',
					 'Opcion 2',
                'Opcion 3',
                'Opcion 4',
                'Opcion 5',

				]
            },
            options: {
                responsive: true,
                showAllTooltips: true,
                animationSteps: 100,
                animationEasing: 'easeInOutQuart',
                scaleShowLabels: true,

                // Draw the tooltips when the animation is completed
                onAnimationComplete: function () {
                    this.showTooltip(this.segments);
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var precentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            var respues = Formato_Moneda(currentValue, 2);
                            return respues + " %";
                        }
                    }
                }
            }
        };

        var chartResultadoGr = document.getElementById('chartResultado').getContext('2d');
        window.myPie2 = new Chart(chartResultadoGr, configuracion);
    });
}

function TipoPregunta2(CodigoEnvio, idPregunta) {
    $("#ModalResultado").modal("show");
    //solicitud de recuperar Proveedor
    $.post("../../Controlador/CEncuesta.php?op=RecuperarGraficoResultadoPregunta2", {
        "CodigoEnvio": CodigoEnvio,
        "idPregunta": idPregunta
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);

        if (window.myPie3 != null) {
            window.myPie3.destroy();
        }

        $("#PreguntaNombre2").empty();
        $("#PreguntaNombre2").text(data.DetallePregunta);

        var TotalRespuestas = data.TotalRespuestas;
        var TotalOpcion1 = data.Opcion1;
        var TotalOpcion2 = data.Opcion2;
        var TotalOpcion3 = data.Opcion3;


        $("#respuesta_opcion1B").empty();
        $("#respuesta_opcion1B").text(TotalOpcion1);
        $("#respuesta_opcion2B").empty();
        $("#respuesta_opcion2B").text(TotalOpcion2);
        $("#respuesta_opcion3B").empty();
        $("#respuesta_opcion3B").text(TotalOpcion3);
        $("#respuesta_opcion4B").empty();


        var GraficoOpcion1 = (TotalOpcion1 * 100) / TotalRespuestas;
        var GraficoOpcion2 = (TotalOpcion2 * 100) / TotalRespuestas;
        var GraficoOpcion3 = (TotalOpcion3 * 100) / TotalRespuestas;


        var configuracion2 = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                      GraficoOpcion1,
                      GraficoOpcion2,
                      GraficoOpcion3,


					],
                    backgroundColor: [
						window.chartColors.green,
						window.chartColors.red,
                  window.chartColors.orange,

					],
                    label: 'Resultado'
				}],
                labels: [
					 'SI',
					 'NO',
                'NO SABE',


				]
            },
            options: {
                responsive: true,
                showAllTooltips: true,
                animationSteps: 100,
                animationEasing: 'easeInOutQuart',
                scaleShowLabels: true,

                // Draw the tooltips when the animation is completed
                onAnimationComplete: function () {
                    this.showTooltip(this.segments);
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var precentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            var respues = Formato_Moneda(currentValue, 2);
                            return respues + " %";
                        }
                    }
                }
            }
        };

        var chartResultadoGr2 = document.getElementById('chartResultado2').getContext('2d');
        window.myPie3 = new Chart(chartResultadoGr2, configuracion2);
    });
}

function TipoPregunta3(CodigoEnvio, idPregunta) {
    $("#ModalResultado").modal("show");
    if (tablaResultadoTipo3 == null) {
        tablaResultadoTipo3 = $('#tablaResultadosTipo3').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "processing": true,
            "paging": false, // Paginacion en tabla
            "ordering": true, // Ordenamiento en columna de tabla
            "info": false, // Informacion de cabecera tabla
            "responsive": true, // Accion de responsive
            //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            //"order": [[0, "asc"]],
            "searching":false,
            "bDestroy": true,
            "columnDefs": [
                {
                    "className": "centrar_texto",
                    "targets": [0, 1, 2]
            }
            , {
                    "className": "text-left",
                    "targets": []
            }, {
                    "className": "text-right",
                    "targets": []
            }
         , ],
            "ajax": { //Solicitud Ajax Servidor
                url: '../../Controlador/CEncuesta.php?op=RecuperarGraficoResultadoPregunta3',
                type: "POST",
                dataType: "JSON",
                data: {
                    CodigoEnvio: CodigoEnvio,
                    idPregunta:idPregunta
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            }, // cambiar el lenguaje de datatable
            oLanguage: español,
        }).DataTable();
        //Aplicar ordenamiento y autonumeracion , index
        tablaResultadoTipo3.on('order.dt search.dt', function () {
            tablaResultadoTipo3.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    } else {
        tablaResultadoTipo3.destroy();
        tablaResultadoTipo3 = $('#tablaResultadosTipo3').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "processing": true,
            "paging": false, // Paginacion en tabla
            "ordering": true, // Ordenamiento en columna de tabla
            "info": false, // Informacion de cabecera tabla
            "responsive": true, // Accion de responsive
            //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            //"order": [[0, "asc"]],
            "bDestroy": true,
             "searching":false,
            "columnDefs": [
                {
                    "className": "centrar_texto",
                    "targets": [0, 1, 2]
            }
            , {
                    "className": "text-left",
                    "targets": []
            }, {
                    "className": "text-right",
                    "targets": []
            }
         , ],
            "ajax": { //Solicitud Ajax Servidor
                url: '../../Controlador/CEncuesta.php?op=RecuperarGraficoResultadoPregunta3',
                type: "POST",
                dataType: "JSON",
                data: {
                    CodigoEnvio: CodigoEnvio,
                    idPregunta:idPregunta
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            }, // cambiar el lenguaje de datatable
            oLanguage: español,
        }).DataTable();
        //Aplicar ordenamiento y autonumeracion , index
        tablaResultadoTipo3.on('order.dt search.dt', function () {
            tablaResultadoTipo3.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

}

function TipoPregunta4(CodigoEnvio, idPregunta) {
    $("#ModalResultado").modal("show");
    //solicitud de recuperar Proveedor
    $.post("../../Controlador/CEncuesta.php?op=RecuperarGraficoResultadoPregunta1", {
        "CodigoEnvio": CodigoEnvio,
        "idPregunta": idPregunta
    }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);

        if (window.myPie4 != null) {
            window.myPie4.destroy();
        }

        $("#PreguntaNombre4").empty();
        $("#PreguntaNombre4").text(data.DetallePregunta);

        var TotalRespuestas = data.TotalRespuestas;
        var TotalOpcion1 = data.Opcion1;
        var TotalOpcion2 = data.Opcion2;
        var TotalOpcion3 = data.Opcion3;
        var TotalOpcion4 = data.Opcion4;


        $("#respuesta_opcion14").empty();
        $("#respuesta_opcion14").text(TotalOpcion1);
        $("#respuesta_opcion24").empty();
        $("#respuesta_opcion24").text(TotalOpcion2);
        $("#respuesta_opcion34").empty();
        $("#respuesta_opcion34").text(TotalOpcion3);
        $("#respuesta_opcion44").empty();
        $("#respuesta_opcion44").text(TotalOpcion4);

        var GraficoOpcion1 = (TotalOpcion1 * 100) / TotalRespuestas;
        var GraficoOpcion2 = (TotalOpcion2 * 100) / TotalRespuestas;
        var GraficoOpcion3 = (TotalOpcion3 * 100) / TotalRespuestas;
        var GraficoOpcion4 = (TotalOpcion4 * 100) / TotalRespuestas;



        var configuracion = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                      GraficoOpcion1,
                      GraficoOpcion2,
                      GraficoOpcion3,
                      GraficoOpcion4,


					],
                    backgroundColor: [
						window.chartColors.green,
						window.chartColors.red,
                  window.chartColors.orange,
                  window.chartColors.purple,

					],
                    label: 'Resultado'
				}],
                labels: [
					 'MALO',
					 'REGULAR',
                'BUENO',
                'MUY BUENO',

				]
            },
            options: {
                responsive: true,
                showAllTooltips: true,
                animationSteps: 100,
                animationEasing: 'easeInOutQuart',
                scaleShowLabels: true,

                // Draw the tooltips when the animation is completed
                onAnimationComplete: function () {
                    this.showTooltip(this.segments);
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var precentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            var respues = Formato_Moneda(currentValue, 2);
                            return respues + " %";
                        }
                    }
                }
            }
        };

        var chartResultadoGr = document.getElementById('chartResultado4').getContext('2d');
        window.myPie4 = new Chart(chartResultadoGr, configuracion);
    });
}

init();
