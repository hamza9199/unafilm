(function($, window, document) {
	'use strict';
	$(document).ready(function() {
		$('.woocommerce-view-mode a').click(function(e) {
			var $this;
			e.stopPropagation();
			e.preventDefault();
			$this = $(this);
			$this.siblings('a').removeClass('active');
			$this.addClass('active');
			$('.product').animate({
				opacity: 0
			}, 500, function() {
				if ($this.hasClass('amy-list-view-button')) {
					$(this).addClass('list-view');
					$('.woocommerce-toolbar').addClass('border-bottom');
				} else {
					$(this).removeClass('list-view');
					$('.woocommerce-toolbar').removeClass('border-bottom');
				}
				$(this).animate({
					opacity: 1
				}, 500);
			});
		});
		$('body').on('click', '.add_to_wishlist, .product a.compare:not(.added), .yith-wcqv-button', function(e) {
			e.preventDefault();
			$(this).addClass('loading');
		});
		$(document).on('added_to_wishlist yith_woocompare_open_popup qv_loader_stop', function(e) {
			$('.add_to_wishlist, .product a.compare, .yith-wcqv-button').removeClass('loading');
		});
		$('.quantity input[type="number"]').amyuiNumberInput();
	});
})(jQuery, window, document);