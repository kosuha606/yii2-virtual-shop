
import Vue from 'vue';
import $ from 'jquery';
global.jQuery = $;
global.$ = $;
import VueCookie from 'vue-cookie';
import selectPicker from 'vue-selectpicker'
import './async_components';
import Request from './objects/Request';
import VueTopprogress from 'vue-top-progress';
import {each} from 'lodash';

import 'admin-lte';
import 'admin-lte/dist/css/adminlte.css';

import 'toastr/build/toastr.min.css';
import toastr from 'toastr';

import pluralize from 'pluralize-ru';

__webpack_public_path__ = webpack_asset_path;

window.Request = Request;

Vue.use(selectPicker);
Vue.use(VueCookie);
Vue.use(VueTopprogress);

Vue.mixin({
    methods: {
        $pluralize(number, no, one, two, five) {
            return pluralize(number, no, one, two, five);
        }
    }
});

const app = new Vue({
    el: '#vue-app',
    created() {
        Request.app = this;
    },
    mounted() {
        this.handleAlerts();
    },
    methods: {
        startProgress() {
            this.$refs.topProgress.start();
        },
        stopProgress() {
            this.$refs.topProgress.done();
        },
        handleAlerts() {
            each(_alerts, (items, key) => {
                each (items, (item) => {
                    this.toast(key, item);
                });
            });
        },
        toast(type, message) {
            toastr[type](message);
        }
    }
});
