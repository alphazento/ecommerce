@push('head')
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
@endpush

<div id="paypal-button-container" style="text-align: center;">
</div>

<?php 
    $mode = config('paymentgateway.paypalexpress.mode');
    $clientId = config(sprintf('paymentgateway.paypalexpress.%s.client_id', $mode));
    list($flg, $data) = $service->prepare(['cart_id' => $cart->guid]);
?>
{{-- <script>
    var paypal_config = {
        env: "{{ $mode }}",
        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
        client: {
            sandbox: "{{ $clientId }}",
            production: "{{ $clientId }}"
        }
    };
</script> --}}
<script src="https://www.paypal.com/sdk/js?client-id={{$clientId}}"></script>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            // Set up the transaction
            return actions.order.create(
                @json($data)
            );
        },
        onApprove: function(data, actions) {
            // Capture the funds from the transaction
            return actions.order.capture().then(function(details) {
                // Show a success message to your buyer
                console.log('Transaction completed by', details);
                return fetch('/payment/postpayq', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                });
            });
        }
    }).render('#paypal-button-container');
</script>
