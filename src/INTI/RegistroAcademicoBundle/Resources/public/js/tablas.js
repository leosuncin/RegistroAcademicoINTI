$(document).ready( function() {
	var waTable = $('#tabla').WATable({
		pageSize: 20,
		filter: true,
		hidePagerOnEmpty: true,
		preFill: true,
		actions: {
            filter: true,
            columnPicker: true,
            custom: [
              $('<a href="#" class="refresh"><i class="icon-refresh"></i>&nbsp;Refresh</a>'),
              $('<a href="#" class="export_all"><i class="icon-share"></i>&nbsp;Export all rows</a>'),
              $('<a href="#" class="export_checked"><i class="icon-share"></i>&nbsp;Export checked rows</a>'),
              $('<a href="#" class="export_filtered"><i class="icon-share"></i>&nbsp;Export filtered rows</a>')
            ]
        }
	}).data('WATable');
});