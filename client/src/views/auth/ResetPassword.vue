<template>
	<section class="container mx-auto pt-8 flex justify-center">
        <div class="w-1/2 shadow-md p-8">
            <h2 class="text-grey-darker mb-4 pb-2 border-grey-light border-solid border-b">
                Reset password
            </h2>

            <!-- Begin overall success message -->

            <div class="alert alert-success" v-if="success">
                <p>
                	Your password has been reset! You can now <router-link :to="{ name:'login' }">sign in.</router-link>
                </p>
            </div>

            <!-- End overall success message -->

            <!-- Begin overall error message -->

            <div class="alert alert-danger" v-if="serverError && anyError('invalid')">
                <p>
                	{{ errors.invalid }}
                </p>
            </div>

            <!-- End overall error message -->
			
            <p class="mb-4" v-if="!success">
            	Type your new password below.
            </p>

            <form autocomplete="off" @submit.prevent="resetPassword" v-if="!success">
				<div class="mb-4">
                    <label class="label" for="password">Password</label>

                    <input 
                        type="password" 
                        id="password" 
                        class="input" 
                        :class="{ 'border-red-dark': anyError('password') }" 
                        v-model="$v.form.password.$model"
                    >

                    <!-- Server errors -->
                    <div class="help help-danger" v-if="serverError && anyError('password')">
                        {{ errors.password[0] }}
                    </div>
                    
                    <!-- Client errors -->
                    <div class="help help-danger" v-if="clientError && anyError('password')">
                        The "Password" field is required
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
	import { required } from 'vuelidate/lib/validators'

	export default {
        data () {
            return {
                form: {
                    password: ''
                },
                success: false
            }
        }, 

        validations: {
            form: {
                password: {
                    required
                }
            }
        },

        methods: {
        	resetPassword () {
        		if (this.$v.$invalid) {
                    this.clientError = true
                    this.serverError = false
                } else {
                	this.axios.post(`/auth/resetpassword/${this.$route.params.token}`, this.form)
                		.then(({data}) => {
                			this.success = true
                			this.serverError = false
                			this.errors = {}
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