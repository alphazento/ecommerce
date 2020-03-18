<template>
    <v-expansion-panels accordion multiple focusable v-if="current_id > 0">
        <v-expansion-panel>
            <v-expansion-panel-header text-left>
                Contains Dynamic Attributes
            </v-expansion-panel-header>
            <v-expansion-panel-content>
                <v-container>
                    <v-layout row>
                        <v-flex
                            md4
                            v-for="(item, id) of attribute_checked_mapping"
                            :key="id"
                        >
                            <v-checkbox
                                v-model="item.checked"
                                :label="item.name"
                                @change="valueChanged(id)"
                            ></v-checkbox>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>
</template>

<script>
// Manage Attribute Set to have many Attributes
export default {
    props: {
        model: String,
        id: Number
    },
    data() {
        return {
            attributes: [],
            attribute_checked_mapping: {},
            current_attribute_set: { id: -1 },
            current_id: this.id
        };
    },
    methods: {
        fetchModelAttributes() {
            this.$store.dispatch("SHOW_SPINNER", "Fetching attributes...");
            return axios
                .get(`/api/v1/admin/dynamic-attributes/models/${this.model}`)
                .then(response => {
                    this.$store.dispatch("HIDE_SPINNER");
                    if (response && response.success) {
                        this.attributes = response.data;
                    }
                    this.$store.dispatch("HIDE_SPINNER");
                    if (this.current_id) {
                        this.fetchAttributeSet();
                    }
                });
        },

        fetchAttributeSet() {
            this.$store.dispatch(
                "showSpinner",
                "Fetching attribute set data..."
            );
            axios
                .get(`/api/v1/admin/dynamic-attribute-sets/${this.current_id}`)
                .then(response => {
                    if (response.success) {
                        this.current_attribute_set = response.data;
                        var mapping = {};
                        this.attributes.forEach(item => {
                            mapping[item.id] = {
                                name: item.name,
                                checked: false
                            };
                        });
                        this.current_attribute_set.attributes.forEach(item => {
                            mapping[item.id].checked = true;
                        });
                        this.attribute_checked_mapping = mapping;
                    }
                    this.$store.dispatch("HIDE_SPINNER");
                });
        },
        valueChanged(id) {
            let url = `/api/v1/admin/dynamic-attribute-sets/${this.current_id}/attributes/${id}`;
            let method = this.attribute_checked_mapping[id].checked
                ? "put"
                : "delete";
            this.$store.dispatch("SHOW_SPINNER", "Updating...");
            axios[method](url).then(response => {
                this.$store.dispatch("HIDE_SPINNER");
                if (response.success) {
                    this.$store.dispatch(
                        "snackMessage",
                        "Added to Attribute Set"
                    );
                } else {
                    this.$store.dispatch(
                        "snackMessage",
                        "Removed from Attribute Set"
                    );
                }
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
