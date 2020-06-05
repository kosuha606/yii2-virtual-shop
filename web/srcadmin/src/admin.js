
import Vue from 'vue';
import $ from 'jquery';
global.jQuery = $;
global.$ = $;
import VueCookie from 'vue-cookie';
import selectPicker from 'vue-selectpicker'
import './async_components';
import Request from './objects/Request';
import VueTopprogress from 'vue-top-progress';

__webpack_public_path__ = webpack_asset_path;

window.Request = Request;

Vue.use(selectPicker);
Vue.use(VueCookie);
Vue.use(VueTopprogress);


const app = new Vue({
    el: '#vue-app',
    created() {
        Request.app = this;
    },
    methods: {
        startProgress() {
            this.$refs.topProgress.start();
        },
        stopProgress() {
            this.$refs.topProgress.done();
        }

    }
});
