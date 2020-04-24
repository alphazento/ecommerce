<template>
  <config-data-table
    schemaKey="acl_role"
    :headers="headers"
    :data-api-url="uri"
    filter-connect-route
    use-filter
    server-side-pagination
    @dataChanged="dataChanged"
    @proxyAction="proxyAction"
  ></config-data-table>
</template>

<script>
const TABLE_HEADER = [
  {
    text: "ID",
    ui: "z-label",
    value: "id",
    filter_ui: "config-text-item",
    clearable: true
  },
  {
    text: "Name",
    ui: "z-label",
    value: "name",
    filter_ui: "config-text-item",
    clearable: true,
    sortable: false
  },
  {
    text: "Description",
    ui: "z-label",
    value: "description",
    filter_ui: "config-text-item",
    clearable: true,
    sortable: false
  },
  {
    text: "Active",
    ui: "config-boolean-item",
    value: "active",
    filter_ui: "config-options-item",
    options: [
      { label: "Active", value: 1 },
      { label: "Unactive", value: 0 }
    ],
    clearable: true
  },
  {
    text: "Actions",
    ui: "z-config-actions",
    value: "_none_",
    options: [{ label: "Edit", value: "ViewRole" }]
  }
];

export default {
  props: {
    scope: String
  },
  data() {
    return {
      headers: TABLE_HEADER,
      uri: `acl/${this.scope}/roles`
    };
  },
  methods: {
    dataChanged(event) {
      event._raw[event.accessor] = event.value;
      axios
        .patch(`/api/v1/admin/${this.uri}/${event._raw.id}`, event._raw)
        .then(response => {
          if (response.success) {
            this.$store.dispatch("SNACK_MESSAGE", "Updated.");
          } else {
            event.rollback = true;
          }
        });
    }
  }
};
</script>
