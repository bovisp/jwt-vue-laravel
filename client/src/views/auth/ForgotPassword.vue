<template>
	<section class="container mx-auto pt-8 flex justify-center">
        <div class="w-1/2 shadow-md p-8">
            <h2 class="text-grey-darker mb-4 pb-2 border-grey-light border-solid border-b">
                Forgot your password?
            </h2>

            <!-- Begin overall success message -->

            <div class="alert alert-success" v-if="success">
                <p>Thanks! You will receive an email from us shortly.</p>
            </div>

            <!-- End overall success message -->
			
            <p class="mb-4" v-if="!success">
            	No problem! Just enter the email address that you used to register and we'll send you an email with instructions on how to reset it.
            </p>

            <form autocomplete="off" @submit.prevent="reset" v-if="!success">
				<div class="mb-4">
                    <label class="label" for="email">E-mail</label>

                    <input 
                        type="email" 
                        id="email" 
                        class="input" 
                        :class="{ 'border-red-dark': anyError('email') }" 
                        v-model="$v.form.email.$model"
                    >

                    <!-- Server errors -->
                    <div class="help help-danger" v-if="serverError && anyError('email')">
                        {{ errors.email[0] }}
                    </div>
                    
                    <!-- Client errors -->
                    <div class="help help-danger" v-if="clientError && anyError('email')">
                        The "Email" field is required
                    </div>

                    <div class="help help-danger" v-if="clientError && anyError('email')">
                        This is not a valid email address
                    </div>
                </div>

                <!-- End 'email' field -->
                
   				<button 
                    type="submit" 
                    class="button button-primary"
                    formnovalidate
                >Submit</button>
            </form>
        </div>
    </section>
</template>

<script>
	import { required, email } from 'vuelidate/lib/validators'

	export default {
        data () {
            return {
                form: {
                    email: ''
                },
                success: false
            }
        }, 

        validations: {
            form: {
                email: {
                    required,
                    email
                }
            }
        },

        methods: {
        	reset () {
        		if (this.$v.$invalid) {
                    this.clientError = true
                    this.serverError = false
                } else {
                	this.axios.post('/auth/forgotpassword', this.form)
                		.then(({data}) => {
                			this.success = true
                		})
                		.catch(error => {
                			this.serverError = true
                            this.errors = error.response.data.errors
                		})
                }
        	}
        }
    }
</script>