<script>
export default {
    props: {
        accessor: {
            type: String
        },
        title: {
            type: String
        },
        ui: {
            type: String
        },
        value: {
            type: String | Number
        },
        options: {
            type: Array
        }
    },
    data() {
        return {
            oldVal: this.value,
            innerValue: this.value,
            is_json: false
        };
    },
    methods: {
        getValue() {
            return this.innerValue;
        },
        valueChanged() {
            if (this.innerValue != this.oldVal) {
                this.$emit("valueChanged", {
                    accessor: this.accessor,
                    value: this.getValue(),
                    is_json: this.is_json
                });
            }
            this.oldVal = this.innerValue;
        }
    },
    watch: {
        value(oV, nV) {
            this.innerValue = nV;
        }
    }
};
</script>
