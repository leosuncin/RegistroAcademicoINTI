$.validator.addMethod("dui", function(value) {
    regex = /^\d{8}-\d$/g;
    return regex.test(value);
}, 'El DUI debe contener solo números e incluir el guion medio');

$.validator.addMethod("isss", function(value) {
    return /^\d{9}$/g.test(value);
}, 'El ISSS debe contener 9 números');

$.validator.addMethod("nit", function(value) {
    return /^\d{4}-\d{6}-\d{3}-\d$/.test(value);
}, 'El NIT debe contener solo números en incluir los guiones medios');

$.validator.addMethod("nup", function(value) {
    return /^\d{12}$/.test(value);
}, 'El NUP debe contener solo 12 números');

$.validator.addMethod("telefono", function(value) {
    return /^d{8}$/.test(value);
}, 'El telefono debe contener solo 8 números');

$.validator.addMethod("password", function(value) {
    return /(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d){8,60}.+$)/.test(value);;
}, function(params, element) {
    var passwd = element.value;
    var mensaje = "La contraseña por lo menos debe tener";
    if (!/(?=.*[a-z])/g.test(passwd))
        mensaje += " una letra en minúscula, ";
    if (!/(?=.*[A-Z])/g.test(passwd))
        mensaje += " una letra en mayúscula, ";
    if (!/(?=.*\d)/g.test(passwd))
        mensaje += " un numero";
    return mensaje;
});

$(document).ready(function () {
    $("form").validate({
        rules: {
            "aspirantetype[primerapellido]": {
                minlength: 3,
                maxlength: 15
            },
            "aspirantetype[segundoapellido]": {
                minlength: 3,
                maxlength: 15
            },
            "aspirantetype[nombres]": {
                minlength: 3,
                maxlength: 50
            },
            "aspirantetype[direccion]": {
                maxlength: 100
            },
            "aspirantetype[telefono]": "telefono",
            "aspirantetype[fechanac]": {
                date: true
            },
            "aspirantetype[lugarnac]": {
                maxlength: 100
            },
            "aspirantetype[encargado][nombre]": {
                minlength: 3,
                maxlength: 80
            },
            "aspirantetype[encargado][dui]": "dui",
            "aspirantetype[encargado][telefono]": "telefono",
            "empleadotype[dui]": "dui",
            "empleadotype[nombres]": {
                minlength: 3,
                maxlength: 80
            },
            "empleadotype[apellidos]": {
                minlength: 3,
                maxlength: 80
            },
            "empleadotype[isss]": "isss",
            "empleadotype[nit]": "nit",
            "empleadotype[nup]": "nup",
            "empleadotype[usuario][username]": {
                minlength: 6,
                maxlength: 50
            },
            "empleadotype[usuario][password]": {
                minlength: 8,
                maxlength: 60
            },
            "empleadotype[usuario][enabled]": {
                required: false
            },
            "usuariotype[username]": {
                minlength: 6,
                maxlength: 50
            },
            "usuariotype[password]": {
                minlength: 8,
                maxlength: 60
            },
            "usuariotype[enabled]": {
                required: false
            }
        },
        showErrors: function (errorMap, errorList) {
            $.each(this.successList, function (index, value) {
                return $(value).popover("hide");
            });
            return $.each(errorList, function (index, value) {
                var _popover;
                _popover = $(value.element).popover({
                    trigger: "manual",
                    placement: "right",
                    content: value.message,
                    template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p class=\"error\"></p></div></div></div>"
                });
                _popover.data("popover").options.content = value.message;
                return $(value.element).popover("show")
            });
        }
    });
    $("#empleadotype_usuario_username").focus(function (){
        var username = $(this);
        if(username.val().length <= 0){
            var nombres = $("#empleadotype_nombres").val().split(" ");
            var apellidos = $("#empleadotype_apellidos").val().split(" ");
            if(nombres.length > 1)
                username.val(username.val().concat(nombres[0].split("")[0] + nombres[1].split("")[0] + apellidos[0]).toLowerCase());
            else
                username.val(username.val().concat(nombres[0].split("")[0] + nombres[0].split("")[0] + apellidos[0]).toLowerCase())
        }
    });
});