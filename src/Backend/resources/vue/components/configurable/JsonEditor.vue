<template>
    <simple-json-item
        :components="components"
        :level="1"
        @addArrayItem="addArrayItem"
        @removeArrayItem="removeArrayItem"
        @jsonItemChanged="jsonItemChanged"
    >
    </simple-json-item>
</template>

<script>
import BaseConfig from "./Base";
export default {
    extends: BaseConfig,
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
            json: {},
            components: {}
        };
    },
    mounted() {
        this.is_json = true;
        this.json = this.convertValueToJson(this.value, this.schema);
        this.components = this.convertToComponentArray(this.json, this.schema);
    },
    methods: {
        isObject(obj) {
            return Object.prototype.toString.call(obj) === "[object Object]";
        },
        convertValueToJson(json, schema) {
            if (!json) {
                json = JSON.parse(JSON.stringify(schema));
            }
            if (!this.isObject(json)) {
                json = JSON.parse(json);
            }
            return json;
        },
        convertToComponentArray(json, schema) {
            json = this.convertValueToJson(json, schema);
            let components = {};
            for (const [key, value] of Object.entries(json)) {
                if (this.isObject(value)) {
                    components[key] = this.convertToComponentArray(
                        value,
                        schema[key]
                    );
                } else {
                    if (Array.isArray(value)) {
                        components[key] = [];
                        for (var i = 0; i < value.length; i++) {
                            var element = value[i];
                            components[key].push(
                                this.convertToComponentArray(
                                    element,
                                    schema[key][0]
                                )
                            );
                        }
                    } else {
                        components[key] = {
                            text: key,
                            ui: schema[key],
                            value: value,
                            accessor: key,
                            metanode: true
                        };
                    }
                }
            }
            return components;
        },

        canAddItem(name) {
            return true;
        },

        canRemoveItem(name) {
            return true;
        },
        addArrayItem(name) {
            let schemas = JSON.parse(JSON.stringify(this.schema[name]));
            this.json[name].push(schemas[0]);
            this.components = this.convertToComponentArray(
                this.json,
                this.schema
            );
        },
        removeArrayItem(item) {
            this.json[item.name].splice(item.i, 1);
            this.components[item.name].splice(item.i, 1);
        },
        jsonItemChanged(item) {
            if (item.key === undefined) {
                if (item.arrayIdx === undefined) {
                    Object.assign(this.json, item.meta);
                } else {
                    Object.assign(this.json[item.arrayIdx], item.meta);
                }
            } else {
                if (item.arrayIdx === undefined) {
                    Object.assign(this.json[item.key], item.meta);
                } else {
                    Object.assign(
                        this.json[item.key][item.arrayIdx],
                        item.meta
                    );
                }
            }
            this.innerValue = JSON.stringify(this.json);
            this.valueChanged();
        }
    },
    watch: {
        value() {
            this.json = this.convertValueToJson(this.value, this.schema);
            this.components = this.convertToComponentArray(
                this.json,
                this.schema
            );
        }
    }
};
</script>
