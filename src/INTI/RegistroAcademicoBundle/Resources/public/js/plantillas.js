var tablaApirantes = twig({
    id: 'tablaApirantes',
    data: '{% if aspirantes|length <= 0 %}<tr><td>No hay aspirantes que concuerden con la búsqueda</td></tr>{% endif %}{% for aspirante in aspirantes %}<tr><td>{{ aspirante.primerapellido~" "~aspirante.segundoapellido~", "~aspirante.nombres }}</td><td>{{ aspirante.especialidad.nombre }}</td><td>{% if aspirante.sexo == "M" %}Masculino{% else %}Femenino{% endif %}</td><td><div class="btn-group btn-group-vertical"><a class="btn btn-info btn-mini" href="'+'path'+'"><i class="icon-eye-open"> Consultar</i></a> <a class="btn btn-info btn-mini" href="'+'path'+'"><i class="icon-edit" Modificar</a></div></td></tr>{% endfor %}'
});
var cmbCodigo = twig({
    id: 'cmbCodigo',
    data: '<option value="">Escoja a un codigo</option>{% for cod in codigos %}<option value="{{ cod.codigo }}">{{ cod.codigo }}</option>{% endfor %}'
});