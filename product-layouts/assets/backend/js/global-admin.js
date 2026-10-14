;(function($){

	$(document).ready(function(){
		$('body').on('click', '#wpte-get-review .notice-dismiss', function(){
			wpteSetCookie('wpte-user-review', 1, 7*24*3600);
			wpteSaveReviewDismissal('later');
		});
		$('body').on('click', '#wpte-get-review .wpte-btn-never', function(){
			wpteSetCookie('wpte-user-review', 1, 365*24*3600);
			wpteSaveReviewDismissal('never');
			$('#wpte-get-review').fadeOut(300, function(){ $(this).remove(); });
		});
		$('body').on('click', '#wpte-get-review .wpte-btn-given', function(){
			wpteSetCookie('wpte-user-review', 1, 365*24*3600);
			wpteSaveReviewDismissal('never');
			$('#wpte-get-review').fadeOut(300, function(){ $(this).remove(); });
		});
	});

	// The cookie only covers this browser; saving on the site keeps the
	// notice hidden after logging out or on another browser.
	function wpteSaveReviewDismissal(mode) {
		if (typeof wpteReview === 'undefined') {
			return;
		}
		$.post(wpteReview.ajaxUrl, { action: 'wpte_review_notice', _nonce: wpteReview.nonce, mode: mode });
	}

	function wpteSetCookie(cookieName, cookieValue, expiryInSeconds) {
		var expiryDate = new Date();
		expiryDate.setTime(expiryDate.getTime() + (expiryInSeconds * 1000));
		var expires = "expires=" + expiryDate.toUTCString();
		document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
	}

	$('.wpte-po-element').on('click', function (e) {
		e.preventDefault();
		var wrapper = $('#wpte-offer-modal'),
		  image = wpteoffer.img,
		  u_text = wpteoffer.u_text,
		  discount = wpteoffer.discount,
		  description = wpteoffer.description,
		  button_text = wpteoffer.button_text,
		  button_url = wpteoffer.button_url;
		wrapper.html(`<div class="wpte-offer-modal-wrap">
				<div class="wpte-offer-modal">
					<span class="wpte-offer-modal-close">×</span>
					<img src= "${image}", alt="Upgrade to Pro">
					<h3>${u_text}</h3>
					<h2>${discount}</h2>
					<p>${description}</p>
					<a href="${button_url}" class="wpte-btn wpte-btn-success" target="_blank">${button_text}</a>
				</div>
			</div>`);
	});
	
	$(document).on('click', '.wpte-offer-modal-close', function (e) {
		e.preventDefault();
		var wrapper = $('#wpte-offer-modal');
		wrapper.html('');
	});
	
})(jQuery);