<script>
import FullSimple from "./FullSimple";
export default {
  extends: FullSimple,
  created() {
    console.log("downloadable", this.item);
    this.quantitive = this.item.product.download_config
      ? this.item.product.download_config.quantitive > 0
      : true;
  },
};
</script>
