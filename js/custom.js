/***************************************************
/* Custom Email Signup Popover by BlackSla.sh
***************************************************/
jQuery(document).ready( function ($) {

	// Ajax Subscribe
	$("#signup-form").submit(function(e){
		e.preventDefault();
		$("#status").text("");
		var $form = $(this),
		name = $form.find('input[name="name"]').val(),
		email = $form.find('input[name="email"]').val(),
		captcha = $form.find('textarea[name=g-recaptcha-response]').val(),
		url = $form.attr('action');

		var spam = document.getElementById('spamurl');

		$.post(url, {name:name,email:email,'g-recaptcha-response':captcha},
		  function(data) {
		      if(data)
		      {
				//$("#status").text(data);
		      	if(data == 'test') {
					$("#status").text("testing...");
			      	$("#status").css("color", "red");
				}
				else if(spam.value.length !== 0)
		      	{
					$("#status").text("Gotcha.");
			      	$("#status").css("color", "green");
			      	magnificPopup.close();
		      	}
				else if(data == "Captcha Failed"){
		      		$("#status").text("Human Verification Failed.");
			      	$("#status").css("color", "red");
		      	}
		      	else if(data=="Some fields are missing.")
		      	{
			      	$("#status").text("Please fill in your name and email.");
			      	$("#status").css("color", "red");
		      	}
				else if(data=="Invalid email address.")
		      	{
			      	$("#status").text("Your email address is invalid.");
			      	$("#status").css("color", "red");
		      	}
		      	else if(data=="Invalid list ID.")
		      	{
			      	$("#status").text("Your list ID is invalid.");
			      	$("#status").css("color", "red");
		      	}
		      	else if(data=="Already subscribed.")
		      	{
			      	$("#status").text("You've already joined!");
			      	$("#status").css("color", "red");
		      	}
		      	else if(data=="Account Created")
		      	{
			      	$("#status").text("Welcome to Oddflower!");
			      	$("#status").css("color", "green");
                    setTimeout(function () {
                        jQuery.magnificPopup.close();
                    },2000);
		      	}else
		      	{
			      	$("#status").text("An error occurred, please try again.");
			      	$("#status").css("color", "red");
		      	}
		      }
		      else
		      {
		          $("#status").text("Please complete all fields.");
			      $("#status").css("color", "red");
		      }
		  }
		);
	});

});
