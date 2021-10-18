import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import vueAxios from 'vue-axios'

import NormalizeSCSS from './assets/scss/normalize.scss'
import SupportSCSS from './assets/scss/support.scss'
import VarsSCSS from './assets/scss/vars.scss'

const app = createApp(App)

app
    // Modules
    .use(store).use(router).use(vueAxios, axios)
    // Styles
    .use(NormalizeSCSS).use(SupportSCSS).use(VarsSCSS)
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