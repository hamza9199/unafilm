

var $ = jQuery;

$(document).ready(function() {
	'use strict';

	function amy_movie_date_picker() {
		$('.amy-datepicker').each(function () {
			var $this = $(this),
				$input = $this.find('input[type="text"]');

			$input.datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
        		changeYear: true,
			});
		});
	}

	amy_movie_date_picker();

	$('.amy-tagsinput').tagsInput({
		'width':		'auto',
		'height': 		'40px',
		'defaultText': 'Add new hour'
	});

	$('.amy-add-group').bind('click').on('click', function (e) {
		amy_movie_date_picker();

		$('.amy-tagsinput').tagsInput({
			'width':		'auto',
			'height': 		'40px',
			'defaultText':  'Add new hour'
		});
	});
});