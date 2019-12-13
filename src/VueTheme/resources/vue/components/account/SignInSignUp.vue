<template>
    <v-card class="elevation-12" >
      <v-form v-if="!isSignUpMode">
        <v-toolbar flat>
          <v-toolbar-title>Sign In</v-toolbar-title>
          <v-spacer />
          <v-tooltip right>
            <template v-slot:activator="{ on }">
              <div>
                <span left>or</span>
                <v-btn
                  icon
                  v-on="on"
                  @click="isSignUpMode = !isSignUpMode"
                >
                  <v-icon>mdi-account-plus</v-icon>
                </v-btn>
              </div>
            </template>
            <span>New to Alphazento?</span>
          </v-tooltip>
        </v-toolbar>
        <v-card-text>
          <v-form>
            <v-text-field
              label="Email"
              name="email"
              prepend-icon="mdi-account"
              type="text"
              :rules="[rules.email, rules.required]"
            />
            <v-text-field
                v-model="password"
                prepend-icon="mdi-lock"
                :append-icon="showPasswd ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min]"
                :type="showPasswd ? 'text' : 'password'"
                name="password"
                label="Password"
                hint="At least 8 characters"
                counter
                @click:append="showPasswd = !showPasswd"
              ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="primary">Login</v-btn>
        </v-card-actions>
      </v-form>

      <v-form v-if="isSignUpMode">
        <v-toolbar flat>
          <v-toolbar-title>Sign Up</v-toolbar-title>
          <v-spacer />
          <v-tooltip right>
            <template v-slot:activator="{ on }">
              <div>
                <span left>or</span>
                <v-btn
                  icon
                  v-on="on"
                  @click="isSignUpMode = !isSignUpMode"
                >
                  <v-icon>mdi-account</v-icon>
                </v-btn>
              </div>
            </template>
            <span>Sign in to an existing account</span>
          </v-tooltip>
        </v-toolbar>
        <v-card-text>
          <v-form>
            <v-text-field
              label="Email"
              name="email"
              type="text"
              :rules="[rules.email, rules.required]"
            />
            <v-text-field
              label="Fullname"
              name="fullname"
              type="text"
              :rules="[rules.required, rules.max]"
            />
            <v-text-field
                v-model="password"
                :append-icon="showPasswd ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min]"
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
                :rules="[rules.passwordMatch]"
                :type="showPasswd ? 'text' : 'password'"
                name="confirm_password"
                label="Confirm Password"
                hint="At least 8 characters"
                counter
                @click:append="showPasswd = !showPasswd"
              ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="primary">Sign Up</v-btn>
        </v-card-actions>
      </v-form>
      <v-container>
        <slot></slot>
      </v-container>
    </v-card>
</template>

<script>
  export default {
    props: {
      isSignUp: {
        type: Boolean
      }
    },
    data() {
      return {
        isSignUpMode: this.isSignUp,
        showPasswd: false,
        password: '',
        confirm_password: '',
        rules: {
          required: value => !!value || 'Required Field.',
          min: v => (v && v.length >= 8) || 'Min 8 characters',
          max: v => (v && v.length >= 128) || 'Max 128 characters',
          // emailMatch: () => ('The email and password you entered don\'t match'),
          email: v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
          passwordMatch: v => v == this.password || 'Password and Confirm password not match.'
        },
      };
    }
  }
</script>