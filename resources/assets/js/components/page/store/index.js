import Vue from 'vue'
import Vuex from 'vuex'
import Api from '../../../api'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: { //存属性,直接定义store属性的值，然后就可以在vue页面使用了
        app:{
            name:'Sticky Card Designer',
            version:'1.0'
        }
    },
    mutations: { //修改state属性方法，在 store 上注册 mutation，处理函数总是接受 state 作为第一个参数（如果定义在模块中，则为模块的局部状态），payload 作为第二个参数（可选）
        save_user_info(state, payload){
            state.user = payload;
        }
    },
    actions: { //action 类似于 mutation，不同在于：action 提交的是 mutation，而不是直接变更状态,action 可以包含任意异步操作
        //在 store 上注册 action。处理函数总是接受 context 作为第一个参数，payload 作为第二个参数
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
                return Promise.resolve(true)
            } catch(error){
                return Promise.reject('store: failed syncing user into store')
            }
        }
    },
    getters: { //在 store 上注册 getter，getter 方法接受以下参数：
        userHasLoggedIn(state){
            return (state.user && state.user.username !== '');
        }
    },
    modules: {

    }
});
export default store