/**
 * Vue is a modern JavaScript for building interactive web interfaces using
 * reacting data binding and reusable components. Vue's API is clean and
 * simple, leaving you to focus only on building your next great idea.
 *
 * @see https://vuejs.org/guide/
 */
window.Vue = require('vue');

/**
 * The plugin for Vue.js provides services for making web requests and handle
 * responses using a XMLHttpRequest or JSONP.
 *
 * @see https://github.com/vuejs/vue-resource/tree/master/docs
 */
require('vue-resource');

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Framework.Settings.token;

/**
 * We'll register a HTTP interceptor to attach the "XSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
Vue.http.interceptors.push((request, next) => {
    next((response) => {
        switch (response.status) {
            case 200:
            case 202:
                break;
            case 422:
                break;
            case 401:
                sweetAlert(
                    i18next.t('core::message.need_auth'),
                    response.data.message,
                    'error'
                )
                break;
            case 403:
                sweetAlert(
                    i18next.t('core::message.access_denied'),
                    response.data.message,
                    'error'
                )
                break;
            default:
                sweetAlert(
                    i18next.t('core::message.something_went_wrong'),
                    response.data.message,
                    'error'
                )
        }
    });
});

Vue.use({
    install (Vue, options) {
        Vue.prototype.$trans = (key) => i18next.t(key),
        Vue.prototype.$settings = window.Framework.Settings
    }
});

require('../vuejs/filters/trans')
require('../vuejs/filters/date')
