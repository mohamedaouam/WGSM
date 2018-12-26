clients = [ {
	"id" : 1,
	"nom" : "AOUAM Mohamed",
	"tel" : "0771831408"
}, {
	"id" : 2,
	"nom" : "AOUAM Yanis",
	"tel" : "0771831409"
}, {
	"id" : 9,
	"nom" : "AOUAM Ghiles",
	"tel" : "0771831495"
}, {
	"id" : 10,
	"nom" : "AOUAM Massi",
	"tel" : "0771831407"
} ];

$('#clientsTable').dataTable({
	
	columns : [ {
		data : 'id'
	}, {
		data : 'nom'
	}, {
		data : 'tel'
	} ],
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
