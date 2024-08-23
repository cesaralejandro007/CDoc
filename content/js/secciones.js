var keyup_cantidad = /^[0-9]+$/; // Expresión regular para números enteros
cargar_meta();
function cargar_meta(){
    var datos = new FormData();
    datos.append("accion", "cargar_meta");
    mostrar_meta(datos);
}


document.getElementById('actualizar_meta').addEventListener('click', function() {
    var meta = document.getElementById('meta').value;

    // Validar que el campo no esté vacío
    if (meta.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Campo vacío',
            text: 'Por favor, ingresa una meta antes de actualizar.'
        });
        return;
    }

    // Confirmar si es la meta que quiere enviar
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La meta que estás por enviar es: " + meta,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var datos1 = new FormData();
            datos1.append("accion", "actualizar_meta");
            datos1.append("meta", meta);
            $.ajax({
                url: "",
                type: "POST",
                contentType: false,
                data: datos1,
                processData: false,
                cache: false,
                success: (response) => {
                    var res = JSON.parse(response);
                    //alert(res.title);
                    if (res.estatus == 1) {
                        Swal.fire(
                            'Enviada!',
                            'La meta ha sido actualizada correctamente.',
                            'success'
                        );
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                    }
                },
                    error: (err) => {
                    Toast.fire({
                        icon: res.error,
                    });
                },
            });
        

        }
    });
});




document.onload = carga();
function carga() {
    /*--------------VALIDACION PARA NOMBRE--------------------*/
    document.getElementById("cantidad").maxLength = 10; // Puedes ajustar el máximo de caracteres según tus necesidades
    document.getElementById("cantidad").onkeypress = function (e) {
        er = /^[0-9]*$/; // Solo permite números en la entrada
        validarkeypress(er, e);
    };
    document.getElementById("cantidad").onkeyup = function () {
        r = validarkeyup(
            keyup_cantidad,
            this,
            document.getElementById("scantidad"),
            "* Solo se permiten números."
        );
    };

    document.getElementById("enviar").onclick = function () {
        a = valida_registrar();
        if (!a) {
            var datos = new FormData();
            datos.append("accion", $("#accion").val());
            datos.append("id", $("#id_seccion").val());
            datos.append("cantidad", $("#cantidad").val());
            datos.append("seccion", $("#nombre_seccion").val());
            enviaAjax(datos);
        }
    };

    document.getElementById("nuevo").onclick = function () {
        limpiar();
        $("#accion").val("registrar_seccion");
        $("#exampleModalCenterTitle").text("Registrar Secciones");
        $("#enviar").text("Registrar");
        $("#modalshowhide").modal("show");
    };
}

function valida_registrar() {
    var error = false;

    cantidad = validarkeyup(
        keyup_cantidad,
        document.getElementById("cantidad"),
        document.getElementById("scantidad"),
        "* Solo se permiten números."
    );

    if (cantidad == 0) {
        error = true;
    }
    return error;
}

function validarkeypress(er, e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if (!a) {
        e.preventDefault();
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

function limpiar() {
    $("#cantidad").val("");
    document.getElementById("scantidad").innerText = "";

    document.getElementById("cantidad").classList.remove("is-invalid", "is-valid");
}

/*-------------------FIN DE FUNCIONES DE HERRAMIENTAS-------------------*/

function eliminar(id) {
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
                datos.append("id_seccion", id);
                enviaAjax(datos);
            }, 10);
        }
    });
}

function cargar_datos(id_seccion) {
    var datos = new FormData();
    datos.append("accion", "editar");
    datos.append("id_seccion", id_seccion);
    mostrar(datos);
  }

function enviaAjax(datos) {
    var toastMixin = Swal.mixin({
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });
    $.ajax({
        url: "",
        type: "POST",
        contentType: false,
        data: datos,
        processData: false,
        cache: false,
        success: (response) => {
            var res = JSON.parse(response);
            //alert(res.title);
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
                icon: res.error,
            });
        },
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
            }else {
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
            $("#id_seccion").val(res.id_seccion);
            $("#cantidad").val(res.cantidad_documentos);
            $("#enviar").text("Modificar");
            $("#modalshowhide").modal("show");
            $("#accion").val("modificar");
            $("#nombre_seccion").val(res.nombre_seccion);
            $("#exampleModalCenterTitle").text("Modificar Meta de la Sección: "+ res.nombre_seccion);
        },
        error: (err) => {
            Toast.fire({
                icon: error.icon,
            });
        },
    });
}


function mostrar_meta(datos) {
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
            $("#meta").val(res.meta);
        },
        error: (err) => {
            Toast.fire({
                icon: error.icon,
            });
        },
    });
}