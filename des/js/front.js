$(function() {

	'use strict';

	// login & signup

	$('.login_page h2 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login_page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

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

	//live preveiw add new item 


	$('.live').keyup(function () {

		$($(this).data('class')).text($(this).val());

	});

	/*$('.live_name').keyup(function () {

		$('.live_preiveiw .caption h3').text($(this).val());

	});

	$('.live_desc').keyup(function () {

		$('.live_preiveiw .caption p').text($(this).val());

	});

	$('.live_price').keyup(function () {

		$('.live_preiveiw .price').text('$' + $(this).val());

	});*/


});