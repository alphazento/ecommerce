<script>
import SimpleProduct from "./Simple"
export default {
    extends: SimpleProduct,
    data() {
        return {
            canShowQutity: this.product.download_config && this.product.download_config.quantitative,
        };
    }
};
</script>
