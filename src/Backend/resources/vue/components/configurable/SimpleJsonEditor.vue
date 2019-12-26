<template>
    <component
        v-if="components['metanode']"
        :is="components['ui']"
        v-bind="components"
        @valueChanged="metaValueChanged"
    >
    </component>
    <v-container v-else-if="isObject(components)">
        <v-layout
            v-for="(element, name) of components"
            :key="name"
            :class="`group-level-${level}`"
        >
            <v-flex md3>
                <v-btn
                    icon
                    v-if="Array.isArray(element)"
                    @click="addArrayItem(name)"
                >
                    <v-icon color="error">mdi-plus-circle</v-icon>
                </v-btn>
                <span>{{ name }}:</span>
            </v-flex>
            <v-flex md9>
                <simple-json-item
                    :components="element"
                    :level="1 + level"
                    :belongs="name"
                    @removeArrayItem="removeArrayItem"
                    @jsonItemChanged="jsonItemChanged"
                >
                </simple-json-item>
            </v-flex>
        </v-layout>
    </v-container>
    <v-container v-else>
        <v-layout
            v-for="(element, i) of components"
            :key="i"
            class="group-bound"
        >
            <v-btn icon @click="removeArrayItem(belongs, i)">
                <v-icon color="error">mdi-minus-circle</v-icon>
            </v-btn>
            <simple-json-item
                :components="element"
                :level="1 + level"
                :arrayIdx="i"
                :belongs="belongs"
                @removeArrayItem="removeArrayItem"
                @jsonItemChanged="jsonItemChanged"
            >
            </simple-json-item>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    props: {
        components: {
            type: String | Object | Array | Number | Boolean
        },
        level: Number,
        belongs: String,
        arrayIdx: Number
    },
    methods: {
        isObject(obj) {
            return Object.prototype.toString.call(obj) === "[object Object]";
        },
        addArrayItem(name) {
            this.$emit("addArrayItem", name);
        },
        removeArrayItem(name, i) {
            if (this.isObject(name)) {
                this.$emit("removeArrayItem", name);
            } else {
                this.$emit("removeArrayItem", { name: name, i: i });
            }
        },
        metaValueChanged(item) {
            let data = {};
            data[item.accessor] = item.value;
            this.$emit("jsonItemChanged", { meta: data });
        },
        jsonItemChanged(data) {
            if (this.belongs !== undefined) {
                data.key = this.belongs;
            }
            if (this.arrayIdx !== undefined) {
                data.arrayIdx = this.arrayIdx;
            }
            this.$emit("jsonItemChanged", data);
        }
    }
};
</script>

<style lang="scss">
.group-bound {
    border: 2px solid gray;
    margin-top: 3px;
    background-color: #acafec4f;
    .group-level-2,
    .group-level-3 {
        background-color: #acafec4f;
        border: unset !important;
    }
}

.group-level-2,
.group-level-3 {
    background-color: #20b5fb4f;
}
</style>
