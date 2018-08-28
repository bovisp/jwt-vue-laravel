import Vue from 'vue'

import router from './router'
import store from './store'

import axios from 'axios'
import VueAxios from 'vue-axios'
import Vuelidate from 'vuelidate'
import Snotify from 'vue-snotify'

import App from './App.vue'

import Components from './mixins/components'
import Error from './mixins/error'

import './main.css'

Vue.use(VueAxios, axios)
Vue.use(Vuelidate)
Vue.use(Snotify)

Vue.mixin(Components)
Vue.mixin(Error)

window.events = new Vue()

axios.defaults.baseURL = 'http://codeburst.test/api'

axios.interceptors.response.use(
	response => {
		return response
	},
	error => {
		if (error.response.status === 403) {
			router.push('/403')
		}

		if (error.response.status === 400) {
			window.events.$emit('error:400')
		}

		return Promise.reject(error);
	}
)

Vue.config.productionTip = false

Vue.router = router
Vue.store = store

Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
})

App.router = Vue.router
App.store = Vue.store

new Vue(App).$mount('#app')