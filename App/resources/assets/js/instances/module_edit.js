import Vue from 'vue'
import VueResource from 'vue-resource'
import Alerts from '../components/Alerts.vue'
import ModulesEdit from '../components/ModulesEdit.vue'

Vue.use(VueResource)

if(document.getElementById('module_edit') != null)
{
    new Vue({
        el: '#module_edit',
        data: {},
        components: { Alerts, ModulesEdit },
        methods: {}
    });

    document.getElementsByTagName('BODY')[0].insertAdjacentElement('afterbegin', document.getElementsByClassName('popup__bkgd')[0]);
}