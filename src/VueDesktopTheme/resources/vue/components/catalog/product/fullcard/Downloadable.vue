<script>
import SimpleProduct from "./Simple"
var mixin = require("../../../../mixin/catalogpollyfill");
export default {
    extends: SimpleProduct,
    mixins: [mixin.default],
    data() {
        return {
            canShowQutity: this.product.download_config && this.product.download_config.quantitative,
        };
    }
};
</script>
