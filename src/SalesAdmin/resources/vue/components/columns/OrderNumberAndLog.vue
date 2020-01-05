<template>
  <div>
    <div>
      <span class="subtitle-1">{{ value }}</span>
      <span>(ID:{{extraData.id}})</span>
    </div>
    <div class="buttons-container">
      <v-btn icon color="error" @click="openCommentDialog">
        <v-icon>mdi-plus-circle</v-icon>Add Note
      </v-btn>
      <v-btn text color="primary">Logs</v-btn>
    </div>
    <div v-if="extraData.admin_comments.length > 0" class="note-container">
      <div v-for="(item) of extraData.admin_comments" :key="item.id">
        <div>
          <span v-if="item.administrator">{{item.administrator.email}}</span>
          <span v-else>Unknow</span>
          <span>{{item.updated_at}}</span>
        </div>
        <div v-html="item.comment"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: String,
    extraData: {
      id: "",
      admin_comments: []
    }
  },
  methods: {
    openCommentDialog() {
      eventBus.$emit("openDialog", {
        component: "z-admin-comment-dialog-body",
        bind: { title: "Add Admin Note" },
        closeNotify: this.handleDialogClose
      });
    },
    handleDialogClose(data) {
      if (data.success) {
        axios.post("/api/v1/admin/sales/notes", {
          order_id: this.extraData.id,
          comment: data.comment,
          notify: data.notifyCustomer
        });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.buttons-container {
  min-width: 200px;
  .v-btn {
    min-width: 90px;
  }
}

.note-container {
  min-width: 300px;
  max-width: 400px;
  max-height: 80px;
  overflow-y: scroll;
}
</style>
