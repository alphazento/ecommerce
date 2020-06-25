<template>
  <search-result-card :page-data="pageData">
    <template>
      <filters-card :page-data="pageData"></filters-card>
    </template>
  </search-result-card>
</template>

<script>
export default {
  props: {
    pageData: Object,
  },
};
</script>
