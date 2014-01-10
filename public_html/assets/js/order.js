$(document).ready(function(){
	// make the autocomplete ajax request use post
	$.ajaxSetup( { type: "post" } );

	$( "#worktype" ).autocomplete({
		source : '/order/suggest',
		minLength : 1
	});
});

// delete confirmation button lock-out
$(document).ready(function(){
	$('a.confirm').on("click", confirmlink);
});

function confirmlink(e){
	if(!confirm('Really delete this work order?'))
		e.preventDefault();

}


// date picker field add-on
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

// functioning of +/- rows for parts & service sections
$(document).ready(function(){
	// assign add buttons
	$('.addrow').each(function(index, el)  {
		$(el).click(function(e) {
			e.preventDefault();

			part  = $(this).parents('.form-group').find('input.name');
			price = $(this).parents('.input-group').find('input.price');
			group = $(this).parents('.form-group');

			if((part.val().length > 0) && (price.val().length > 0))
			{			
				clone = group.clone();
				clone.find('label').remove();
				clone.find('.name').parents('div').addClass('col-xs-offset-0 col-sm-offset-2');
				clone.find('.addrow').removeClass('addrow').addClass('removerow').unbind('click').click(removerow);
				clone.find('.btn-primary').removeClass('btn-primary').addClass('btn-info');
				clone.find('.glyphicon-plus-sign').removeClass('glyphicon-plus-sign').addClass('glyphicon-minus-sign');
				group.after(clone);

				part.val('');
				price.val('');
			}
		});
	});

	$('.removerow').on('click', removerow);
});

function removerow(e) 
{
	e.preventDefault();
	var el = $(e.currentTarget);

	if(confirm('Do you want to delete this?'))
		el.parents('.form-group').remove();
}