<?php 
    $mode = config('paymentgateway.paypalexpress.mode');
    $clientId = config(sprintf('paymentgateway.paypalexpress.%s.client_id', $mode));
?>
<script src=@asset("/zento_paypalpayment/js/paypalexpress.js") type="text/javascript"></script>
<script>
    var paypal_config = {
        env: "{{ $mode }}",
        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
        client: {
            sandbox: "{{ $clientId }}",
            production: "{{ $clientId }}"
        }
    };
</script>

<script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
<script>paypal.Buttons().render('body');</script>