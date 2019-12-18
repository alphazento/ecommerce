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
            let services = this.$store.state.consts.hellosns.services;
            if (services === undefined) {
                services = {};
            }

            return services.filter(item => {
                return item.active;
            });
        },
        options() {
            return this.$store.state.consts.hellosns.options;
        }
    },
    methods: {
        login(network) {
            let provider = hello(network);
            provider.login().then(
                response => {
                    console.log('l1', response);
                    axios.post('/api/v1/hellosns/connect', response).then(resp => {
                        console.log('l1', resp);
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
