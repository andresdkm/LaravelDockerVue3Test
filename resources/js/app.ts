import { createApp } from "vue";
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import * as Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

import App from "./pages/App.vue";
const app = createApp({
    components: {
        App,
    },
});
app.use(VueAxios, axios)
app.use(ElementPlus)
app.mount("#app");
