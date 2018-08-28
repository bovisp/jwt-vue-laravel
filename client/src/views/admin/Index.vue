<template>
	<form @submit.prevent="submit">
		<div>
			<label for="name">Name</label>
			<input type="text" v-model="name" id="name">
		</div>

		<div>
			<label for="email">Email</label>
			<input type="email" v-model="email" id="email">
		</div>

		<button type="submit">Submit</button>

		{{$auth.user()}}
	</form>
</template>

<script>
	export default {
		data () {
			return {
				name: '',
				email: ''
			}
		},

		methods: {
			submit () {
				this.axios.post('/manager', {
					name: this.name,
					email: this.email
				})
					.then(response => console.log(response))
					.catch(error => console.log(error.response))
			}
		}
	}
</script>