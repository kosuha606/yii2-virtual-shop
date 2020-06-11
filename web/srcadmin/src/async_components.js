
import Vue from 'vue';


Vue.component('InputField', () => import('./ui/form/InputField'));
Vue.component('MultilangField', () => import('./ui/form/MultilangField'));
Vue.component('HiddenField', () => import('./ui/form/HiddenField'));
Vue.component('TextField', () => import('./ui/form/TextField'));
Vue.component('SelectField', () => import('./ui/form/SelectField'));
Vue.component('HtmlField', () => import('./ui/form/HtmlField'));
Vue.component('RedactorField', () => import('./ui/form/RedactorField'));
Vue.component('ImageField', () => import('./ui/form/ImageField'));
Vue.component('ConfigBuilderField', () => import('./ui/form/ConfigBuilderField'));
Vue.component('VersionField', () => import('./ui/form/VersionField'));

Vue.component('SearchPage', () => import('./ui/concrete/SearchPage'));
Vue.component('GenurlsPage', () => import('./ui/concrete/GenurlsPage'));
Vue.component('SettingsPage', () => import('./ui/concrete/SettingsPage'));
Vue.component('DashboardPage', () => import('./ui/concrete/DashboardPage'));

Vue.component('List', () => import('./ui/List'));
Vue.component('Detail', () => import('./ui/Detail'));
Vue.component('DetailField', () => import('./ui/DetailField'));
