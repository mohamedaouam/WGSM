function whereImI() {

	var uri = document.location.href;
	var splitedUri = uri.split('/');
	var home = $('li#home')[0];
	var factures = $('li#factures')[0];
	var stocks = $('li#stocks')[0];
	var models = $('li#models')[0];
	var clients = $('li#clients')[0];
	for (i = 3; i < splitedUri.length; i++) {
		
		if (splitedUri[i] == "Home") {
			home.setAttribute('class', 'nav-item active');
			$('li#home a').append("<span class='sr-only'>(current)</span>")
			break
		}
		if (splitedUri[i] == "Factures") {
			factures.setAttribute('class', 'nav-item active');
			$('li#factures a').append("<span class='sr-only'>(current)</span>")
			break
		}
		if (splitedUri[i] == "Stocks") {
			stocks.setAttribute('class', 'nav-item active');
			$('li#stocks a').append("<span class='sr-only'>(current)</span>")
			break
		}
		if (splitedUri[i] == "Models") {
			models.setAttribute('class', 'nav-item active');
			$('li#models a').append("<span class='sr-only'>(current)</span>")
			break
		}
		if (splitedUri[i] == "Clients") {
			clients.setAttribute('class', 'nav-item active');
			$('li#clients a').append("<span class='sr-only'>(current)</span>")
			break
		}
	}
}
$('document').ready(function() {
	whereImI();
})
