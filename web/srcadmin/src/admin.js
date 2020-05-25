
import Vue from 'vue';
import $ from 'jquery';
global.jQuery = $;
global.$ = $;
import VueCookie from 'vue-cookie';
import selectPicker from 'vue-selectpicker'
import './async_components';

__webpack_public_path__ = webpack_asset_path;

Vue.use(selectPicker);
Vue.use(VueCookie);

const app = new Vue({
    el: '#vue-app',
    methods: {
        startProgress() {

        },
        stopProgress() {

        }
    }
});
