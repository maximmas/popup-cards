jQuery(function ($) {

	// get data from options
	var modal = $("#cj_modal"),
		delay = parseInt(modal.data('delay')) * 1000,
		to_show = parseInt(modal.data('show')),
		text_win = modal.find('.text_win').text(),
		text_lose = modal.find('.text_lose').text();

	// get blocking cookie
	let is_blocked = getCookie('cj_block');

	if (to_show && !is_blocked) {
		setTimeout(modalInit, delay);
	};

	$('.cj_modal .card_item').on('click', function () {

		let is_win = check_winner(this);
		if (is_win) {
			$(this).find('.card_item-overlay').addClass('cj_overlay cj_success');
			$(this).find('.card_text').css('display', 'flex').find('span').text(text_win);
			$('.modal_form').slideDown().css('display', 'flex');
		} else {
			$(this).find('.card_item-overlay').addClass('cj_overlay cj_fail');
			$(this).find('.card_text').css('display', 'flex').find('span').text(text_lose);
		};

		// set cookie
		let cookie_options = {
			path: '/',
			expires: 86400 // 24h
		};
		setCookie('cj_block', true, cookie_options);
	});

	function check_winner(card) {
		let cards = modal.find('.card_item'),
			total = cards.length,
			clicked_index = cards.index(card),
			winner_index = Math.floor(Math.random() * total),
			is_win = (clicked_index == winner_index) ? true : false;

		// unbind click on cards
		cards.each(function (indx) {
			$(this).unbind('click');
		})

		return is_win;
	}


	// cards animation
	$('.cj_modal .card_item').on('mouseenter', function () {
		$(this).find('img').addClass('cj_enlarged');
	});
	$('.cj_modal .card_item').on('mouseleave', function () {
		$(this).find('img').removeClass('cj_enlarged');
	});


	$('#cj_modal button[type="submit"]').on('click', function (e) {
		e.preventDefault();

		var form_data = {
			name: modal.find('.modal_name').val(),
			email: modal.find('.modal_email').val(),
			action: 'handler',
		};
		let is_valid = form_validator(form_data);
		if (is_valid) {
			form_sender(form_data);
		};
	});

	function form_validator(data) {
		if (!data.name || !data.email) {
			// validation error
			return false;
		} else {
			return true;
		};
	};


	function form_sender(data) {

		$.ajax({
			url: CJ_AjaxHandler.cj_ajaxurl,
			type: 'POST',
			data: data,
			success: function (resp) {
				modal.find('.form_response').text('Thanks for submit!').slideDown();
			},
			error: function (resp) {
				modal.find('.form_response').text('Sending error').slideDown();
			}
		});
	};


	function modalInit() {
		$.magnificPopup.open({
			fixedContentPos: true,
			items: {
				src: $('#cj_modal'),
				type: 'inline'
			},
		}, 0);
	};

});
