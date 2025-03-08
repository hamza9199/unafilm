(function ($, window, document) {
    "use strict";

    var AMYIMDB = window.AMYIMDB || {};

	// ======================================================
	// IMDB IMPORTER
	// ------------------------------------------------------
	AMYIMDB.IMDB_IMPORTER	= function() {
		var base	= this;

		var progress_bar	= {
			progress_bar_wrapper_element:	'',
			progress_bar_element:			'',
			current_value:					0,
			goto_value:						0,
			timer:							'',
			last_goto_value: 				0,

			show: function show() {
				progress_bar.progress_bar_wrapper_element.addClass('amy-imdb-progress-bar-visible');
			},

			hide: function hide() {
				progress_bar.progress_bar_wrapper_element.removeClass('amy-imdb-progress-bar-visible');
			},

			reset: function reset() {
				clearInterval(progress_bar.timer);

				progress_bar.current_value		= 0;
				progress_bar.goto_value			= 0;
				progress_bar.timer				= '';
				progress_bar.last_goto_value	= 0;

				progress_bar.change(0);
			},


			change: function change(new_progress) {
				progress_bar.progress_bar_element.css('width', new_progress + '%');

				progress_bar.last_goto_value	= new_progress;

				if (new_progress === 100) {
					clearInterval(progress_bar.timer);
				}
			},

			timer_change: function timer_change(new_progress) {
				clearInterval(progress_bar.timer);

				progress_bar._ui_change(progress_bar.last_goto_value);

				progress_bar.current_value	= progress_bar.last_goto_value;

				clearInterval(progress_bar.timer);

				progress_bar.timer	= setInterval(function () {
					if (Math.floor((Math.random() * 5) + 1) === 1) {
						var tmp_value	= Math.floor((Math.random() * 5) + 1) + progress_bar.current_value;

						if (tmp_value <= new_progress) {
							progress_bar._ui_change(progress_bar.current_value);

							progress_bar.current_value	= tmp_value;
						} else {
							progress_bar._ui_change(new_progress);
							clearInterval(progress_bar.timer);
						}
					}
				}, 1000);
				progress_bar.last_goto_value = new_progress;
			},

			_ui_change: function change(new_progress) {
				progress_bar.progress_bar_element.css('width', new_progress + '%');
			}
		};

		base.init	= function() {
			$('.amy-button-install-product').click(function(e) {
				e.preventDefault();

				let keyword		= $('.amy-imdb-url textarea').val().split(/\n/);
				let $this		= $(this);

				if (!$('.amy-imdb-url textarea').val()) {
					alert('Please enter url');
					return;
				}

				let data = {
					'keyword': keyword,
					'amy_imdb_importer_action': 'install'
				};

				if ($this.hasClass('button-disabled')) {
					return;
				}

				base.install(data);
			});

		};

		base.install	= function(data) {
			let $wrapper	= $('.amy-imdb-importer');

			$wrapper.addClass('amy-imdb-installing');
			$wrapper.find('.amy-button-install-product').addClass('button-disabled');

			progress_bar.progress_bar_wrapper_element	= $wrapper.find('.amy-imdb-progress-bar-wrapper');
			progress_bar.progress_bar_element			= $wrapper.find('.amy-imdb-progress-bar');
			progress_bar.show();
			progress_bar.change(10);

			base.install_step(data);
		};

		base.install_finish	= function(data, error) {
			let $wrapper	= $('.amy-imdb-importer');

			$wrapper.removeClass('amy-imdb-installing');

			if (!error) {
				// finish
				progress_bar.change(100);

				setTimeout(function() {
					progress_bar.hide();
					progress_bar.reset();

					$wrapper.removeClass('amy-imdb-installing').addClass('amy-imdb-installed');
					$wrapper.find('.amy-button-install-product').removeClass('button-disabled');
					alert('Import Finish');
				}, 500);
			} else {
				progress_bar.hide();
				progress_bar.reset();
				$wrapper.find('.amy-button-install-product').removeClass('button-disabled');
			}
		};

		base.install_step	= function(data) {
			let $wrapper	= $('.amy-imdb-importer');

			data	= data || {};

			if (!data.action) {
				data.action		= 'amy_imdb_importer_action';
			}

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				dataType:'text',
				data: data,
				success: function(content) {
					if (!content || content == '0') {
						base.install_finish(data, true);
						alert(adiL10n.install_product_error);
					} else if (content == '1') {
						var response	= JSON.parse(content);

						if (response.task_content) {
							$('.amy-task-log').append(response.task_content);
						}

						base.install_finish(data);
					} else {
						var response	= JSON.parse(content);

						progress_bar.change(response.progress);

						data.amy_imdb_importer_action = response.next_action;

						if (response.pni) {
							data.pni	= response.pni;
						}

						if (response.task_content) {
							$('.amy-task-log').append(response.task_content);
						}

						base.install_step(data);
					}
				},
				error: function(el) {
					base.install_finish(data, true);
					alert(adiL10n.install_product_error);
				}
			});
		};

		base.init();
	};

	$(document).ready(function () {
		AMYIMDB.IMDB_IMPORTER();
	});
})(jQuery, window, document);