<template>
    <v-pagination circle :length="searchResult.last_page" v-model="page" :total-visible="7"></v-pagination>
</template>

<script>

export default {
    data() {
        return {
            page: this.$store.state.searchResult.current_page
        };
    },
   
    computed: {
        searchResult() {
            return this.$store.state.searchResult;
        }
    },
    watch: {
        page: function(val, oldVal) {
            this.$store.dispatch('updatePagination', {page:val});
        }
    }
};
</script>
