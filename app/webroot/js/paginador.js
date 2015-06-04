$(document).ready(function(){
   //código a ejecutar cuando el DOM está listo para recibir instrucciones.
		$("#paginador1").dataTable({
			"bSort": false,
			'bPaginate': true,
			'bFilter': true,  //filtro para buscar en tiempo real
			'iDisplayLength':10,
			'bLengthChange':true,
			'bProcessing': true,
			'bInfo': true,
			"sPaginationType": "full_numbers",
			"oLanguage": {
				"oPaginate": {
					"sPrevious": "Anterior",
					"sNext": "Siguiente",
					"sLast": "\xDAltima",
					"sFirst": "Primera"
					},
					"sLengthMenu": 'Mostrar <select>'+
					'<option value="10">10</option>'+
					'<option value="20">20</option>'+
					'<option value="30">30</option>'+
					'<option value="40">40</option>'+
					'<option value="50">50</option>'+
					'<option value="-1">Todos</option>'+
					'</select> registros',

					"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)",
					"sInfoFiltered": " - filtrados de _MAX_ registros",
					"sInfoEmpty": "No hay resultados de b\xFAsqueda",
					"sZeroRecords": "No hay registros a mostrar",
					"sProcessing": "Espere, por favor...",
					"sSearch": "Filtrar:",
				},
					"sDom": 'Tlfrtip',
					"oTableTools": {
						"sSwfPath": "../js/TableTools/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
							"copy",
							"csv",
							"xls",
							{
								"sExtends": "pdf",
								"sPdfOrientation": "landscape",
								"sPdfMessage": "Resultados de la b\xFAsqueda."
							},
							"print"
						]
					}				
		});
		
		$("#paginador2").dataTable({
			"bSort": false,
			'bPaginate': true,
			'bFilter': true,  //filtro para buscar en tiempo real
			'iDisplayLength':10,
			'bLengthChange':true,
			'bProcessing': true,
			'bInfo': true,
			"sPaginationType": "full_numbers",
			"oLanguage": {
				"oPaginate": {
					"sPrevious": "Anterior",
					"sNext": "Siguiente",
					"sLast": "\xDAltima",
					"sFirst": "Primera"
					},
					"sLengthMenu": 'Mostrar <select>'+
					'<option value="10">10</option>'+
					'<option value="20">20</option>'+
					'<option value="30">30</option>'+
					'<option value="40">40</option>'+
					'<option value="50">50</option>'+
					'<option value="-1">Todos</option>'+
					'</select> registros',

					"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)",
					"sInfoFiltered": " - filtrados de _MAX_ registros",
					"sInfoEmpty": "No hay resultados de b\xFAsqueda",
					"sZeroRecords": "No hay registros a mostrar",
					"sProcessing": "Espere, por favor...",
					"sSearch": "Filtrar:",
				},
					"sDom": 'Tlfrtip',
					"oTableTools": {
						"sSwfPath": "../js/TableTools/media/swf/copy_csv_xls_pdf.swf",
						"aButtons": [
							"copy",
							"csv",
							"xls",
							{
								"sExtends": "pdf",
								"sPdfOrientation": "landscape",
								"sPdfMessage": "Resultados de la b\xFAsqueda."
							},
							"print"
						]
					}				
		});	
		
		$("#paginador3").dataTable({
			"bSort": false,
			'bPaginate': true,
			'bFilter': true,  //filtro para buscar en tiempo real
			'iDisplayLength':10,
			'bLengthChange':true,
			'bProcessing': true,
			'bInfo': true,
			"sPaginationType": "full_numbers",
			"oLanguage": {
				"oPaginate": {
					"sPrevious": "Anterior",
					"sNext": "Siguiente",
					"sLast": "\xDAltima",
					"sFirst": "Primera"
					},
					"sLengthMenu": 'Mostrar <select>'+
					'<option value="10">10</option>'+
					'<option value="20">20</option>'+
					'<option value="30">30</option>'+
					'<option value="40">40</option>'+
					'<option value="50">50</option>'+
					'<option value="-1">Todos</option>'+
					'</select> registros',

					"sInfo": "Mostrando del _START_ a _END_ (Total: _TOTAL_ resultados)",
					"sInfoFiltered": " - filtrados de _MAX_ registros",
					"sInfoEmpty": "No hay resultados de b\xFAsqueda",
					"sZeroRecords": "No hay registros a mostrar",
					"sProcessing": "Espere, por favor...",
					"sSearch": "Filtrar:",
				},
					"sDom": 'Tlfrtip',
					"oTableTools": {
						"sSwfPath": "../js/TableTools/media/swf/copy_csv_xls.swf",
						"aButtons": [
							"print"
						]
					}				
		});			
		
		$(".check-all").click(function(event){
			if($(this).is(":checked")) {
				$(".check-item:checkbox:not(:checked)").attr("checked", "checked");
			}else{
				$(".check-item:checkbox:checked").removeAttr("checked");
			}
		});	
	
});