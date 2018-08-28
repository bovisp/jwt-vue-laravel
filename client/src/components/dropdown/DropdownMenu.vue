<template>
	<div 
		class="shadow-md absolute mt-16 pin-t pin-r w-48"
		:class="[ active ? 'block' : 'hidden' ]"
	>
        <ul class="list-reset">
        	<slot></slot>
        </ul>
    </div>
</template>

<script>
	export default {
		props: {
			dropdownId: {
				type: String,
				required: true
			}
		},

		data () {
			return {
				active: false
			}
		},

		mounted () {
			window.events.$on('dropdown:clicked', (id) => {
				if (this.dropdownId === id) {
					this.active = !this.active
				}
			})

			window.events.$on('dropdown:close', () => {
				this.active = false
			})
		}
	}
</script>