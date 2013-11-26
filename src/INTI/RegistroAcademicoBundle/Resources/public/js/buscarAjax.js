function buscarAspirantes() {
	apellido = $('#buscarAspirantes input[type="search"]').val();
	if(apellido.length > 0) {
		$('#tablaAspirantes').empty();
		$.get(
			Routing.generate('aspirante_index'),
			{ 'apellido': apellido },
			function(r) {
				$('#tablaAspirantes').html(r);
			}
		);
	}
}

function buscarAlumnos () {
	apellidos = $('#buscarAlumnos input[type="search"]').val();
	console.log(apellidos);
	codigo = $('#buscarAlumnos #codigo').val();
	console.log(codigo);
	if(apellidos.length > 0) {
		$('#tablaAlumnos').empty();
		$.get(
			Routing.generate('alumno_index'),
			{ 'apellidos': apellidos, 'codigo': codigo },
			function (data) {
				$('#tablaAlumnos').html(data);
			}
		);
	}
}

$(document).ready(function() {
	$('#buscarAspirantes button').click(buscarAspirantes);

	$('#buscarAlumnos button').click(buscarAlumnos);

	$('#logo').ajaxStart(function() {
		$(this).addClass("barrel-roll");
	}).ajaxStop(function() {
		$(this).removeClass("barrel-roll");
	});
});