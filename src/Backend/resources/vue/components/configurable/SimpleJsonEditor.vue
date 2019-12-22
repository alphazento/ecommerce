<template>
    <div v-if="components['metanode']">
        <v-flex>
            <component :is="components['ui']" v-bind="components"> </component>
        </v-flex>
    </div>
    <v-container v-else-if="isObject(components)">
        <v-layout v-for="(element, name) of components" :key="name">
            <v-flex md4>
                <v-btn icon v-if="Array.isArray(element)">
                    <v-icon color="error">mdi-plus-circle</v-icon>
                </v-btn>
                {{ name }}:
            </v-flex>
            <v-flex md8>
                <simple-json-item :components="element"> </simple-json-item>
            </v-flex>
        </v-layout>
    </v-container>
    <v-layout v-else>
        <div v-for="(element, i) of components" :key="i">
            <simple-json-item :components="element"> </simple-json-item>
        </div>
    </v-layout>
</template>

<script>
export default {
    props: {
        components: {
            type: String | Object | Array | Number | Boolean
        }
    },
    methods: {
        isObject(obj) {
            return Object.prototype.toString.call(obj) === "[object Object]";
        }
    }
};
</script>
