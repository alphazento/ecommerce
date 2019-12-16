<template>
    <v-card class="elevation-12">
        <v-container>
            <v-toolbar flat color="#F2F2F2">
                <v-toolbar-title class="display-1">
                    {{ title() }}
                </v-toolbar-title>
                <v-spacer />
                <v-tooltip right v-if="isDialog">
                    <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" @click="disgard">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                    <span>Close</span>
                </v-tooltip>
            </v-toolbar>
            <v-card-text>
                <p v-if="!!errorMessage" class="subtitle-1 red--text">
                    {{ errorMessage }}
                </p>
                <v-form v-if="mode === 'signin'" ref="signin_form">
                    <v-text-field
                        v-model="email"
                        label="Email"
                        name="email"
                        prepend-icon="mdi-account"
                        type="text"
                        :rules="[rules.clear, rules.required, rules.email]"
                    />
                    <v-text-field
                        v-model="password"
                        prepend-icon="mdi-lock"
                        :append-icon="showPasswd ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.clear, rules.required, rules.min]"
                        :type="showPasswd ? 'text' : 'password'"
                        name="password"
                        label="Password"
                        hint="At least 8 characters"
                        counter
                        @click:append="showPasswd = !showPasswd"
                    ></v-text-field>
                    <v-layout>
                        <v-flex md6 class="v-middle no-padding">
                            <v-checkbox
                                v-model="remember_me"
                                label="Remember me"
                            ></v-checkbox>
                        </v-flex>
                        <v-flex md6 class="v-middle no-padding">
                            <a
                                class="no-padding no-margin"
                                @click="changeMode('reset-passwd', $event)"
                            >
                                Forgot your password?
                            </a>
                        </v-flex>
                    </v-layout>
                </v-form>
                <v-form v-if="mode === 'signup'" ref="signup_form">
                    <v-text-field
                        v-model="email"
                        label="Email"
                        name="email"
                        type="text"
                        :rules="[rules.clear, rules.required, rules.email]"
                    />
                    <v-text-field
                        v-model="fullname"
                        label="Fullname"
                        name="fullname"
                        type="text"
                        hint="Maximum 128 characters"
                        counter
                        :rules="[rules.clear, rules.required, rules.max]"
                    />
                    <v-text-field
                        v-model="password"
                        :append-icon="showPasswd ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.clear, rules.required, rules.min]"
                        :type="showPasswd ? 'text' : 'password'"
                        name="password"
                        label="Password"
                        hint="At least 8 characters"
                        counter
                        @click:append="showPasswd = !showPasswd"
                    ></v-text-field>
                    <v-text-field
                        v-model="confirm_password"
                        :append-icon="showPasswd ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.clear, rules.passwordMatch]"
                        :type="showPasswd ? 'text' : 'password'"
                        name="confirm_password"
                        label="Confirm Password"
                        hint="At least 8 characters"
                        counter
                        @click:append="showPasswd = !showPasswd"
                    ></v-text-field>
                </v-form>
                <v-form v-if="mode === 'reset-passwd'" ref="reset_passwd_form">
                    <p class="title">
                        Enter your email to receive reset password link.
                    </p>
                    <v-text-field
                        v-model="email"
                        label="Email"
                        name="email"
                        prepend-icon="mdi-account"
                        type="text"
                        :rules="[rules.clear, rules.required, rules.email]"
                    />
                </v-form>
                <div v-if="mode === 'reset-passwd-success'">
                    <p class="title">
                        We have e-mailed your password reset link! Please follow
                        the instruction from the email to reset password.
                    </p>
                </div>
            </v-card-text>

            <v-card-actions>
                <v-container text-center class="no-padding">
                    <v-layout row>
                        <v-flex md12>
                            <v-btn
                                class="btn__full"
                                large
                                color="primary"
                                @click="submit"
                                >{{ btnText() }}</v-btn
                            >
                        </v-flex>
                    </v-layout>
                    <v-layout v-if="mode !== 'reset-passwd-success'">
                        <v-flex md12>
                            <a
                                v-if="mode === 'signin'"
                                @click="changeMode('signup')"
                            >
                                Create a new account
                            </a>
                            <a
                                v-if="mode !== 'signin'"
                                @click="changeMode('signin')"
                            >
                                Login with an existing account
                            </a>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-actions>
            <slot></slot>
        </v-container>
    </v-card>
