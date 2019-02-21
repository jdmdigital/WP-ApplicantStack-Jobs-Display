// ApplicantStack Jobs JS
var $grid = jQuery('.grid').isotope({
  itemSelector: '.grid-item',
  layoutMode: 'fitRows'
});


// bind filter button click
jQuery('#location-filters, #department-filters').on( 'click', 'button', function() {
  var filterValue = jQuery( this ).attr('data-filter');
  // use filterFn if matches value
  //filterValue = filterFns[ filterValue ] || filterValue;
  $grid.isotope({ filter: filterValue });
});

// change is-checked class on buttons
jQuery('#location-filters.button-group').each( function( i, buttonGroup ) {
	var $buttonGroup = jQuery( buttonGroup );
	$buttonGroup.on( 'click', 'button', function() {
		jQuery('#department-filters .button').removeClass('is-checked');
		jQuery('#department-filters .button.default').addClass('is-checked');

		$buttonGroup.find('.is-checked').removeClass('is-checked');
		jQuery( this ).addClass('is-checked');
	});
});

jQuery('#department-filters.button-group').each( function( i, buttonGroup ) {
	var $buttonGroup = jQuery( buttonGroup );
	$buttonGroup.on( 'click', 'button', function() {
		jQuery('#location-filters .button').removeClass('is-checked');
		jQuery('#location-filters .default').addClass('is-checked');
		
		$buttonGroup.find('.is-checked').removeClass('is-checked');
		jQuery( this ).addClass('is-checked');
	});
});