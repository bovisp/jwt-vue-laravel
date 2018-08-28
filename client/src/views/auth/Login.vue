<template>
    <section class="container mx-auto pt-8 flex justify-center">
        <div class="w-1/2 shadow-md p-8">
            <h2 class="text-grey-darker mb-4 pb-2 border-grey-light border-solid border-b">
                Login
            </h2>

            <!-- Begin overall error message -->

            <div class="alert alert-danger" v-if="(clientError || serverError) && !success">
                <p>There was an error, unable to sign in with those credentials.</p>
            </div>

            <!-- End overall error message -->

            <form autocomplete="off" @submit.prevent="login">

                <!-- Begin 'email' field -->

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
                
                <!-- Begin 'password' field -->

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

                <!-- End 'password' field -->

                <div class="flex items-center">
                    <button 
                        type="submit" 
                        class="button button-primary"
                        formnovalidate
                    >Submit</button>

                    <router-link 
                        :to="{ name: 'forgotpassword' }" 
                        class="ml-auto no-underline"
                    >Forgot password</router-link>
                </div>
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
                    email: '',
                    password: ''
                },
                success: true
            }
        }, 

        validations: {
            form: {
                email: {
                    required,
                    email
                },
                password: {
                    required
                }
            }
        },

        methods: {
            login () {
                if (this.$v.$invalid) {
                    this.clientError = true
                    this.serverError = false
                    this.success = false
                } else {
                    this.clientError = false
                    this.serverError = false

                    this.$auth.login({
                        params: this.form,
                        success: function () {
                            this.success = true
                        },
                        error: function (resp) {},
                        rememberMe: true,
                        redirect: '/dashboard',
                        fetchUser: true,
                    })
                    .catch(error => {
                        this.serverError = true
                        this.success = false

                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors
                        }
                    });    
                }
            }           
        },

        mounted () {
            window.events.$on('error:400', () => {
                this.serverError = true
                this.success = false
            })
        }
    } 
</script>