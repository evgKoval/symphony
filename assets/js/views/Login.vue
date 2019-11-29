<template>
    <div>
        <b-form @submit="onSubmit">
        <h1 class="mb-4">Login</h1>
        <b-form-group
        id="label-email"
        label="Email address:"
        label-for="input-email"
        description="We'll never share your email with anyone else."
        >
        <b-form-input
            id="input-email"
            v-model="form.email"
            type="text"
            required
            placeholder="Enter email"
        ></b-form-input>
        <b-form-invalid-feedback :state="validation.email">
                This field must be filled
        </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group id="label-password" label="Your password:" label-for="input-password">
        <b-form-input
            id="input-password"
            v-model="form.password"
            type="password"
            required
            placeholder="Enter password"
        ></b-form-input>
        <b-form-invalid-feedback :state="validation.password">
            This field length must equal 6 or more symbols
        </b-form-invalid-feedback>
        </b-form-group>

        <b-button type="submit" variant="primary" block>Login</b-button>
        </b-form>
        
        <b-alert :show="loginFailed" variant="danger">
            Cannot login with this login and password
        </b-alert>
    </div>
</template>

<script>
export default {
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
        loginFailed: false
      }
    },
    computed: {
        validation() {
            return {
                email: this.form.email != '',
                password: this.form.password.length > 5
            }
        }
    },
    methods: {
      onSubmit(evt) {
        evt.preventDefault();

        if(this.validation.email == true && this.validation.password == true) {
            const form = new FormData();

            form.set('email', this.form.email);
            form.set('password', this.form.password);
            
            this.$store.dispatch('login', form)
                .then(() => this.$router.push({ name: 'home' }))
                .catch(() => this.loginFailed = true)
        }
      }
    }
}
</script>

<style>
</style>