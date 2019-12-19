var Vue = window.Vue;
import Zento_HelloSns_Configs from "@Zento_HelloSns/_components.js"
import Zento_PaypalPayment_Configs from "@Zento_PaypalPayment/_components.js"
import Zento_Backend_Configs from "@Zento_Backend/_components.js"

for (const [key, value] of Object.entries(Zento_HelloSns_Configs)) {
    Vue.component(
        key,
        () => import(`@Zento_HelloSns/${value}` /* webpackChunkName:"vue-dev-watch/zento-hellosns" */ )
    );
}

for (const [key, value] of Object.entries(Zento_PaypalPayment_Configs)) {
    Vue.component(
        key,
        () => import(`@Zento_PaypalPayment/${value}` /* webpackChunkName:"vue-dev-watch/zento-paypalpayment" */ )
    );
}

for (const [key, value] of Object.entries(Zento_Backend_Configs)) {
    Vue.component(
        key,
        () => import(`@Zento_Backend/${value}` /* webpackChunkName:"vue-dev-watch/zento-backend" */ )
    );
}