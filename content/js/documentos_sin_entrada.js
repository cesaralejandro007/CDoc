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

    /*----------------------CRUD DEL MODULO------------------------*/
    document.getElementById("enviar").onclick = function () {
        a = valida_registrar();
        if (a != "") {
        }else{
            var datos = new FormData();
            datos.append("accion", $("#accion").val());
            datos.append("id_documento", $("#id_documento").val());
            datos.append("tipoDocumento", obtenerIdTipo());
            datos.append("numeroDocumento", $("#inputNumeroDocumento").val());
            datos.append("descripcion", $("#inputDescripcion").val());
            enviaAjax(datos);
        }
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
    document.getElementById("snumeroDocumento").innerText = "";
    document.getElementById("sdescripcion").innerText = "";
    document.getElementById("stipo").innerText = "";
    document.getElementById("inputNumeroDocumento").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputDescripcion").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputTipo").classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
    var error = false;
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

    if (
        numeroDocumento === 0 ||
        descripcion === 0 ||
        $("#inputTipo").val() === "" ||
        obtenerIdTipo() == ""
    ){
        error = true;
    }
    return error;
}

/*--------------------FIN DE FUNCIONES DE HERRAMIENTAS-------------------*/

function eliminar(id_documento,numeroDocumento) {
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
                datos.append("id_documento", id_documento);
                datos.append("numeroDocumento", numeroDocumento);
                enviaAjax(datos);
            }, 10);
        }
    });
}

function cargar_datos(id_documento) {
    $("#inputTipoDocumento").val("2");
    $("#inputTipoDocumento").attr('disabled', 'disabled');

    var datos = new FormData();
    datos.append("accion", "editar");
    datos.append("id_documento", id_documento);
    mostrar(datos);
}

function migrarDoc(id,numeroDocumento) {
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
            const nombre_remitentes = JSON.parse(response);

            // Crear datalist dinámicamente con data-id
            let datalist = '<datalist id="lista_nombre_remitente">';
            nombre_remitentes.forEach((remitente) => {
                datalist += `<option value="${remitente.nombre_rem}" data-id="${remitente.id_remitente}"></option>`;
            });
            datalist += '</datalist>';

            // Crear el input con el datalist
            Swal.fire({
                title: 'Selecciona un nombre de remitente',
                html: `
                    <input type="date" id="fecha" class="swal2-input" placeholder="Seleccione la fecha">
                    <input list="lista_nombre_remitente" id="nombre_remitente" class="swal2-input" placeholder="Seleccione nombre de remitente">
                    ${datalist}
                `,
                confirmButtonText: 'Migrar Documento',
                focusConfirm: false,
                preConfirm: () => {
                    const fecha = Swal.getPopup().querySelector('#fecha').value;
                    const remitente = Swal.getPopup().querySelector('#nombre_remitente').value;
                    const dataList = document.getElementById('lista_nombre_remitente');
                    let id_remitente = '';

                    // Obtener el id_remitente correspondiente al nombre seleccionado
                    for (let i = 0; i < dataList.options.length; i++) {
                        if (dataList.options[i].value.trim() === remitente.trim()) {
                            id_remitente = dataList.options[i].getAttribute('data-id');
                            break;
                        }
                    }

                    if (!fecha || !remitente || !id_remitente) {
                        Swal.showValidationMessage('Por favor, selecciona una fecha y un nombre de remitente válido');
                        return false;
                    }

                    return { fecha, id_remitente };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var datos_migrar = new FormData();
                    datos_migrar.append("accion", "migrar_documento_entrada");
                    datos_migrar.append("fecha_entrada", result.value.fecha);
                    datos_migrar.append("id_documento", id);
                    datos_migrar.append("id_remitente", result.value.id_remitente);
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
                            Swal.fire({
                                title: res.title,
                                text: res.message,
                                icon: res.icon,
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                            }).then(() => {
                                if (res.estatus == "1") {
                                    setTimeout(() => {
                                        window.location.href = `?pagina=${res.url}`;
                                    }, 2000);
                                }
                            });
                        },
                        error: () => {
                            Swal.fire({
                                icon: 'error',
                                text: 'Hubo un error en la solicitud.',
                            });
                        }
                    });
                }
            });
        },
        error: () => {
            Swal.fire({
                icon: 'error',
                text: 'Hubo un error en la solicitud.',
            });
        }
    });
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
            $("#inputTipo").val(res.nombre_doc);
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