</template>

<script>
export default {
    props: {
        workMode: {
            type: String
        },
        isDialog: {
            type: Boolean
        }
    },
    data() {
        return {
            mode: this.workMode,
            showPasswd: false,
            email: "",
            fullname: "",
            password: "",
            confirm_password: "",
            remember_me: false,
            errorMessage: "",
            rules: {
                clear: v => (this.errorMessage = "") || true,
                required: value => !!value || "Required Field.",
                min: v => (v && v.length >= 8) || "Min 8 characters",
                max: v => (v && v.length <= 128) || "Max 128 characters",
                // emailMatch: () => ('The email and password you entered don\'t match'),
                email: v => /.+@.+\..+/.test(v) || "E-mail must be valid",
                passwordMatch: v =>
                    v == this.password ||
                    "Password and Confirm password not match."
            }
        };
    },
    methods: {
        disgard(restore) {
            this.$emit("disgard", true);
            this.mode = this.workMode; //restore to orgin mode
        },
        login() {
            this.$store.dispatch("showSpinner", "Logging in...");
            axios
                .post("/login", {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    if (response.data.success) {
                        window.location.reload();
                    } else {
                        this.errorMessage = response.data.message;
                        this.$store.dispatch("hideSpinner");
                    }
                });
        },
        register() {
            this.$store.dispatch("showSpinner", "Creating account...");
            axios
                .post("/register", {
                    email: this.email,
                    name: this.fullname,
                    password: this.password,
                    password_confirmation: this.confirm_password
                })
                .then(response => {
                    if (response.data.success) {
                        window.location.reload();
                    } else {
                        this.errorMessage = response.data.message;
                        this.$store.dispatch("hideSpinner");
                    }
                });
        },
        resetPasswd() {
            this.$store.dispatch("showSpinner", "Requesting...");
            axios
                .post("/password/email", {
                    email: this.email
                })
                .then(response => {
                    this.$store.dispatch("hideSpinner");
                    if (response.data.success) {
                        this.mode = "reset-passwd-success";
                    } else {
                        this.errorMessage = response.data.message;
                    }
                });
        },
        submit() {
            switch (this.mode) {
                case "signin":
                    if (this.$refs.signin_form.validate()) {
                        this.login();
                    }
                    break;
                case "signup":
                    if (this.$refs.signup_form.validate()) {
                        this.register();
                    }
                    break;
                case "reset-passwd":
                    if (this.$refs.reset_passwd_form.validate()) {
                        this.resetPasswd();
                    }
                    break;
                case "reset-passwd-success":
                    this.mode = "signin";
                    break;
            }
        },
        title() {
            switch (this.mode) {
                case "signin":
                    return "Sign In";
                case "signup":
                    return "Sign Up";
                case "reset-passwd":
                case "reset-passwd-success":
                    return "Reset Password";
            }
            return "";
        },
        btnText() {
            switch (this.mode) {
                case "signin":
                    return "Log In";
                case "signup":
                    return "Register";
                case "reset-passwd":
                    return "Reset Password";
                case "reset-passwd-success":
                    return "Continue to Log in";
            }
            return "";
        },
        changeMode(newMode) {
            this.mode = newMode;
        }
    },
    watch: {
        workMode(newVal, oldValue) {
            this.mode = newVal;
        }
    }
};
</script>

<style lang="scss" scoped>
.btn__full {
    width: 80% !important;
    min-width: 250px !important;
}
.bigger-message_display {
    .v-messages__wrapper {
        font-size: 24px !important;
    }
}
</style>
