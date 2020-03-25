<template>
  <!-- filter-connect-route -->
  <config-data-table
    :schema-key="schemaKey"
    :data-api-url="uri"
    use-filter
    server-side-pagination
    @dataChanged="dataChanged"
  ></config-data-table>
</template>

<script>
export default {
  props: {
    scope: String,
    roleId: String | Number
  },
  data() {
    return {
      schemaKey: "",
      uri: ""
    };
  },
  methods: {
    init() {
      this.schemaKey = `${this.scope}_role_user`;
      this.uri = `acl/${this.scope}/roles/${this.roleId}/users-with-candidates`;
    },
    dataChanged(event) {
      var uri = `/api/v1/admin/acl/${this.scope}/roles/${this.roleId}/users`;
      if (event.value) {
        axios.post(uri, { ids: [event._raw.id] }).then(response => {});
      } else {
        axios.delete(`${uri}/${event._raw.id}`).then(response => {});
      }
    }
  },
  created() {
    this.init();
  },
  watch: {
    roleId(nV, oV) {
      console.log("roleId changed", nV);
      this.init();
    }
  }
};
</script>
