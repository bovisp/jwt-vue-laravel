<template>
    <section class="container mx-auto pt-8 flex justify-center">
        <div class="w-1/2 shadow-md p-8">
            <h2 class="text-grey-darker mb-4 pb-2 border-grey-light border-solid border-b">
                Register
            </h2>

            <!-- Begin overall error message -->

            <div class="alert alert-danger" v-if="(clientError || serverError) && !success">
                <p>There was an error, unable to complete registration.</p>
            </div>

            <!-- End overall error message -->

            <!-- Begin overall success message -->

            <div class="alert alert-success" v-if="success">
                <p>Registration completed. You can now <router-link :to="{name:'login'}">sign in.</router-link></p>
            </div>

            <!-- End overall success message -->

            <form 
                autocomplete="off" 
                @submit.prevent="register" 
                v-if="!success"
            >

                <!-- Begin 'name' field -->

                <div class="mb-4">
                    <label class="label" for="name">Name</label>

                    <input 
                        type="text" 
                        id="name" 
                        class="input" 
                        :class="{ 'border-red-dark': anyError('name') }" 
                        v-model="$v.form.name.$model"
                    >

                    <!-- Server errors -->
                    <div class="help help-danger" v-if="serverError && anyError('name')">
                        {{ getError('name') }}
                    </div>

                    <!-- Client errors -->
                    <div class="help help-danger" v-if="clientError && anyError('name')">
                        The "Name" field is required
                    </div>
                </div>

                <!-- End 'name' field -->

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
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: ''
                },
                success: false
            }
        },

        validations: {
            form: {
                name: {
                    required
                },
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
            register () {
                if (this.$v.$invalid) {
                    this.clientError = true
                    this.serverError = false
                    this.success = false
                } else {
                    this.clientError = false
                    this.serverError = false

                    this.$auth.register({
                        data: this.form, 
                        success: function () {
                            this.success = true
                        },
                        error: function (resp) {
                            this.serverError = true
                            this.errors = resp.response.data.errors
                        },
                        redirect: null
                    });  
                }              
            }
        }
    }
</script>