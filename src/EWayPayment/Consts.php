<?php
namespace Zento\EWayPayment;

class Consts  {
    const PAYMENT_GATEWAY_EWAY_MODE = 'paymentgateway.eway.mode';
    const PAYMENT_GATEWAY_EWAY_CLIENT_ID_BY_MODE = 'paymentgateway.eway.%s.client_id';
    const PAYMENT_GATEWAY_EWAY_SECRET_BY_MODE = 'paymentgateway.eway.%s.secret';

    const CONFIG_KEY_TITLE = 'ewaypayment.title';
    const CONFIG_KEY_ENABLE_FOR_FRONTEND = 'paymentgateway.eway.front-end.enabled';
    const CONFIG_KEY_ENABLE_FOR_BACKEND = 'paymentgateway.eway.admin.enabled';
}