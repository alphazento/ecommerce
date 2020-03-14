<template>
    <div v-html="source"></div>
</template>

<script>
export default {
    props: {
        source: String
    }
};
</script>
