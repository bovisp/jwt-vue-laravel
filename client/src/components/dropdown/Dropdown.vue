<template>
  <div class="relative" v-on-clickaway="close">
    <slot name="button"></slot>

    <slot name="menu"></slot>
  </div>
</template>

<script>
	import { mixin as clickaway } from 'vue-clickaway'

	export default {
		mixins: [ clickaway ],

		methods: {
			close () {
				window.events.$emit('dropdown:close')
			}
		}
	}
</script>