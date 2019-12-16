<template>
    <v-container text-center class="sns__container">
        <v-btn
            v-for="(item, i) in configs"
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
        let configs = {};
        this.configs.forEach(item => {
            configs[item.service] = item.client_id;
        });
        hello.init(configs, {
            redirect_uri: "/login/hellojs/callback",
            response_type: "code"
        });
    },
    computed: {
        configs() {
            let configs = this.$store.state.consts.hellosns;
            if (configs === undefined) {
                configs = {};
            }

            return configs.filter(item => {
                return item.active;
            });
        }
    },
    methods: {
        login(network) {
            let provider = hello(network);
            provider.login().then(
                response => {
                    console.log(response);
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
