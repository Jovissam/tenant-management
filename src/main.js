import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import BaseLoader from './components/ui/BaseLoader.vue'

import 'bootstrap/dist/css/bootstrap.min.css'
// import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import './assets/css/style.css'

const app = createApp(App)

app.component('base-loader', BaseLoader)
app.use(router)
app.use(store)

app.mount('#app')
