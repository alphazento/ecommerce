<template>
  <v-container text-center class="sns__container">
    <v-btn
      v-for="(item, i) in services"
      :key="i"
      @click="login(item.service)"
      :color="item.color"
      dark
    >
      <v-icon>{{ item.icon }}</v-icon>
      <span>{{ item.title }}</span>
    </v-btn>
  </v-container>
</template>

<script>
import hello from "hellojs";

export default {
  mounted() {
    let services = {};
    this.services.forEach(item => {
      services[item.service] = item.client_id;
    });
    hello.init(services, this.options);
  },
  computed: {
    services() {
      let services = appData.consts.hellosns.services;
      if (services === undefined) {
        services = {};
      }

      return services.filter(item => {
        return item.active;
      });
    },
    options() {
      return appData.consts.hellosns.options;
    }
  },
  methods: {
    login(network) {
      let provider = hello(network);
      provider.login().then(
        response => {
          this.$store.dispatch("showSpinner", "Authorization connecting ...");
          axios.post("/hellosns/connect", response).then(resp => {
            if (resp.data.success) {
              this.$store.dispatch("BIND_CUSTOMER", resp.data.data.user);
              // axios.defaults.headers.common['Authorization'] = resp.data.data.apiGuestToken;
              this.$store.dispatch(
                "showSpinner",
                "Welcome, " + resp.data.data.user.name
              );
              window.location.reload();
            } else {
              this.$store.dispatch("SNACK_MESSAGE", resp.data.message);
            }
          });
        },
        e => {
          console.error(e);
        }
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.sns__container {
  display: grid;
  .v-btn {
    margin-top: 5px;
  }
}
</style>
