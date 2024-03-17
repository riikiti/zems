import './assets/main.scss'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import App from './App.vue'
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/reset.css';
import router from './router'

const app = createApp(App)
const pinia = createPinia().use(piniaPluginPersistedstate)
app.use(pinia)
app.use(router)
app.use(Antd).mount('#app');
