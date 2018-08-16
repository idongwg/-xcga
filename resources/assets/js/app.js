require('./bootstrap');
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'



window.Vue = require('vue');
window.VueRouter = require("vue-router");
Vue.use(ElementUI)
window.axios = require('axios');
Vue.prototype.$http = axios;


import indexpage from './components/IndexPage.vue'
import equipment from './components/Equipment.vue'
import datalist from './components/DataList.vue'
import datalist_equipment from './components/Datalist_equipment.vue'
import editDeviceInfo from './components/EditDeviceInfo.vue'
import userList from './components/User_list.vue'
import addUserList from './components/Adduserlist.vue'
import viewAllData from './components/ViewAllData.vue'
import analysis from './components/Analysis.vue'
import indexView from './components/Indexview.vue'
import version from './components/Version.vue'
import addVersion from './components/Addversion.vue'
import editVersion from './components/EditVersion.vue'
import datalist_all from './components/Datalist_all.vue'
import datalist_one from './components/Datalist_one.vue'

import BaiduMap from 'vue-baidu-map'

Vue.use(BaiduMap, {

    ak: '6ilHUToEP4n0Qg0y90XjqjRrU8GzYAqb'
})

const routes = [{
    path: '/',
    component: indexpage,
    redirect: {
        name: 'indexView'
    }
}, {
    path: '/equipment',
    component: indexpage,
    children: [{
        path: '/equipment',
        component: equipment
    }, {
        path: '/datalist',
        component: datalist
    }, {
        name: 'datalist_equipment',
        path: '/datalist_equipment',
        component: datalist_equipment
    }, {
        name: 'editDeviceInfo',
        path: '/editDeviceInfo',
        component: editDeviceInfo
    }, {
        name: 'userList',
        path: '/userList',
        component: userList
    }, {
        name: 'addUserList',
        path: '/addUserList',
        component: addUserList
    }, {
        name: 'viewAllData',
        path: '/viewAllData',
        component: viewAllData
    }, {
        name: 'analysis',
        path: '/analysis',
        component: analysis
    }, {
        name: 'indexView',
        path: '/indexView',
        component: indexView
    }, {
        name: 'version',
        path: '/version',
        component: version
    }, {
        name: 'addVersion',
        path: '/addVersion',
        component: addVersion
    }, {
        name: 'editVersion',
        path: '/editVersion',
        component: editVersion
    }, {
        name: 'datalist_all',
        path: '/datalist_all',
        component: datalist_all
    } ,{
        name: 'datalist_one',
        path: '/datalist_one',
        component: datalist_one
    }]
}];

const router = new VueRouter({
    routes
});

const app = new Vue({
    router
}).$mount('#apps');