import View from '../View.vue';

const routes = [
    {   path: '/',
        component: {
            View
        }
    }
];

const router = new VueRouter({
    routes // （缩写）相当于 routes: routes
});

export default router;