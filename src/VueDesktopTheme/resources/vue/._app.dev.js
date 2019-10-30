var Vue = window.Vue;
import Zento_VueDesktopTheme_Configs from "@Zento_VueDesktopTheme/_components.js"

for (const [key, value] of Object.entries(Zento_VueDesktopTheme_Configs)) {
    Vue.component(
        key,
        () => import(`@Zento_VueDesktopTheme/${value}` /* webpackChunkName:"vue-dev-watch/zento-vuedesktoptheme" */ )
    );
}