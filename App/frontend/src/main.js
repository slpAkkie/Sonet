import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios';
import vueAxios from 'vue-axios'

const app = createApp(App)

app.use(store).use(router).use(vueAxios, axios).mount('#app')
app.axios.defaults.baseURL = 'http://api.localhost/'