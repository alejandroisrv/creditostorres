import VueRouter from 'vue-router';
import Vue from 'vue'
import Home from './components/Home.vue'
import Example from './components/ExampleComponent.vue'
Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/example/:id?',
            name: 'example',
            component: Example
        }
    ]
})
