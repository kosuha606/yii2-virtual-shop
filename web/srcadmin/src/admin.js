
import Vue from 'vue';
import List from './ui/List';
import Detail from './ui/Detail';
import DetailField from './ui/DetailField';
import $ from 'jquery';
import VueCookie from 'vue-cookie';
import selectPicker from 'vue-selectpicker'

import InputField from './ui/form/InputField';
import TextField from './ui/form/TextField';
import SelectField from './ui/form/SelectField';

global.jQuery = $;
global.$ = $;

Vue.use(selectPicker);
Vue.use(VueCookie);
Vue.component('InputField', InputField);
Vue.component('TextField', TextField);
Vue.component('SelectField', SelectField);

const app = new Vue({
    el: '#vue-app',
    components: {
        List,
        Detail,
        DetailField,
    },
    methods: {
        startProgress() {

        },
        stopProgress() {

        }
    }
});