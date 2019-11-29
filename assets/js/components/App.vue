<template>
   	<div id="app">
		<b-navbar class="mb-4" toggleable="lg">
			<b-navbar-brand href="/">How many times did you sign in?</b-navbar-brand>

			<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

			<b-collapse id="nav-collapse" is-nav>

			<!-- Right aligned nav items -->
			<b-navbar-nav class="ml-auto">
				<template v-if="!user">
					<b-nav-item to="/login">Login</b-nav-item>
					<b-nav-item to="/register">Register</b-nav-item>
				</template>
				<template v-else>
					<h6>{{ user }}</h6>
					<b-nav-item @click="logout">Logout</b-nav-item>
				</template>
			</b-navbar-nav>
			</b-collapse>
		</b-navbar>
   		<div class="container">
   			<router-view></router-view>
   		</div>
   	</div>
</template>

<script>
export default {
	name: 'app',
	computed: {
		user() {
			return this.$store.getters.token;
		}
	},
	methods: {
		logout() {
			this.$store.commit('LOGOUT');
			this.$router.push({ name: 'login' });
		}
	},
	created() {
		this.$store.commit('CHECK_TOKEN');
	}
}
</script>

<style>
.navbar-nav {
	align-items: baseline;
}
</style>