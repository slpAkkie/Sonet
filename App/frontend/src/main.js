import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import vueAxios from 'vue-axios'

const app = createApp(App)

// Set baseURL for API requests
axios.defaults.baseURL = 'http://api.localhost/'
axios.interceptors.response.use(response => response, error => {
    if (error.response.data.code === 401)
        store
            .dispatch('removeUser')
            .then(async () => {
                await app._instance.proxy.setLayout('auth')
            })

    return Promise.reject(error)
})

// Check authorization after each route change
router.afterEach(async to => {
    if (['/login', '/register'].includes(to.path) && store.getters.isUser) await app._instance.proxy.setLayout('main')
    else if (!['/login', '/register'].includes(to.path) && !store.getters.isUser) await app._instance.proxy.setLayout('auth')
})

app
    // Plugins
    .use(store).use(router).use(vueAxios, axios)
    // Mounting
    .mount('#app')
