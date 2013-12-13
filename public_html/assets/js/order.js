$(document).ready(function() {
	$('.datepicker').each(function(index, el) {
		$(el).datetimepicker({
			language: 'pt-BR'
		});

		// set start time if we have one
		var defaultdate = $(el).find('input').data('default-start-date');
		if(typeof(defaultdate) != 'undefined')
		{
			$(el).datetimepicker("setValue", defaultdate);
			//$(el).find('input').val(defaultdate);
			$(el).datetimepicker('update');
		}
	});
});