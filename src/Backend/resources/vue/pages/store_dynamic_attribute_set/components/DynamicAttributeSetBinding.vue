<template>
  <v-card v-if="current_id > 0">
    <v-card-title class="headline">
      Dynamic Attributes belongs to Attribute Set [{{ current_attribute_set.name }}]
    </v-card-title>
    <v-card-text>
      <v-container>
        <v-layout row>
          <v-flex md4 v-for="item of attributes" :key="item.id">
              <v-checkbox v-model="attribute_status_mapping[item.id]" :label="item.attribute_name" @change="valueChanged(item.id)" ></v-checkbox>
          </v-flex>
        </v-layout>     
      </v-container>
    </v-card-text>
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
      attribute_status_mapping: {},
      current_attribute_set: {id:-1},
      current_id: this.id
    };
  },
  methods: {
    fetchModelAttributes() {
      this.$store.dispatch('showSpinner', 'Fetching attributes...');
      return axios
          .get(`/api/v1/admin/dynamicattributes/models/${this.model}`)
          .then(response => {
            this.$store.dispatch("hideSpinner");
            if (response.data && response.data.success) {
              this.attributes = response.data.data;
            }
            this.$store.dispatch('hideSpinner');

            if (this.current_id) {
              this.fetchAttributeSet();
            }
          });
    },
   
    fetchAttributeSet() {
      this.$store.dispatch('showSpinner', 'Fetching attribute set data...');
      axios
        .get(`/api/v1/admin/dynamicattribute-sets/${this.current_id}`).then(response => {
          if (response.data.success) {
            this.current_attribute_set = response.data.data;
            this.attributes.forEach(item => {
                this.attribute_status_mapping[item.id] = false;
            });
            this.current_attribute_set.attributes.forEach(item => {
                this.attribute_status_mapping[item.id] = true;
            })
          }
          this.$store.dispatch('hideSpinner');
        })
    },
    valueChanged(id) {
      let url = `/api/v1/admin/dynamicattribute-sets/${this.current_id}/attributes/${id}`;
      let method = this.attribute_status_mapping[id] ? 'put' : 'delete';
      axios[method](url).then(response => {
        console.log(response);
      });
    }
  },
  mounted() {
    if (this.model) {
      this.fetchModelAttributes();
    }
  },
  watch: {
    id(nV, oV) {
      this.current_id = nV;
      this.fetchAttributeSet();
    },
    model(nV, oV) {
      this.current_id = 0;
      this.fetchModelAttributes();
    }
  }
};
</script>
