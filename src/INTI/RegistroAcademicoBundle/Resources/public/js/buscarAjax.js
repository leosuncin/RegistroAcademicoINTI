function buscarAspirantes() {
	var apellido = $('#buscarAspirantes input[type="search"]').val();
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

$(document).ready(function() {
	$('#buscarAspirantes input[type="search"]').keyup(buscarAspirantes);
	$('#buscarAspirantes button').click(buscarAspirantes);
	$('#logo').ajaxStart(function() {
		$(this).addClass("barrel-roll");
	}).ajaxStop(function() {
		$(this).removeClass("barrel-roll");
	});
});