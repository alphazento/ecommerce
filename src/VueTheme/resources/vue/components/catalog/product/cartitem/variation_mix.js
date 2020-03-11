export default {
    data() {
        return {
            reduced: []
        };
    },
    created() {
        this.product_image = this.item.actuals[0].product.image;
        let keys = Object.keys(this.item.options);
        let url_paras = [];
        keys.forEach(name => {
            if (name !== "actual_pid") {
                let value = this.item.options[name];
                this.reduced.push({
                    name: name,
                    value: this.item.options[name]
                });
                url_paras.push(`${name}=${value}`);
            }
        });

        // let url = this.getProductUrl(this.item.product);
        // let para_str = url_paras.join('&');
        // this.product_url = `${url}?${para_str}`;
    }
}