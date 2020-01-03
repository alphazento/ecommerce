<template>
  <v-dialog persistent v-model="show" max-width="960" >
        <component v-if="component !== null" :is="component" v-bind="bind" @close="close">
        </component>
  </v-dialog>
</template>

<script>
const closeDoNothing =  () => {};
export default {
    data() {
      return {
        show: false,
        component: null,
        bind: {},
        close: closeDoNothing
      }
    },
    created() {
      eventBus.$on('openDialog', data => {
        this.show = true;
        this.component = data.component;
        this.bind = data.bind;
        if (data.closeNotify) {
          this.close = data.closeNotify;
        }
      });
      eventBus.$on('closeDialog', () => {
        this.show = false;
        this.close = closeDoNothing
      });
    }
}
</script>
