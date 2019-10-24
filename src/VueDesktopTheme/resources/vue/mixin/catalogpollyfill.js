export default {
  methods: {
    getProductUrl: function (product) {
      return `${product.url_key}.html`;
    },
    getProductImageUrl: function (product, relativePath) {
      relativePath = relativePath || '/zento_vuedesktoptheme/image/product'
      return `${relativePath}/${product.name}.png`;
    }
  }
}