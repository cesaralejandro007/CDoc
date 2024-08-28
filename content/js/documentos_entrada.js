var keyup_documento = /^[0-9]{1,10}$/; // Ajusta según el formato de tu documento
var keyup_descripcion = /^.{1,500}$/; // Ajusta según el rango de caracteres para la descripción

function obtenerIdTipo() {
    let input = $("#inputTipo").val();
    let options = document.getElementById('tipoDocumentos').options;
    let selectedId = '';

    for (let i = 0; i < options.length; i++) {
        if (options[i].value === input) {
            selectedId = options[i].getAttribute('data-id');
            break;
        }
    }

    return selectedId;
}

function obtenerIdRemitente() {
    let input = $("#inputRemitente").val();
    let options = document.getElementById('remitentes').options;
    let selectedId = '';

    for (let i = 0; i < options.length; i++) {
        if (options[i].value === input) {
            selectedId = options[i].getAttribute('data-id');
            break;
        }
    }

    return selectedId;
}


document.onload = carga();
function carga() {
    /*--------------VALIDACION PARA Nº DE DOCUMENTO--------------------*/
    document.getElementById("inputNumeroDocumento").maxLength = 10;
    document.getElementById("inputNumeroDocumento").onkeypress = function (e) {
        er = /^[0-9]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("inputNumeroDocumento").onkeyup = function () {
        r = validarkeyup(
            keyup_documento,
            this,
            document.getElementById("snumeroDocumento"),
            "* El formato debe ser un número de hasta 10 dígitos."
        );
    };
    /*--------------FIN VALIDACION PARA Nº DE DOCUMENTO--------------------*/

    /*--------------VALIDACION PARA DESCRIPCIÓN--------------------*/
    document.getElementById("inputDescripcion").onkeyup = function () {
        r = validarkeyup(
            keyup_descripcion,
            this,
            document.getElementById("sdescripcion"),
            "* La descripción debe tener entre 1 y 500 caracteres."
        );
    };
    /*--------------FIN VALIDACION PARA DESCRIPCIÓN--------------------*/

    /*--------------VALIDACION PARA TIPO DE DOCUMENTO--------------------*/
    document.getElementById("inputTipo").onchange = function () {
        r = validarselect(
            this,
            document.getElementById("stipo"),
            "* Seleccione un tipo de documento."
        );
    };
    /*--------------FIN VALIDACION PARA TIPO DE DOCUMENTO--------------------*/

    if ($("#inputTipoDocumento").val() == "1") {

        document.getElementById("inputRemitente").onchange = function () {
            r = validarselect(
                this,
                document.getElementById("sremitente"),
                "* Seleccione un nombre de remitente."
            );
        };

    }

    /*----------------------CRUD DEL MODULO------------------------*/
    document.getElementById("enviar").onclick = function () {
        a = valida_registrar();
        if (a != "") {
        } else if ($("#inputTipoDocumento").val() == 1) {
            var datos = new FormData();
            datos.append("accion", $("#accion").val());
            datos.append("id_documento", $("#id_documento").val());
            datos.append("tipoDocumento", obtenerIdTipo());
            datos.append("numeroDocumento", $("#inputNumeroDocumento").val());
            datos.append("fecha", $("#inputFecha").val());
            datos.append("remitente", obtenerIdRemitente());
            datos.append("descripcion", $("#inputDescripcion").val());
            enviaAjax(datos);
        } else if ($("#inputTipoDocumento").val() == 2) {
            var datos = new FormData();
            datos.append("accion", 'registrar_documento_sin_entrada');
            datos.append("id_documento", $("#id_documento").val());
            datos.append("tipoDocumento", obtenerIdTipo());
            datos.append("numeroDocumento", $("#inputNumeroDocumento").val());
            datos.append("descripcion", $("#inputDescripcion").val());
            enviaAjax(datos);
        }
    };

    document.getElementById("nuevo").onclick = function () {
        limpiar();
        $("#inputTipoDocumento").prop('disabled', false);
        $("#accion").val("registrar_documento_entrada");
        $("#exampleModalCenterTitle").text("Registrar Documento");
        $("#enviar").text("Registrar");
        $("#modalshowhide").modal("show");
    };

}

/*--------------------FIN DE CRUD DEL MODULO----------------------*/
/*-------------------FUNCIONES DE HERRAMIENTAS-------------------*/
function validarkeypress(er, e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if (!a) {
        e.preventDefault();
    }
}

function validarselect(etiqueta, etiquetamensaje, mensaje) {
    if (etiqueta.value === "" || etiqueta.value === null) {
        etiquetamensaje.innerText = mensaje;
        etiquetamensaje.style.color = "red";
        etiqueta.classList.add("is-invalid");
    } else {
        etiquetamensaje.innerText = "";
        etiqueta.classList.remove("is-invalid");
        etiqueta.classList.add("is-valid");
    }
}

function validarkeyup(er, etiqueta, etiquetamensaje, mensaje) {
    a = er.test(etiqueta.value);
    if (!a) {
        etiquetamensaje.innerText = mensaje;
        etiquetamensaje.style.color = "red";
        etiqueta.classList.add("is-invalid");
        return 0;
    } else {
        etiquetamensaje.innerText = "";
        etiqueta.classList.remove("is-invalid");
        etiqueta.classList.add("is-valid");
        return 1;
    }
}

document.getElementById("inputTipoDocumento").onchange = function () {
    limpiar();
}

function limpiar() {
    $("#inputNumeroDocumento").val("");
    $("#inputDescripcion").val("");
    $("#inputTipo").val("");
    $("#inputRemitente").val("");
    $("#inputFecha").val("");
    document.getElementById("snumeroDocumento").innerText = "";
    document.getElementById("sdescripcion").innerText = "";
    document.getElementById("stipo").innerText = "";
    document.getElementById("sremitente").innerText = "";
    document.getElementById("sfecha").innerText = "";
    document.getElementById("inputNumeroDocumento").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputDescripcion").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputTipo").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputRemitente").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputFecha").classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
    var error = false;
    var fechaDoc = false;
    var nombreRemitente = false;
    numeroDocumento = validarkeyup(
        keyup_documento,
        document.getElementById("inputNumeroDocumento"),
        document.getElementById("snumeroDocumento"),
        "* El formato debe ser un número de hasta 10 dígitos."
    );
    descripcion = validarkeyup(
        keyup_descripcion,
        document.getElementById("inputDescripcion"),
        document.getElementById("sdescripcion"),
        "* La descripción debe tener entre 1 y 500 caracteres."
    );

    if ($("#inputTipo").val() === "" || $("#inputTipo").val() === null || obtenerIdTipo() == "") {
        document.getElementById("stipo").innerText = "* Seleccione un tipo de documento.";
        document.getElementById("stipo").style.color = "red";
        document.getElementById("inputTipo").classList.add("is-invalid");
    } else {
        document.getElementById("stipo").innerText = "";
        document.getElementById("inputTipo").classList.remove("is-invalid");
        document.getElementById("inputTipo").classList.add("is-valid");
    }

    if ($("#inputTipoDocumento").val() == "1") {
        if ($("#inputFecha").val() == "") {
            document.getElementById("sfecha").innerText = "* Seleccione una fecha.";
            document.getElementById("sfecha").style.color = "red";
            document.getElementById("inputFecha").classList.add("is-invalid");
        } else {
            fechaDoc = true;
            document.getElementById("sfecha").innerText = "";
            document.getElementById("inputFecha").classList.remove("is-invalid");
            document.getElementById("inputFecha").classList.add("is-valid");
        }

        if ($("#inputRemitente").val() === "" || $("#inputRemitente").val() === null || obtenerIdRemitente() == "") {
            document.getElementById("sremitente").innerText = "* Seleccione un nombre de remitente.";
            document.getElementById("sremitente").style.color = "red";
            document.getElementById("inputRemitente").classList.add("is-invalid");
        } else {
            nombreRemitente = true;
            document.getElementById("sremitente").innerText = "";
            document.getElementById("inputRemitente").classList.remove("is-invalid");
            document.getElementById("inputRemitente").classList.add("is-valid");
        }
    }

    if (
        numeroDocumento === 0 ||
        descripcion === 0 ||
        $("#inputTipo").val() === "" ||
        obtenerIdTipo() == ""
    ) {
        error = true;
    } else if ($("#inputTipoDocumento").val() == "1") {
        if (fechaDoc == false || nombreRemitente == false) {
            error = true;
        } else {
            error = false;
        }
    }
    return error;
}

