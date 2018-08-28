<template>
	<li>
		<a 
			href="#" 
			class="px-4 py-2 block text-black no-underline border-grey-light border-solid border-t hover:bg-grey-light"
			v-if="logout"
			@click.prevent="$auth.logout()"
		>
			<slot></slot>
		</a>

		<router-link 
			:to="to" 
			@click.native="close"
			class="px-4 py-2 block text-black no-underline hover:bg-grey-light"
			v-else
		>
			<slot></slot>
		</router-link>
	</li>
</template>

<script>
	export default {
		props: {
			logout: {
				type: Boolean,
				required: false,
				default: false
			},
			to: {
				type: String,
				required: false
			}
		},

		methods: {
			close () {
				window.events.$emit('dropdown:close')
			}
		}
	}
</script>