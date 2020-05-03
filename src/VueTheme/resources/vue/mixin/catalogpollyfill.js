export default {
    methods: {
        getProductUrl: function (product) {
            if (product) {
                return `/${product.url_key}.html`;
            }
            return '#';
        },
        // getProductImageUrl: function (product, relativePath) {
        //     if (product) {
        //         relativePath = relativePath || '/zento_vuetheme/image/product'
        //         return `${relativePath}/${product.name}.png`;
        //     }
        //     return 'not-found.png';
        // }
        getProductImageUrl: function (product, relativePath) {
            if (product) {
                relativePath = relativePath || '/images/catalog/product'
                return `${relativePath}/${product.image}`;
            }
            return 'not-found.png';
        }
    }
}