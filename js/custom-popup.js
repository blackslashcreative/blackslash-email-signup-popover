/***************************************************
/* Custom Email Signup Popover by BlackSla.sh
***************************************************/
jQuery(document).ready( function ($) {

	// Popup Cookies
	var now, lastDatePopupShowed;
	now = new Date();

	if (localStorage.getItem('lastDatePopupShowed') !== null) {
		lastDatePopupShowed = new Date(parseInt(localStorage.getItem('lastDatePopupShowed')));
	}

	if (((now - lastDatePopupShowed) >= (5 * 86400)) || !lastDatePopupShowed) {

		// Email Signup Popover
		var delay=10000; // 10 seconds

		setTimeout(function(){

			$.magnificPopup.open({
			  items: [
				{
				  src: '#email-pop', // CSS selector of an element on page that should be used as a popup
				  type: 'inline'
				}
			  ],
			  // Add options here, they're exactly the same as for $.fn.magnificPopup call
			  modal:false
			}, 0);

		}, delay);

	localStorage.setItem('lastDatePopupShowed', now);

	}

	// On Click Popups
	$('.subscribe a,a.subscribe,button.subscribe,a[href*="email-pop"]').magnificPopup({
	  items: [
		{
		  src: '#email-pop', // CSS selector of an element on page that should be used as a popup
		  type: 'inline'
		}
	  ],
	  midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
	});

});
