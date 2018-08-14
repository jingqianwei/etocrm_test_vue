import Vue from 'vue'
import Vuex from 'vuex'
import Api from '../../../api'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: { //存属性
        app:{
            name:'Sticky Card Designer',
            version:'1.0'
        }
    },
    mutations: { //修改属性方法
        save_user_info(state,payload){
            state.user = payload;
        }
    },
    actions: {
        async login(context,form){
            try {
                await Api.site.create(form)
                await this.dispatch('sync')
                return Promise.resolve(true)
            } catch(error){
                return Promise.reject('user login failed')
            }
        },
        async sync(context){
            try {
                let latest_info = await Api.site.sync();
                context.commit('save_user_info', latest_info.user);
                context.commit('save_system_info' , latest_info.system);
                return Promise.resolve(true)
            } catch(error){
                return Promise.reject('store: failed syncing user into store')
            }
        }
    },
    getters: {
        userHasLoggedIn(state){
            return (state.user && state.user.username !== '');
        }
    },
    modules: {

    }
});
export default store