//<--------- Start Payment -------//>
(function($) {
	"use strict";

	$('input[name=payment_gateway_ppe]').on('click', function() {
    if($(this).val() == 2) {
      $('#stripeContainerPPE').slideDown();
    } else {
      $('#stripeContainerPPE').slideUp();
    }
  });

 //<---------------- Pay PPE ----------->>>>
 if (stripeKey != '') {

 // Create a Stripe client.
 var stripe = Stripe(stripeKey);

 // Create an instance of Elements.
 var elements = stripe.elements();

 // Custom styling can be passed to options when creating an Element.
 // (Note that this demo uses a wider set of styles than the guide below.)
 var style = {
	 base: {
		 color: colorStripe,
		 fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
		 fontSmoothing: 'antialiased',
		 fontSize: '16px',
		 '::placeholder': {
			 color: '#aab7c4'
		 }
	 },
	 invalid: {
		 color: '#fa755a',
		 iconColor: '#fa755a'
	 }
 };

 // Create an instance of the card Element.
 var cardElement = elements.create('card', {style: style, hidePostalCode: true});

 // Add an instance of the card Element into the `card-elementPPE` <div>.
 cardElement.mount('#card-elementPPE');

 // Handle real-time validation errors from the card Element.
 cardElement.addEventListener('change', function(event) {
	 var displayError = document.getElementById('card-errorsPPE');
	 var payment = $('input[name=payment_gateway_ppe]:checked').val();

	 if (payment == 2) {
		 if (event.error) {
			 displayError.classList.remove('display-none');
			 displayError.textContent = event.error.message;
			 $('#ppeBtn').removeAttr('disabled');
			 $('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
		 } else {
			 displayError.classList.add('display-none');
			 displayError.textContent = '';
		 }
	 }

 });

 var cardholderName = document.getElementById('cardholder-name-PPE');
 var cardholderEmail = document.getElementById('cardholder-email-PPE');
 var cardButton = document.getElementById('ppeBtn');

 cardButton.addEventListener('click', function(ev) {

	 var payment = $('input[name=payment_gateway_ppe]:checked').val();

	 if (payment == 2) {

	 stripe.createPaymentMethod('card', cardElement, {
		 billing_details: {name: cardholderName.value, email: cardholderEmail.value}
	 }).then(function(result) {
		 if (result.error) {

			 if (result.error.type == 'invalid_request_error') {

					 if(result.error.code == 'parameter_invalid_empty') {
						 $('.popout').addClass('popout-error').html(error).fadeIn('500').delay('8000').fadeOut('500');
					 } else {
						 $('.popout').addClass('popout-error').html(result.error.message).fadeIn('500').delay('8000').fadeOut('500');
					 }
			 }
			 $('#ppeBtn').removeAttr('disabled');
			 $('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');

		 } else {

			 $('#ppeBtn').attr({'disabled' : 'true'});
			 $('#ppeBtn').find('i').addClass('spinner-border spinner-border-sm align-middle mr-1');

			 // Otherwise send paymentMethod.id to your server
			 $('input[name=payment_method_id]').remove();

			 var $input = $('<input id=payment_method_id type=hidden name=payment_method_id />').val(result.paymentMethod.id);
			 $('#formSendPPE').append($input);

			 $.ajax({
			 headers: {
					 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				 },
				type: "POST",
				dataType: 'json',
				url: URL_BASE+"/send/ppe",
				data: $('#formSendPPE').serialize(),
				success: function(result) {
						handleServerResponse(result);

						if(result.success == false) {
							$('#ppeBtn').removeAttr('disabled');
							$('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
						}
			}//<-- RESULT
			})

		 }//ELSE
	 });
 }//PAYMENT STRIPE
});

 function handleServerResponse(response) {
	 if (response.error) {
		 $('.popout').addClass('popout-error').html(response.error).fadeIn('500').delay('8000').fadeOut('500');
		 $('#ppeBtn').removeAttr('disabled');
		 $('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');

	 } else if (response.requires_action) {
		 // Use Stripe.js to handle required card action
		 stripe.handleCardAction(
			 response.payment_intent_client_secret
		 ).then(function(result) {
			 if (result.error) {
				 $('.popout').addClass('popout-error').html(error_payment_stripe_3d).fadeIn('500').delay('10000').fadeOut('500');
				 $('#ppeBtn').removeAttr('disabled');
				 $('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');

			 } else {
				 // The card action has been handled
				 // The PaymentIntent can be confirmed again on the server

				 var $input = $('<input type=hidden name=payment_intent_id />').val(result.paymentIntent.id);
				 $('#formSendPPE').append($input);

				 $('input[name=payment_method_id]').remove();

				 $.ajax({
				 headers: {
						 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					 },
					type: "POST",
					dataType: 'json',
					url: URL_BASE+"/send/ppe",
					data: $('#formSendPPE').serialize(),
					success: function(result){

						if(result.success) {

							if (result.data) {
								$('.chatlist[data=' + result.msgId + ']').html('');
								$('.chatlist[data=' + result.msgId + ']').html(result.data);

								jQuery(".timeAgo").timeago();

				          new SmartPhoto(".js-smartPhoto",{
										resizeStyle: 'fit',
										showAnimation: false,
										nav: false,
										useHistoryApi: false
									});

									const players = Plyr.setup('.js-player');

									$('#payPerEventForm').modal('hide');
				 	 				$('.InputElement').val('');
				 	 				$('#formSendPPE').trigger("reset");
				 	 				$('#ppeBtn').removeAttr('disabled');
				 	 				$('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
									$('.balanceWallet').html(result.wallet);

							} else {
								window.location.href = result.url;
							}

						} else {
							$('.popout').addClass('popout-error').html(result.error).fadeIn('500').delay('8000').fadeOut('500');
							$('#ppeBtn').removeAttr('disabled');
							$('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
						}
				}//<-- RESULT
				})
			 }// ELSE
		 });
	 } else {
		 // Show success message
		 if (response.success) {

			 if (response.data) {
				 $('.chatlist[data=' + response.msgId + ']').html('');
				 $('.chatlist[data=' + response.msgId + ']').html(response.data);

				 jQuery(".timeAgo").timeago();

					 new SmartPhoto(".js-smartPhoto",{
						 resizeStyle: 'fit',
						 showAnimation: false,
						 nav: false,
						 useHistoryApi: false
					 });

					 const players = Plyr.setup('.js-player');

					 $('#payPerViewForm').modal('hide');
					 $('.InputElement').val('');
					 $('#formSendPPE').trigger("reset");
					 $('#ppeBtn').removeAttr('disabled');
					 $('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
					 $('.balanceWallet').html(response.wallet);

			 } else {
				 window.location.href = response.url;
			 }
		 }
	 }
 }
}
// Stripe Elements


//<---------------- Pay PPE ----------->>>>
 $(document).on('click','.ppeBtn',function(s) {

	 s.preventDefault();
	 var element = $(this);
	 var form = $(this).attr('data-form');
	 element.attr({'disabled' : 'true'});
	 var payment = $('input[name=payment_gateway_ppe]:checked').val();
	 element.find('i').addClass('spinner-border spinner-border-sm align-middle mr-1');

	 (function(){
			$('#formSendPPE').ajaxForm({
			dataType : 'json',
			success:  function(result) {

				// Wallet
				if (result.success == true && payment == 'wallet' || result.success && result.instantPayment) {

					if (result.data) {
						$('.chatlist[data=' + result.msgId + ']').html('');
						$('.chatlist[data=' + result.msgId + ']').html(result.data);

						jQuery(".timeAgo").timeago();

		          new SmartPhoto(".js-smartPhoto",{
								resizeStyle: 'fit',
								showAnimation: false,
								nav: false,
								useHistoryApi: false
							});

							const players = Plyr.setup('.js-player');

							$('#payPerViewForm').modal('hide');
		 	 				$('.InputElement').val('');
		 	 				$('#formSendPPE').trigger("reset");
		 	 				$('#ppeBtn').removeAttr('disabled');
		 	 				$('#ppeBtn').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
							$('.balanceWallet').html(result.wallet);

					} else {
						window.location.href = result.url;
					}

				}

				// success
				else if (result.success == true && result.insertBody) {

					$('#bodyContainer').html('');

				 $(result.insertBody).appendTo("#bodyContainer");

				 if (payment != 1 && payment != 2) {
					 element.removeAttr('disabled');
					 element.find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
				 }

					$('#errorPPE').hide();

				} else if (result.success == true && result.url) {
					window.location.href = result.url;
				} else {

					if (result.errors) {

						var error = '';
						var $key = '';

						for($key in result.errors) {
							error += '<li><i class="far fa-times-circle"></i> ' + result.errors[$key] + '</li>';
						}

						$('#showErrorsPPE').html(error);
						$('#errorPPE').show();
						element.removeAttr('disabled');
						element.find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
					}
				}

			 },
			 error: function(responseText, statusText, xhr, $form) {
					 // error
					 element.removeAttr('disabled');
					 element.find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');
					 swal({
							 type: 'error',
							 title: error_oops,
							 text: error_occurred+' ('+xhr+')',
						 });
			 }
		 }).submit();
	 })(); //<--- FUNCTION %
 });//<<<-------- * END FUNCTION CLICK * ---->>>>
//============ End Payment =================//

$('#payPerEventForm').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
	var mediaIdInput = button.data('mediaid'); // Extract info from data-* attributes
	var pricePPE = button.data('price'); // Extract info from data-* attributes
	var priceGrossPPE = button.data('pricegross');

  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
	modal.find('.pricePPE').html(pricePPE);
	modal.find('.mediaIdInput').val(mediaIdInput);
	modal.find('.priceInput').val(priceGrossPPE);
});

$('#payPerViewForm').on('hidden.bs.modal', function (e) {
  $('#errorPPE').hide();
	$('#formSendPPE').trigger("reset");
	$('#card-errorsPPE').addClass('display-none');
	$('.InputElement').val('');
	$('#card-elementPPE').removeClass('StripeElement--invalid');
});

})(jQuery);
