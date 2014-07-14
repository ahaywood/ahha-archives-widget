jQuery(document).ready(function($) {

	// SETUP ARCHIVES IN FOOTER
	$('.archive_month').hide();
	$('.archive_year > a').toggle(function() {
		var startingPoint = $(this).parent();
		while (startingPoint.next().attr('class') == 'archive_month') {
			startingPoint.next().fadeIn();
			startingPoint = startingPoint.next();
		}
	}, function() {
		var startingPoint = $(this).parent();
		while (startingPoint.next().attr('class') == 'archive_month') {
			startingPoint.next().fadeOut();
			startingPoint = startingPoint.next();
		}
	});

	$('.archive_year:first-child > a').trigger('click');

});