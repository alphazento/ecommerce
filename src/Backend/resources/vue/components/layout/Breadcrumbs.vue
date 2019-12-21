<template>
    <v-breadcrumbs :items="items" :divider="divider">
        <template v-slot:item="props">
            <router-link
                :to="props.item.href"
                :class="[props.item.disabled && 'disabled']"
            >
                {{ props.item.text }}
            </router-link>
        </template>
    </v-breadcrumbs>
</template>

<script>
export default {
    props: {
        divider: {
            type: String
        }
    },

    computed: {
        items() {
            return this.$store.state.breadcrumbs;
        }
    }
};
</script>
