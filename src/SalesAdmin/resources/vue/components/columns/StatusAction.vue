<template>
  <v-select
    class="limit-width"
    :items="canDoOptions"
    :disabled="!canEdit"
    item-text="label"
    item-value="value"
    required
    v-model="innerValue"
    @change="changeStatus"
  >
    <template v-slot:selection="{item}">
      <v-btn width="100%" :color="item.color">{{item.label}}</v-btn>
    </template>
    <template v-slot:item="{item}">
      <v-btn width="100%" :color="item.color">{{item.label}}</v-btn>
    </template>
  </v-select>
</template>

<script>
import BaseConfig from "@Zento_Backend/components/configurable/Base";
export default {
  extends: BaseConfig,
  props: {
    extraData: {
      id: String
    }
  },
  data() {
    return {
      canEdit: true
    };
  },
  methods: {
    valueChanged(data) {
      let status = this.getLable(this.innerValue);
      axios
        .post(
          `/api/v1/admin/sales/orders/${this.extraData.id}/status/${this.innerValue}`,
          {
            comment: data.comment,
            notify: `[${status}]${data.notifyCustomer}`
          }
        )
        .then(
          response => {
            if (!response.data.success) {
              this.innerValue = this.oldVal;
            }
          },
          err => {
            this.innerValue = this.oldVal;
          }
        );
    },

    changeStatus() {
      if (this.needComment()) {
        let label = this.getLable(this.innerValue);
        eventBus.$emit('openDialog', {
          component: "z-admin-comment-dialog-body",
          bind: { title: `change to status [${label}]`},
          closeNotify: this.handleDialogClose
        })
      } else {
        this.valueChanged();
      }
    },

    handleDialogClose(result) {
      if (result.success) {
        //can continue to change status
        this.valueChanged(result);
      } else {
        this.innerValue = this.oldVal;
      }
    },

    needComment() {
      return true;
    },

    getLable(value) {
        let items = this.options.filter(item => {
            return item.value === value;
        });

        if (items && items.length > 0) {
            return items[0].label;
        }
        return "";
    }
  },
  computed: {
    canDoOptions() {
      let selectedOption = this.options.find(element => {
        return element.value === this.innerValue;
      });
      if (!selectedOption || !selectedOption.next_cadidates) {
        return this.options;
      }

      let options = this.options.filter(element => {
        return selectedOption.next_cadidates.includes(element.value);
      });
      options.push(selectedOption);
      return options;
    }
  }
};
</script>
