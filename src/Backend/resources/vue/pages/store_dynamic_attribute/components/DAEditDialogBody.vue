<template>
    <v-card>
        <v-card-title class="headline">
            Edit Attribute
        </v-card-title>

        <v-card-text>
            <v-form>
                <v-layout v-for="(comp, i) of components" :key="i">
                    <v-flex md3>
                        <p class="subtitle-1">{{ comp.title }}:</p>
                    </v-flex>
                    <v-flex md9>
                        <component
                            :is="comp.ui"
                            v-bind="comp"
                            @valueChanged="configValueChanged"
                        ></component>
                    </v-flex>
                </v-layout>
            </v-form>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="green darken-1" text @click="closeDialog(false)">
                Disard
            </v-btn>

            <v-btn color="green darken-1" text @click="saveData">
                Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
const CONFIG_ITEM = {
    editable: Boolean,
    options: Array,
    text: String,
    ui: String,
    value: String
};
export default {
    props: {
        mode: String,
        defines: Array[CONFIG_ITEM],
        item: {
            type: Object
        }
    },
    data() {
        return {
            configs: {},
            components: [],
            dataChanged: false,
            itemCopy: null
        };
    },
    methods: {
        closeDialog(ignore) {
            this.$emit("close", ignore);
        },
        prepareData() {
            let components = [];
            for (const [key, value] of Object.entries(this.item)) {
                let config = this.configs[key];
                if (config !== undefined) {
                    components.push({
                        ui: config["editable"]
                            ? config["edit_ui"]
                            : config["ui"],
                        accessor: config["value"],
                        options: config["options"],
                        title: config["text"],
                        value: value
                    });
                }
            }
            this.components = components;
            this.dataChanged = false;
            this.itemCopy = Object.assign({}, this.item);
        },
        configValueChanged(item) {
            this.dataChanged = true;
            this.itemCopy[item.accessor] = item.value;
        },
        saveData() {
            let id = this.itemCopy.id;
            axios
                .patch(`/api/v1/admin/dynamicattributes/${id}`, {
                    attributes: this.itemCopy
                })
                .then(response => {
                    console.log("saveData", response);
                });
        }
    },
    mounted() {
        this.defines.forEach(element => {
            this.configs[element.value] = element;
        });
        this.prepareData();
    },
    watch: {
        item(oldVal, newVal) {
            this.prepareData();
        }
    }
};
</script>
