import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import vueAxios from 'vue-axios'

const app = createApp(App)

app
    // Modules
    .use(store).use(router).use(vueAxios, axios)
    // Mount
    .mount('#app')

// Check authorization at some routes
router.afterEach(to => {
    store.dispatch('checkToken').then(response => {
        ['/login', '/register'].includes(to.path)
            ? response && router.push('/')
            : !response && router.push('/login')
    })

})

// Set baseURL for api requests
app.axios.defaults.baseURL = 'http://api.localhost/'