// Register VueRouter
import Vue from 'vue';
import VueRouter from 'vue-router'
// App component and 404 component are page-level components
import Main from '../Main.vue'
import NotFound from '../404.vue'

// segment components inside App Component's workspace section
import NewDemo from '../../demo/New.vue'
import HandleDemo from '../../demo/Handle.vue'
import SecurityDemo from '../../demo/Security.vue'
import OperationDemo from '../../demo/Operation.vue'

// segment components layout App Component's workspace section
import Header from '../../layout/Header.vue'
import Footer from '../../layout/Footer.vue'
import Aside  from '../../layout/Aside'

// 要告诉 vue 使用 vueRouter
Vue.use(VueRouter);

const routes = [
    {
        path: '',
        components: {
            header: Header,
            aside : Aside,
            main  : Main,
            footer: Footer
        },
        children: [
            {
                path: '',
                redirect: 'handle',
            },
            {
                path: 'handle',
                name: 'handle',
                component: HandleDemo
            },
            {
                path: 'security',
                name: 'security',
                component: SecurityDemo
            },
            {
                path: 'operation',
                name: 'operation',
                component: OperationDemo
            },
            {
                path: 'new',
                name: 'new',
                component: NewDemo
            }
        ]
    },
    {
        path: '404',
        component: NotFound
    },
    {
        path: '*',
        redirect: '404'
    }
];

const router = new VueRouter({
    mode: 'history',
    base:'test/vue',
    routes
});

export default router;