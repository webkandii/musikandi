$(document).ready(function() {
	// Tooltip
	$('.show-tooltip').each(function() {
		$(this).tipsy();
	});

	$('#mi-slider').catslider();

	// Back to top
	$('.back-to-top').click(function (e) {
		e.preventDefault();
	   $('html, body').animate({scrollTop: 0}, 1000);
	});
	
	 // Floating back to top - added by Triss - Feb 2017
        $('body').prepend('<a href="#" class="back-to-top">Back to Top</a>');

        var amountScrolled = 300;

        $(window).scroll(function() {
	   if ( $(window).scrollTop() > amountScrolled ) {
		$('a.back-to-top').fadeIn('slow');
	   } else {
		$('a.back-to-top').fadeOut('slow');
	   }
        });

        $('a.back-to-top, a.simple-back-to-top').click(function() {
	   $('html, body').animate({
		scrollTop: 0
	   }, 700);
	   return false;
        });

	// Tabs
	// If a hash (#) exists in URL then display the hash value instead of defined active element
	if(window.location.hash) {
		// The hashed value
		var hash = window.location.hash;

		// Remove all active classes from tabs navigation
		$('.data-tabs ul li a').each(function() { 
			$(this).removeClass('active');
		});

		// Remove class and hide all tab content
		$('.data-tabs .data-tab-content').removeClass('active').hide();

		// Add active class where the anchor 'href' attribute matches hashed value
		$('.data-tabs ul li a[href="' + hash + '"]').addClass('active');

		// Add active class to tab content that matches hashed value
		$('.data-tabs ' + hash).addClass('active');

		// When user clicks another link on tab navigation
		$('.data-tabs ul li a').click(function(e) {
			// Get id to display from anchors href attribute
			var id = $(this).attr('href');

			// Remove any class instance of active from navigation
			$('.data-tabs ul li a').each(function() { 
				$(this).removeClass('active');
			});

			// Remove class and hide all tab content
			$('.data-tabs .data-tab-content').removeClass('active').fadeOut();
			$('.data-tabs ' + id).fadeIn().addClass('active');
			$(this).addClass('active');
		});
	} else {
		$('.data-tabs .data-tab-content').hide();
		$('.data-tabs ul li a').click(function(e) {

			// Get id to display from anchors href attribute
			var id = $(this).attr('href');

			// Remove any class instance of active from navigation
			$('.data-tabs ul li a').each(function() { 
				$(this).removeClass('active');
			});

			// Remove class and hide all tab content
			$('.data-tabs .data-tab-content').removeClass('active').fadeOut();
			$('.data-tabs ' + id).fadeIn().addClass('active');
			$(this).addClass('active');
		});
	}

	// Table pagination 
	$('.table-pagination table').each(function() {
		$(this).DataTable({
			'iDisplayLength': 20,
			'bFilter': false
		});
	});

	function showMessage(text) {
		$('<div class="message">' + text + '</div>').hide().appendTo('body').fadeIn();
		var width = $('.message').outerWidth() / 2;
		$('.message').css('margin-left', '-' + width + 'px');
	}

	function hideMessage() {
		setTimeout(function() {
			$('.message').fadeOut();
		}, 2500);
	}

	// Add to address book
	$(document).on('click', '.add-to-address-book', function(e) {
		e.preventDefault();
		var table = $(this).attr('data-table');
		var rid = $(this).attr('data-id');
		var $target = $(this);
		var $tr = $(this).closest('tr');
		var data = {
			'table': table,
			'rid': rid
		};
		var abCount = parseInt($('.address-book-count').text()) + 1;

		$(this).text('Adding...').fadeIn();

		$.ajax ({
			type: 'POST',
			url: 'http://musikandi.com/scripts/add-to-address-book.php',
			data: data
		}).done(function(data) {
			showMessage(data);
			$target.fadeOut().replaceWith('<a href="#" class="remove-from-address-book show-tooltip" data-table="' + table + '" data-id="' + rid + '" original-title="Remove this record from your address book"></a>').fadeIn();
			$tr.addClass('in-address-book');
			$('.address-book-count').each(function() {
				$(this).text(abCount);
			});
			hideMessage();
		}).fail(function(data) {
			alert('Error: ' + data['statusText'] + ' Check console log for more details.');
			console.log(data);
		});
	});

	// Remove from address book
	$(document).on('click', '.remove-from-address-book', function(e) {
		e.preventDefault();
		var table = $(this).attr('data-table');
		var rid = $(this).attr('data-id');
		var $target = $(this);
		var $tr = $(this).closest('tr');
		var data = {
			'table': table,
			'rid': rid
		};
		var del = $(this).attr('data-del');
		var abCount = parseInt($('.address-book-count').text()) - 1;

		$(this).text('Removing...').fadeIn();

		$.ajax ({
			type: 'POST',
			url: 'http://musikandi.com/scripts/remove-from-address-book.php',
			data: data
		}).done(function(data) {
			showMessage(data);
			if(del == 'true') {
				$tr.fadeOut();
			} else {
				$target.fadeOut().replaceWith('<a href="#" class="add-to-address-book show-tooltip" data-table="' + table + '" data-id="' + rid + '" original-title="Add this record to your address book"></a>').fadeIn();
				$tr.removeClass('in-address-book');
			}
			$('.address-book-count').each(function() {
				$(this).text(abCount);
			});

			hideMessage();
		}).fail(function(data) {
			alert('Error: ' + data['statusText'] + ' Check console log for more details.');
			console.log(data);
		});
	});

	function setFooterHeight() {
		// Footer, set height of footer to expand height of page
	    var browserHeight = $(window).height();
	    var htmlHeight = $('html').height();

	    if(browserHeight > htmlHeight) {
	        var footerHeight = $('footer').height();
	        var newFooterHeight = browserHeight - htmlHeight + footerHeight;

	        $('footer').css('height', newFooterHeight + 'px');
	    }
	}

	setFooterHeight();
});
