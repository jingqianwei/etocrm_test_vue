import http from '../http';

export default {
    site:{
        async create(params){
            return await http.post('/minicart/site/create',params)
        }
    }
};

