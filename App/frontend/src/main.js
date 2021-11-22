import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import vueAxios from 'vue-axios'

const app = createApp(App)

// Set baseURL for API requests
axios.defaults.baseURL = 'http://api.localhost/sonet/'

// Handle errors for all request
axios.interceptors.response.use(response => response, error => {
    // Authorization error (Api token incorrect)
    if (error.response.status === 401 && !store.state.logout) {
        store.dispatch('logout').finally(() => {
            router.push('/logout')
        })
    }

    return Promise.reject(error)
})

// Start application
app
    // Plugins
    .use(store).use(router).use(vueAxios, axios)
    // Mounting
    .mount('#app')
