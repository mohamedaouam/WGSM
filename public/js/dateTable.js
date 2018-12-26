function table(col,tag){
	$(tag).dataTable({
		
		columns : col,
		dom : 'Bfrtip',
		buttons : [ {
			extend : 'copy',
			text : "Copier",
			className: "data-btn copy"
		}, {
			extend : 'excel',
			text : "Telecharger en excel",
			className: "data-btn exls"
		}, {
			extend : 'pdf',
			text : "telecharger en pdf",
			className: "data-btn pdf"
		} ]

	});
	$('.data-btn').removeClass('btn-secondary').addClass('btn-primary')
}