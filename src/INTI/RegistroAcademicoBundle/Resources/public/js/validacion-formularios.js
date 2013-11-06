$.validator.addMethod("dui", function (value) {
	return /^\d{8}-\d$/.test(value);
}, 'El DUI debe contener solo números e incluir el guion medio');

$.validator.addMethod("isss", function (value) {
	return /^\d{9}$/.test(value);
}, 'El ISSS debe contener 9 números');

$.validator.addMethod("nit", function (value) {
	return /^\d{4}-\d{6}-\d{3}-\d$/.test(value);
}, 'El NIT debe contener solo números en incluir los guiones medios');

$.validator.addMethod("nup", function (value) {
	return /^\d{12}$/.test(value);
}, 'El NUP debe contener solo 12 números');

$.validator.addMethod("password", function (value) {
	return /(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d){8,60}.+$)/.test(value);
}, function (params, element) {
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

$.validator.addMethod("fecha", function(value) {
	return !/\d{2}\/\d{2}\/\d{4}/g.test(value);
}, "Por favor digita la fecha siguiendo el formato dd/mm/yyyy.");

$.validator.addMethod("fechanac", function(value) {
	return Date.parseExact(value, "d/M/yyyy");
}, "Por favor digita la fecha siguiendo el formato dd/mm/yyyy.");

$.validator.addMethod("codigo", function(value){
	return /^[a-zA-Z]*$/.test(value);
}, 'El codigo solo debe contener letras');

$.validator.addMethod("nombre", function(value){
	return /^[A-Za-z]+(\s[A-Za-z]+)*$/.test(value);
}, 'El nombre solo debe contener letras');

$.validator.addMethod("confirm_password", function(value) {
	return $('#form_new_password').val() == $('#form_confirm_password').val();
}, 'Debe confirmar la nueva contraseña');

$(document).ready(function() {
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
				maxlength: 40
			},
			"aspirantetype[telefono]": {
				minlength: 8,
				maxlength: 8
			},
			"aspirantetype[fechanac]": {
				fecha: true
			},
			"aspirantetype[lugarnac]": {
				maxlength: 40
			},
			"aspirantetype[encargado][nombre]": {
				minlength: 3,
				maxlength: 80
			},
			"aspirantetype[encargado][dui]": {
				dui: true
			},
			"aspirantetype[encargado][telefono]": {
				minlength: 8,
				maxlength: 8
			},
			"empleadotype[dui]": {
				dui: true
			},
			"empleadotype[nombres]": {
				minlength: 3,
				maxlength: 80
			},
			"empleadotype[apellidos]": {
				minlength: 3,
				maxlength: 80
			},
			"empleadotype[isss]": {
				isss: true
			},
			"empleadotype[nit]": {
				nit: true
			},
			"empleadotype[nup]": {
				nup: true
			}, "empleadotype[usuario][username]": {
				minlength: 6,
				maxlength: 50
			},
			"empleadotype[usuario][password]": {
				password: true,
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
				password: true,
				minlength: 8,
				maxlength: 60
			},
			"usuariotype[enabled]": {
				required: false
			},
			"especialidadtype[codigo]":{
				codigo: true,
				minlength: 2,
				maxlength: 5
			},
			"especialidadtype[nombre]":{
				nombre: true
			},
			"form[old_password]":{
				password: true,
				minlength: 8,
				maxlength: 60
			},
			"form[new_password]":{
				password: true,
				minlength: 8,
				maxlength: 60
			},
			"form[confirm_password]":{
				password: true,
				confirm_password: true,
				minlength: 8,
				maxlength: 60
			},
		},
		showErrors: function(errorMap, errorList) {
			$.each(this.successList, function(index, value) {
				return $(value).popover("hide");
			});
			return $.each(errorList, function(index, value) {
				var _popover;
				_popover = $(value.element).popover({
					trigger: "manual",
					placement: "right",
					content: value.message,
					template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"></div></div></div>"
				});
				_popover.data("popover").options.content = value.message;
				return $(value.element).popover("show");
			});
		}
	});
	$("#empleadotype_usuario_username").focus(function() {
		var username = $(this);
		if (username.val().length <= 0) {
			var nombres = $("#empleadotype_nombres").val().split(" ");
			var apellidos = $("#empleadotype_apellidos").val().split(" ");
			if (nombres.length > 1)
				username.val(username.val().concat(nombres[0].split("")[0] + nombres[1].split("")[0] + apellidos[0]).toLowerCase());
			else
				username.val(username.val().concat(nombres[0].split("")[0] + nombres[0].split("")[0] + apellidos[0]).toLowerCase());        }
	});
});
