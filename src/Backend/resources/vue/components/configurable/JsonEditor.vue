<template>
    <simple-json-item :components="components"> </simple-json-item>
</template>

<script>
import BaseLabel from "./Label";
export default {
    extends: BaseLabel,
    props: {
        value: {
            type: String | Object
        },
        schema: {
            type: Object
        }
    },
    data() {
        return {
            components: Object
        };
    },
    mounted() {
        this.components = this.convertToComponentArray(this.value, this.schema);
    },
    methods: {
        isObject(obj) {
            return Object.prototype.toString.call(obj) === "[object Object]";
        },
        convertToComponentArray(json, schema) {
            if (!json) {
                json = schema;
            }
            if (!this.isObject(json)) {
                json = JSON.parse(json);
            }
            let components = {};
            for (const [key, value] of Object.entries(json)) {
                if (this.isObject(value)) {
                    components[key] = this.convertToComponentArray(
                        value,
                        schema[key]
                    );
                } else {
                    if (value instanceof Array) {
                        components[key] = [];
                        for (var i = 0; i < value.length; i++) {
                            var element = value[i];
                            components[key].push(
                                this.convertToComponentArray(
                                    element,
                                    schema[key][i]
                                )
                            );
                        }
                    } else {
                        components[key] = {
                            title: key,
                            ui: schema[key],
                            value: value,
                            accessor: key,
                            metanode: true
                        };
                    }
                }
            }
            console.log("components", components);
            return components;
        },

        addItem() {},

        canAddItem(name) {
            return true;
        },

        canRemoveItem(name) {
            return true;
        }
    },
    watch: {
        value() {
            this.components = this.convertToComponentArray(
                this.value ? this.value : this.defaultValue
            );
        }
    }
};
</script>
