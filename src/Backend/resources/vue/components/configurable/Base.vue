<script>
export default {
  props: {
    idx: String | Number, //it's optional
    accessor: String,
    title: String,
    ui: String,
    value: String | Number,
    options: Array,
    extraData: Object
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
    valueChanged(nV) {
      if (this.innerValue !== this.oldVal) {
        var data = {
          accessor: this.accessor,
          value: this.getValue(),
          is_json: this.is_json,
          idx: this.idx
        };
        this.$emit("valueChanged", data);
        if(data.rollback) {
          this.innerValue = this.oldVal;
        }
      }
      this.oldVal = this.innerValue;
    }
  },
  watch: {
    value(nV, oV) {
      this.innerValue = nV;
      this.oldVal = nV;
    }
  }
};
</script>
