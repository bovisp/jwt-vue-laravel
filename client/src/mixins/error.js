export default {
	data () {
		return {
			clientError: false,
            serverError: false,
            errors: {}
		}
	},

	methods: {
        anyError(field) {
            return (this.clientError && this.$v.form[field].$invalid) || (this.serverError && this.errors[field])
        }
	}
}