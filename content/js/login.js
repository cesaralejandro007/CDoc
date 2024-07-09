var keyup_cedula = /^[0-9]{7,8}$/;
var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú]{2,29}(\s[A-ZÁÉÍÓÚ][a-zñáéíóú]{2,29})?$/;
var keyup_clave =  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;;

document.onload = carga();
function carga() {
/*--------------VALIDACION PARA CEDULA--------------------*/
    document.getElementById("user").maxLength = 8;
    document.getElementById("user").onkeypress = function (e) {
        er = /^[0-9]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("user").onkeyup = function () {
        r = validarkeyup(
            keyup_cedula,
            this,
            document.getElementById("suser"),
            "* El formato debe ser 99999999"
        );
    };
/*--------------FIN VALIDACION PARA CEDULA--------------------*/
/*--------------VALIDACION PARA NOMBRE--------------------*/
    document.getElementById("nombres").maxLength = 30;
    document.getElementById("nombres").onkeypress = function (e) {
        er = /^[A-Za-z\s\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("nombres").onkeyup = function () {
        r = validarkeyup(
            keyup_nombre,
            this,
            document.getElementById("snombres"),
            "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
        );
    };
/*--------------FIN VALIDACION PARA NOMBRE--------------------*/
/*--------------VALIDACION PARA APELLIDO--------------------*/
    document.getElementById("apellidos").maxLength = 30;
    document.getElementById("apellidos").onkeypress = function (e) {
        er = /^[A-Za-z\s\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
    };
    document.getElementById("apellidos").onkeyup = function () {
        r = validarkeyup(
            keyup_nombre,
            this,
            document.getElementById("sapellidos"),
            "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
        );
    };
/*--------------FIN VALIDACION PARA APELLIDO--------------------*/
/*--------------VALIDACION PARA ROL--------------------*/
    document.getElementById("rol").maxLength = 9;
    document.getElementById("rol").onkeypress = function (e) {
      er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
      validarkeypress(er, e);
    };
    document.getElementById("rol").onchange = function () {
        r = validarselect(
            this,
            document.getElementById("srol"),
            "* Seleccione un Rol"
        );
    };
/*--------------FIN VALIDACION PARA ROL--------------------*/
/*--------------VALIDACION PARA CLAVE--------------------*/
document.getElementById("clave").maxLength = 30;
document.getElementById("clave").onkeypress = function (e) {
    er = /^[A-Za-z\d@$.!%*?&\s\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
};
document.getElementById("clave").onkeyup = function () {
    r = validarkeyup(
        keyup_clave,
        this,
        document.getElementById("sclave"),
        "La clave debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un dígito y un carácter especial."
    );
};
/*--------------FIN VALIDACION PARA APELLIDO--------------------*/

/*----------------------CRUD DEL MODULO------------------------*/
document.getElementById("enviar").onclick = function () {
    a = valida_registrar();
    if (a != "") {
    }if($("#clave").val() != $("#clave2").val()){
        document.getElementById("sclave").innerText = "¡Las claves no coinciden!";
    }else {
        document.getElementById("sclave").innerText = "";
        var datos = new FormData();
        datos.append("accion", 'registrar_usuario');
        datos.append("id", $("#id_usuario").val());
        datos.append("cedula", $("#user").val());
        datos.append("nombres", $("#nombres").val());
        datos.append("apellidos", $("#apellidos").val());
        datos.append("rol", $("#rol").val());
        datos.append("clave", $("#clave").val());
        enviaAjax(datos);
    }
};
document.addEventListener('keydown', function(event) {
if (event.ctrlKey && event.shiftKey && event.key === 'y') {
    $("#exampleModal").modal("show");
}
});

$("#ingresar").click(function (e) {
    var datos = new FormData();
    datos.append("accion", "ingresar");
    datos.append("usuario", $("#inputUsuario").val());
    datos.append("password", $("#inputPassword").val());
    iniciar_sesion_login(datos);
});
  
  
$("#inputPassword").on("keydown", function (e) {
if (e.which === 13 || e.keyCode === 13) {
    // La tecla presionada es "Enter", ejecutar la función iniciar_sesion_login
    var datos = new FormData();
    datos.append("accion", "ingresar");
    datos.append("usuario", $("#inputUsuario").val());
    datos.append("password", $("#inputPassword").val());
    iniciar_sesion_login(datos);
}
});

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
    $("#user").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#rol").val(0);
    $("#clave").val("");
    $("#clave2").val("");
    document.getElementById("suser").innerText = "";
    document.getElementById("snombres").innerText = "";
    document.getElementById("sapellidos").innerText = "";
    document.getElementById("srol").innerText = "";
    document.getElementById("sclave").innerText = "";
    document.getElementById("sclave2").innerText = "";
   /*  document.getElementById("sarea").innerText = ""; */

    document.getElementById("user").classList.remove("is-invalid", "is-valid");
    document.getElementById("nombres").classList.remove("is-invalid", "is-valid");
    document.getElementById("apellidos").classList.remove("is-invalid", "is-valid");
    document.getElementById("rol").classList.remove("is-invalid", "is-valid");
    document.getElementById("clave").classList.remove("is-invalid", "is-valid");
    document.getElementById("clave2").classList.remove("is-invalid", "is-valid");
    /* document.getElementById("area").classList.remove("is-invalid", "is-valid"); */
}

function valida_registrar() {
    var error = false;
    user = validarkeyup(
        keyup_cedula,
        document.getElementById("user"),
        document.getElementById("suser"),
        "* El formato debe ser 99999999."
    );
    nombres = validarkeyup(
        keyup_nombre,
        document.getElementById("nombres"),
        document.getElementById("snombres"),
        "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
    apellidos = validarkeyup(
        keyup_nombre,
        document.getElementById("apellidos"),
        document.getElementById("sapellidos"),
        "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
    if(document.getElementById("rol").value == 0){
        document.getElementById("srol").innerHTML ="* Seleccione un genero";
        document.getElementById("srol").style.color = "red";
        document.getElementById("rol").classList.add("is-invalid");
    }else{
        document.getElementById("srol").innerHTML ="";
        document.getElementById("rol").classList.remove("is-invalid");
        document.getElementById("rol").classList.add("is-valid");
    }
    clave = validarkeyup(
        keyup_clave,
        document.getElementById("clave"),
        document.getElementById("sclave"),
        "* El formato debe ser 0426-1234567"
    );

    if(
        user == 0 ||
        nombres == 0 ||
        apellidos == 0 ||
        document.getElementById("rol").value == 0 ||
        clave == 0 
    ){
        error = true;
    }
    return error;
}

/*-------------------FIN DE FUNCIONES DE HERRAMIENTAS-------------------*/

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


function iniciar_sesion_login(datos) {
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
        if (res.estatus == 1) {
            var formData = new FormData();
            formData.append("accion", "codificarURL");
            $.ajax({
                url: "",
                type: "POST",
                contentType: false,
                data: formData,
                processData: false,
                cache: false,
                success: function (response) {
                    toastMixin.fire({
                        title: res.title,
                        text: res.message,
                        icon: res.icon
                    });
                    limpiar();
                    setTimeout(function () {
                        window.location.replace("?pagina="+response);
                    }, 2000);
                }
            });
        }else{
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

