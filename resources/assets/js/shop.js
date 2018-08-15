import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI,{
    size:'medium'
});

import Shop from './shop/Shop.vue';

const app = new Vue({
    el: '#app',
    render: h => h(Shop)
});
