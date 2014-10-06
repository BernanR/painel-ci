$(function(){
	$('.data-table').dataTable({
		"oLanguage":{
			"sSearch":"Pesquisar:",
			"sInfo":"Mostrando _START_ a _END_ de _TOTAL_ registros"
		},
		"sScrollY":"400px",
		"sScrollX":"100%",
		"sScrollXInner":"100%",
		"bPaginate":false,
		"aaSorting":[[0,"asc"]]
	});
	$(".dataTables_filter").addClass('row');
	$(".dataTables_filter label").first().focus().addClass("large-4 columns");
});