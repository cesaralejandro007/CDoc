var keyup_cedula = /^[0-9]{7,8}$/;
var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú]{2,29}(\s[A-ZÁÉÍÓÚ][a-zñáéíóú]{2,29})?$/;
var keyup_inputPassword =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;;

function obtenerIdSeccion() {
    let input = $("#seccion").val();
    let options = document.getElementById('tipoSeccion').options;
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
/*--------------VALIDACION PARA CEDULA--------------------*/
    document.getElementById("inputCedula").maxLength = 8;
    document.getElementById("inputCedula").onkeypress = function (e) {
        er = /^[0-9]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("inputCedula").onkeyup = function () {
        r = validarkeyup(
            keyup_cedula,
            this,
            document.getElementById("sinputCedula"),
            "* El formato debe ser 99999999"
        );
    };
/*--------------FIN VALIDACION PARA CEDULA--------------------*/
/*--------------VALIDACION PARA NOMBRE--------------------*/
    document.getElementById("inputNombres").maxLength = 30;
    document.getElementById("inputNombres").onkeypress = function (e) {
        er = /^[A-Za-z\s\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("inputNombres").onkeyup = function () {
        r = validarkeyup(
            keyup_nombre,
            this,
            document.getElementById("sinputNombres"),
            "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
        );
    };
/*--------------FIN VALIDACION PARA NOMBRE--------------------*/
/*--------------VALIDACION PARA APELLIDO--------------------*/
    document.getElementById("inputApellidos").maxLength = 30;
    document.getElementById("inputApellidos").onkeypress = function (e) {
        er = /^[A-Za-z\s\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("inputApellidos").onkeyup = function () {
        r = validarkeyup(
            keyup_nombre,
            this,
            document.getElementById("sinputApellidos"),
            "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
        );
    };
/*--------------FIN VALIDACION PARA APELLIDO--------------------*/
/*--------------VALIDACION PARA inputSexo--------------------*/
    document.getElementById("inputSexo").maxLength = 9;
    document.getElementById("inputSexo").onkeypress = function (e) {
        er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("inputSexo").onchange = function () {
        r = validarselect(
            this,
            document.getElementById("sinputSexo"),
            "* Seleccione un Sexo"
        );
    };
/*--------------FIN VALIDACION PARA inputSexo--------------------*/
/*--------------VALIDACION PARA inputPassword--------------------*/
document.getElementById("inputPassword").maxLength = 30;
document.getElementById("inputPassword").onkeypress = function (e) {
    er = /^[A-Za-z\d@$.!%*?&\s\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
};
document.getElementById("inputPassword").onkeyup = function () {
    r = validarkeyup(
        keyup_inputPassword,
        this,
        document.getElementById("sinputPassword"),
        "La clave debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un dígito y un carácter especial."
    );
};
/*--------------FIN VALIDACION PARA APELLIDO--------------------*/

document.getElementById("enviar").onclick = function () {
    a = valida_registrar();
    if (a != "") {

    }else if($("#inputPassword").val() != $("#inputPassword2").val()){
        document.getElementById("sinputPassword").innerText = "¡Las claves no coinciden!";
        document.getElementById("inputPassword").classList.add("is-invalid");
        document.getElementById("inputPassword2").classList.add("is-invalid");
    }else {
        document.getElementById("sinputPassword").innerText = "";
        document.getElementById("inputPassword").classList.remove("is-invalid");
        document.getElementById("inputPassword2").classList.remove("is-invalid");
        document.getElementById("inputPassword").classList.add("is-valid");
        document.getElementById("inputPassword2").classList.add("is-valid");
        var datos = new FormData();
        datos.append("accion", $("#accion").val());
        datos.append("id", $("#id_usuario").val());
        datos.append("cedula", $("#inputCedula").val());
        datos.append("inputNombres", $("#inputNombres").val());
        datos.append("inputApellidos", $("#inputApellidos").val());
        datos.append("rol", $("#rol").val());
        datos.append("inputSexo", $("#inputSexo").val());
        datos.append("inputPassword", $("#inputPassword").val());
        datos.append("seccion", obtenerIdSeccion());
        enviaAjax(datos);
    }
};

document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#accion").val("registrar_usuario");
    $("#exampleModalCenterTitle").text("Registrar Usuario");
    $("#enviar").text("Registrar");
    $("#modalshowhide").modal("show");
};
}
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
    if(etiqueta.value == 0){
        etiquetamensaje.innerText = mensaje;
        etiquetamensaje.style.color = "red";
        etiqueta.classList.add("is-invalid");
    }else{
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

function limpiar() {
    $("#inputCedula").val("");
    $("#inputNombres").val("");
    $("#inputApellidos").val("");
    $("#inputSexo").val(0);
    $("#inputPassword").val("");
    document.getElementById("sinputCedula").innerText = "";
    document.getElementById("sinputNombres").innerText = "";
    document.getElementById("sinputApellidos").innerText = "";
    document.getElementById("sinputSexo").innerText = "";
    document.getElementById("sinputPassword").innerText = "";
   /*  document.getElementById("sarea").innerText = ""; */

    document.getElementById("inputCedula").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputNombres").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputApellidos").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputSexo").classList.remove("is-invalid", "is-valid");
    document.getElementById("inputPassword").classList.remove("is-invalid", "is-valid");
    /* document.getElementById("area").classList.remove("is-invalid", "is-valid"); */
}

function valida_registrar() {
    var error = false;
    inputCedula = validarkeyup(
        keyup_cedula,
        document.getElementById("inputCedula"),
        document.getElementById("sinputCedula"),
        "* El formato debe ser 99999999."
    );
    inputNombres = validarkeyup(
        keyup_nombre,
        document.getElementById("inputNombres"),
        document.getElementById("sinputNombres"),
        "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
    inputApellidos = validarkeyup(
        keyup_nombre,
        document.getElementById("inputApellidos"),
        document.getElementById("sinputApellidos"),
        "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
    if(document.getElementById("inputSexo").value == 0){
        document.getElementById("sinputSexo").innerHTML ="* Seleccione un genero";
        document.getElementById("sinputSexo").style.color = "red";
        document.getElementById("inputSexo").classList.add("is-invalid");
    }else{
        document.getElementById("sinputSexo").innerHTML ="";
        document.getElementById("inputSexo").classList.remove("is-invalid");
        document.getElementById("inputSexo").classList.add("is-valid");
    }
    inputPassword = validarkeyup(
        keyup_inputPassword,
        document.getElementById("inputPassword"),
        document.getElementById("sinputPassword"),
        "La clave debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un dígito y un carácter especial."
    );
    if(obtenerIdSeccion() == ""){
        document.getElementById("sseccion").innerHTML ="* Seleccione una sección";
        document.getElementById("sseccion").style.color = "red";
        document.getElementById("seccion").classList.add("is-invalid");
    }else{
        document.getElementById("sseccion").innerHTML ="";
        document.getElementById("seccion").classList.remove("is-invalid");
        document.getElementById("seccion").classList.add("is-valid");
    }

    if(
        inputCedula == 0 ||
        inputNombres == 0 ||
        inputApellidos == 0 ||
        document.getElementById("inputSexo").value == 0 ||
        inputPassword == 0 ||    
        obtenerIdSeccion() == ""
    ){
        error = true;
    }
    return error;
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
                datos.append("id_usuario", id);
                enviaAjax(datos);
            }, 10);
        }
    });
}

function cargar_datos(id_persona) {
    var datos = new FormData();
    datos.append("accion", "editar");
    datos.append("id_persona", id_persona);
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
            $("#id_usuario").val(res.id_persona);
            $("#inputCedula").val(res.cedula);
            $("#inputNombres").val(res.nombres);
            $("#inputApellidos").val(res.apellidos);
            $("#rol").val(res.rol);
            $("#inputSexo").val(res.sexo);
            $("#seccion").val(res.id_seccion);
            $("#enviar").text("Modificar");
            $("#modalshowhide").modal("show");
            $("#accion").val("modificar");
            $("#exampleModalCenterTitle").text("Modificar Usuario");
        },
        error: (err) => {
            Toast.fire({
                icon: error.icon,
            });
        },
    });
}
