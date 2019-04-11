$(function() {

	'use strict';

	// Dashboard

	$('.toggle_info').click(function () {

		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		if ($(this).hasClass('selected')) {

			$(this).html('<i class="fa fa-minus fa-lg"></i>');

		} else {

			$(this).html('<i class="fa fa-plus fa-lg"></i>');

		}

	});

 	// Calls the selectBoxIt method on your HTML select box and uses the default theme
 	
  	$("select").selectBoxIt({

  		autoWidth: false

  	});

	//hide placeholder on form focus

	$('[placeholder]').focus(function() {

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');

	}).blur(function() {

		$(this).attr('placeholder', $(this).attr('data-text'));

	});

	// Add asterisk on required field

	$('input').each(function () {

		if ($(this).attr('required') === 'required') {

			$(this).after('<span class="asterisk">*</span>');
		}

	});

	// convert password field

	var passField = $('.password')

	$('.show-pass').hover(function () {

		passField.attr('type', 'text');

	}, function () {

		passField.attr('type', 'password');

	});

	//confirm message on button

	$('.confirm').click(function () {

		return confirm('Are You Sure?');

	});


	// Category view option

	$('.cat h3').click(function () {

		$(this).next('.full_viwe').fadeToggle(200);

	});

	$('.option span').click(function () {

		$(this).addClass('active').siblings('span').removeClass('active');

		if ($(this).data('view') === 'full') {

			$('.cat .full_viwe').fadeIn(200);

		} else {

			$('.cat .full_viwe').fadeOut(200);

		}

	});

});