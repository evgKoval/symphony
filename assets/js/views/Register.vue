<template>
	<div>
		<b-form @submit="onSubmit">
		<h1 class="mb-4">Register</h1>
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
			placeholder="Enter password"
		></b-form-input>
		<b-form-invalid-feedback :state="validation.password">
            This field length must equal 6 or more symbols
        </b-form-invalid-feedback>
		</b-form-group>

		<b-button type="submit" variant="primary" block>Register</b-button>
		</b-form>

		<b-alert :show="registerFailed" variant="danger">
			Cannot register
		</b-alert>
		<b-alert :show="registered" variant="success">
			User has registered. You will redirect to login page in 5 seconds
		</b-alert>
	</div>
</template>

<script>
export default {
	data() {
	  return {
	    form: {
          email: '',
          password: ''
		},
		registerFailed: false,
		registered: false
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
		evt.preventDefault()

		if(this.validation.email == true && this.validation.password == true) {
			const form = new FormData();

			form.set('email', this.form.email);
			form.set('password', this.form.password);

			this.$store.dispatch('register', form)
				.then(() => {
					this.registered = true;
					setTimeout(() => {
						this.$router.push({ name: 'login' })
					}, 5000)
				})
				.catch(() => this.registerFailed = true)}
		}
	}
}
</script>

<style>
</style>