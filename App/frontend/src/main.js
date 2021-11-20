import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import vueAxios from 'vue-axios'

const app = createApp(App)

// Set baseURL for API requests
axios.defaults.baseURL = '//api.localhost/sonet/'
axios.interceptors.response.use(response => response, async error => {
    if (error.response.data.code === 401) {
        await store.dispatch('removeUser')
        router.go(0)
    }

    return Promise.reject(error)
})

app
    // Plugins
    .use(store).use(router).use(vueAxios, axios)
    // Mounting
    .mount('#app')
