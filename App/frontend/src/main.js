import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import vueAxios from 'vue-axios'

// Set baseURL for API requests
axios.defaults.baseURL = 'http://api.localhost/'

// Check authorization after each route change
router.afterEach(async to => {
    if (['/login', '/register'].includes(to.path) && store.getters.isUser) await router.push('/')
    else if (!['/login', '/register'].includes(to.path) && !store.getters.isUser) await router.push('/login')
})

createApp(App)
    // Plugins
    .use(store).use(router).use(vueAxios, axios)
    // Mounting
    .mount('#app')
