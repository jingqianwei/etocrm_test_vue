import axios from 'axios'
import json_response_codes from './codes'
import config from '../config'

// 创建axios实例
const Axios = axios.create({
    baseURL     : config.base_url,
    timeout     : 5000,
    maxRedirects: 1
});

// override axios's default accept
Axios.defaults.headers.common['Accept'] = 'application/json'

// 拦截所有的 api 请求，未来可做权限检查，缓存，代理等
Axios.interceptors.request.use(
    config => {
        return config;
    },
    error => {
        return Promise.reject(error);
    },
);

// 拦截所有的 api 响应，可以实现自动弹窗报错
Axios.interceptors.response.use(
    net_response => {   // when HTTP_STATUS in [ 200 , 299 ]
        const json_response = net_response.data;
        if (json_response.code === json_response_codes.SUCCESS) {
            return Promise.resolve(json_response.data);
        }

        return Promise.reject(json_response);
    },
    error => {      // when HTTP_STATUS in [ 300 , 599 ]
        if (error === 'cancelled locally') {
            return Promise.reject(error);
        }

        if (error.message === 'timeout of 5000ms exceeded') {
            return Promise.reject(error);
        }

        if (error.response.status === 429) {
            return Promise.reject(error);
        }

        return Promise.reject(error);
    }
);

export default Axios;


