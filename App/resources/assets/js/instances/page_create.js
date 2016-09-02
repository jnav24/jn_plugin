import Vue from 'vue'
import Sortable from 'vue-sortable'
import Alerts from '../components/Alerts.vue'
import PageCreateModules from '../components/PageCreateModules.vue'

Vue.use(Sortable)

if(document.getElementById('page_create') != null)
{
    new Vue({
        el: '#page_create',
        data: {},
        components: { Alerts, PageCreateModules }
    });
}