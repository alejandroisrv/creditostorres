
require('./bootstrap');
window.Vue = require('vue');
import routes from './routes.js';
import main from './components/main.vue'
import navbar from './components/navbar.vue'
const eventHub = new Vue() // Single event hub
Vue.mixin({
    data: function () {
        return {
            eventHub: eventHub
        }
    }
})
import Vuetify from 'vuetify'
import VueNoty from 'vuejs-noty'
import 'vuetify/src/stylus/app.styl';
import 'vuejs-noty/dist/vuejs-noty.css'
import VuetifyConfirm from 'vuetify-confirm';
import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
Vue.use(Vuetify)
Vue.use(VueNoty, {
    timeout: 3500,
    progressBar: true,
    theme:'metroui'
  })
Vue.use(VuetifyConfirm)
const app = new Vue({
    el: '#app',
    router: routes,
    render: (h) => h(main)
})
const nav = new Vue({
    el: '#nav',
    router: routes,
    render: (h) => h(navbar)
})