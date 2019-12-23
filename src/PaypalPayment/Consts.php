<?php
namespace Zento\PaypalPayment;

class Consts  {
    const PAYMENT_GATEWAY_PAYPAL_MODE = 'paymentgateway.paypalexpress.mode';
    const PAYMENT_GATEWAY_PAYPAL_CLIENT_ID_BY_MODE = 'paymentgateway.paypalexpress.%s.client_id';
    const PAYMENT_GATEWAY_PAYPAL_SECRET_BY_MODE = 'paymentgateway.paypalexpress.%s.secret';

    const CONFIG_KEY_TITLE = 'paypalexpress.title';
    const CONFIG_KEY_ICON = 'paypalexpress.icon';
    const CONFIG_KEY_ENABLE_FOR_FRONTEND = 'paymentgateway.paypalexpress.frontend.enabled';
    const CONFIG_KEY_ENABLE_FOR_BACKEND = 'paymentgateway.paypalexpress.admin.enabled';

    const CONFIG_KEY_BUTTON_STYLE = 'paypalexpress.button_style';
}