var Vue = window.Vue;
const DynamicImageSliderComponent= ()=> import("@Zento_VueDesktopTheme/components/ImageSlider.vue" /* webpackChunkName:"zento_vuedesktoptheme/js/cmps/image-slider" */);
Vue.component("image-slider", DynamicImageSliderComponent);
const DynamicProductListComponent= ()=> import("@Zento_VueDesktopTheme/components/ProductList.vue" /* webpackChunkName:"zento_vuedesktoptheme/js/cmps/product-list" */);
Vue.component("product-list", DynamicProductListComponent);