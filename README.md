### Payment and Checkout process

#### 1. request to PaymentGateway

by call api: /api/v1/payment/capture/paypalexpress

which will calls PaymentGateway::capturePayment

http request -> /api/v1/payment/capture/{payment_method} -> PaymentGateway::capturePayment

--> trig event "BeforeCapturePayment"

--> then the payment method run "capture"

--> if the payment gateway canDraftOrderAfterCapture then

--> CheckoutService::draftOrder -> trig event 'DraftOrder'

--> Zento\Sales\Event\Listener\DraftOrder will response the event, and draft a real order.
