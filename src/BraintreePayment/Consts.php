<?php
namespace Zento\BraintreePayment;

class Consts
{
    const PAYMENT_GATEWAY_BRAINTREE_MODE = 'paymentgateway.braintree.mode';
    const PAYMENT_GATEWAY_BRAINTREE_MERCHANT_ID_BY_MODE = 'paymentgateway.braintree.%s.merchant_id';
    const PAYMENT_GATEWAY_BRAINTREE_CLIENT_ID_BY_MODE = 'paymentgateway.braintree.%s.client_id';
    const PAYMENT_GATEWAY_BRAINTREE_SECRET_BY_MODE = 'paymentgateway.braintree.%s.secret';
    const CONFIG_KEY_TITLE = 'braintree.title';
    const CONFIG_KEY_ICON = 'braintree.icon';
    const CONFIG_KEY_ENABLE_FOR_FRONTEND = 'paymentgateway.braintree.front-end.enabled';
    const CONFIG_KEY_ENABLE_FOR_BACKEND = 'paymentgateway.braintree.admin.enabled';
}
