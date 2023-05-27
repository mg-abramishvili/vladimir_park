import './bootstrap'

import { createApp } from 'vue'
import router from './admin-router'

import App from './components/admin/App.vue'

import Loader from './components/admin/Loader.vue'

// SweetAlerts
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import moment from 'moment'

const app = createApp(App).component('Loader', Loader).use(router).use(VueSweetalert2)

app.config.globalProperties.$filters = {
    datetime(date) {
        return moment.utc(date).utcOffset(3).format('DD.MM.YYYY H:mm')
    },
    date(date) {
        return moment.utc(date).utcOffset(3).format('DD.MM.YYYY')
    },
}

app.mount('#admin')