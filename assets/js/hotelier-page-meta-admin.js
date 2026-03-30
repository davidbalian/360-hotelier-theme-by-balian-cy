(function ($) {
	'use strict';

	$(function () {
		$(document).on('click', '.hotelier-pick-image', function (e) {
			e.preventDefault();
			var $wrap = $(this).closest('.hotelier-image-field');
			var $input = $wrap.find('.hotelier-image-id');
			var $preview = $wrap.find('.hotelier-image-preview');

			var frame = wp.media({
				title: 'Select image',
				button: { text: 'Use this image' },
				multiple: false,
			});

			frame.on('select', function () {
				var att = frame.state().get('selection').first().toJSON();
				$input.val(att.id || '');
				if (att.sizes && att.sizes.thumbnail && att.sizes.thumbnail.url) {
					$preview.html('<img src="' + att.sizes.thumbnail.url + '" alt="" style="max-height:80px;width:auto;">');
				} else if (att.url) {
					$preview.html('<img src="' + att.url + '" alt="" style="max-height:80px;width:auto;">');
				} else {
					$preview.empty();
				}
			});

			frame.open();
		});

		$(document).on('click', '.hotelier-clear-image', function (e) {
			e.preventDefault();
			var $wrap = $(this).closest('.hotelier-image-field');
			$wrap.find('.hotelier-image-id').val('');
			$wrap.find('.hotelier-image-preview').empty();
		});
	});
})(jQuery);
