<template>
  <v-card>
    <v-card-title class="headline">
    </v-card-title>
  </v-card>
</template>

<script>

export default {
  props: {
   model: String,
   id: Number
  },
  data() {
    return {
      attributes: {},
      attribute_set: {}
    };
  },
  methods: {
    fetchAttributeSet() {
      axios
        .get(`/api/v1/admin/dynamicattribute-sets/${this.id}`).then(response => {
          if (response.data.success) {
            this.attribute_set = response.data.data;
          }
        })
    },
    fetchAttributes() {
      axios
        .get(`/api/v1/admin/dynamicattributes/${this.model}`).then(response => {
          if (response.data.success) {
            this.attributes = response.data.data;
          }
        })
    }
  },
  mounted() {
    if (this.id > 0) {
      this.fetchAttributeSet();
    }
  },
  watch: {
    id(nV, oV) {
      console.log('id changed', nV);
    }
  }
};
</script>
