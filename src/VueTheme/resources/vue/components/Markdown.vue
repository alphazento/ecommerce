<template>
    <vue-markdown :source="source"></vue-markdown>
</template>

<script>
import VueMarkdown from "vue-markdown";

export default {
    components: { VueMarkdown },
    props: {
        source: String
    }
};
</script>