/*--------------------FIN DE FUNCIONES DE HERRAMIENTAS-------------------*/

function eliminar(id,numeroDocumento) {
    Swal.fire({
        title: "¿Está seguro de eliminar el registro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonColor: "#0C72C4",
        cancelButtonColor: "#9D2323",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(function () {
                var datos = new FormData();
                datos.append("accion", "eliminar");
                datos.append("id_documento", id);
                datos.append("numeroDocumento", numeroDocumento);
                enviaAjax(datos);
            }, 10);
        }
    });
}

function migrarDoc(id, numeroDocumento) {
    var datos_buscar = new FormData();
    datos_buscar.append("accion", "buscarData");
    $.ajax({
        url: "", // Proporciona la URL de tu servidor
        type: "POST",
        contentType: false,
        data: datos_buscar,
        processData: false,
        cache: false,
        success: (response) => {
            // Convierte la respuesta en un objeto de JavaScript
            const destinatarios = JSON.parse(response);

            // Crear datalist dinámicamente con data-id
            let datalist = '<datalist id="listaDestinatarios">';
            destinatarios.forEach((destinatario) => {
                datalist += `<option value="${destinatario.nombre_des}" data-id="${destinatario.id_destinatario}"></option>`;
            });
            datalist += '</datalist>';

            // Crear el input con el datalist
            Swal.fire({
                title: 'Selecciona un destinatario',
                html: `
                <div style="position: relative;">
                    <input type="date" id="fecha" class="swal2-input" style="margin-bottom: 15px;">
                    <input list="listaDestinatarios" id="destinatario" name="destinatario" class="swal2-input" placeholder="Seleccione destinatario" style="padding-right: 40px;">
                    <i class="fa fa-chevron-down" style="
                        position: absolute;
                        top: 82.5%;
                        right: 70px;
                        transform: translateY(-50%);
                        font-size: 16px;
                        color: #000;
                        pointer-events: none;
                    "></i>
                    ${datalist}
                </div>
                `,
                confirmButtonText: 'Migrar Documento',
                focusConfirm: false,
                preConfirm: () => {
                    const fecha = Swal.getPopup().querySelector('#fecha').value;
                    const destinatario = Swal.getPopup().querySelector('#destinatario').value;
                    const dataList = document.getElementById('listaDestinatarios');
                    let idDestinatario = '';

                    // Obtener el id_destinatario correspondiente al nombre seleccionado
                    for (let i = 0; i < dataList.options.length; i++) {
                        if (dataList.options[i].value === destinatario) {
                            idDestinatario = dataList.options[i].getAttribute('data-id');
                            break;
                        }
                    }

                    if (!fecha || !destinatario) {
                        Swal.showValidationMessage(`Por favor, selecciona una fecha y un destinatario`);
                    }

                    return { fecha: fecha, destinatario: destinatario, id_destinatario: idDestinatario };
                }
            }).then((result) => {
                var toastMixin = Swal.mixin({
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
                if (result.isConfirmed) {
                    var datos_migrar = new FormData();
                    datos_migrar.append("accion", "migrar_documento");
                    datos_migrar.append("fecha_salida", result.value.fecha);
                    datos_migrar.append("id_documento", id);
                    datos_migrar.append("id_destinatario", result.value.id_destinatario);
                    datos_migrar.append("numeroDocumento", numeroDocumento);
                    $.ajax({
                        url: "", // Proporciona la URL de tu servidor
                        type: "POST",
                        contentType: false,
                        data: datos_migrar,
                        processData: false,
                        cache: false,
                        success: (response) => {
                            var res = JSON.parse(response);
                            if (res.estatus == 1) {
                                toastMixin.fire({
                                    title: res.title,
                                    text: res.message,
                                    icon: res.icon
                                });
                                setTimeout(function () {
                                    window.location.href = "?pagina=" + res.url;
                                }, 2000);
                            } else {
                                toastMixin.fire({
                                    text: res.message,
                                    title: res.title,
                                    icon: res.icon,
                                });
                            }
                        },
                        error: (err) => {
                            Toast.fire({
                                icon: 'error',
                                text: 'Hubo un error en la solicitud.'
                            });
                        },
                    });
                }
            });
        },
        error: (err) => {
            Toast.fire({
                icon: 'error',
                text: 'Hubo un error en la solicitud.'
            });
        },
    });

}

function cargar_datos(id_documento) {

    $("#inputTipoDocumento").attr('disabled', 'disabled');

    var datos = new FormData();
    datos.append("accion", "editar");
    datos.append("id_documento", id_documento);
    mostrar(datos);
}

function enviaAjax(datos) {
    var toastMixin = Swal.mixin({
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });
    $.ajax({
        url: "", // Proporciona la URL de tu servidor
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: (response) => {
            var res = JSON.parse(response);
            if (res.estatus == 1) {
                toastMixin.fire({
                    title: res.title,
                    text: res.message,
                    icon: res.icon,
                });
                limpiar();
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            } else if (res.estatus == 2) {
                toastMixin.fire({
                    title: res.title,
                    text: res.message,
                    icon: res.icon
                });
                limpiar();
                setTimeout(function () {
                    window.location.replace("?pagina=" + res.url);
                }, 2000);
            } else {
                toastMixin.fire({
                    text: res.message,
                    title: res.title,
                    icon: res.icon,
                });
            }
        },
        error: (err) => {
            Toast.fire({
                icon: 'error',
                text: 'Hubo un error en la solicitud.'
            });
        },
    });
}

function mostrar(datos) {
    $.ajax({
        async: true,
        url: "",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: (response) => {
            var res = JSON.parse(response);
            limpiar();
            $("#id_documento").val(res.id_documento);
            $("#inputNumeroDocumento").val(res.numero_doc);
            $("#inputFecha").val(res.fecha_entrada);
            $("#inputTipo").val(res.nombre_doc);
            $("#inputRemitente").val(res.nombre_rem);
            $("#inputDescripcion").val(res.descripcion);
            $("#enviar").text("Modificar");
            $("#modalshowhide").modal("show");
            $("#accion").val("modificar");
            $("#exampleModalCenterTitle").text("Modificar Documento");
        },
        error: (err) => {
            Toast.fire({
                icon: error.icon,
            });
        },
    });
}