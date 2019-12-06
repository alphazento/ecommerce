export default {
    data() {
        return {
            reduced: []
        };
    },
    created() {
        this.product_image = this.getProductImageUrl(this.item.actuals[0].product);
        let keys = Object.keys(this.item.options);
        keys.forEach(name => {
            if (name !== "actual_pid") {
                this.reduced.push({
                    name: name,
                    value: this.item.options[name]
                });
            }
        });
    }
}
