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

Vue.http.headers.common['X-CSRF-TOKEN'] = Framework.token;

/**
 * We'll register a HTTP interceptor to attach the "XSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
Vue.http.interceptors.push((request, next) => {
    next((response) => {
        switch (response.status) {
            case 200: // OK
            case 204: // No Content

                break;
            case 201: // Created
            case 202: // Accepted

                break;
            case 401: // Unauthorized
                Framework.Message.error('Unauthorized!')
                break;
            case 403: // Forbidden
                Framework.Message.error('Access denied')
                break;
            case 404: // Not Found
                Framework.Message.error('Page not found')
                break;
            default:
                Framework.Message.error('Something went wrong')
                //response.data.message
                swal('Something went wrong', "", "error")
        }
    });
});

Vue.use({
    install (Vue, options) {
        Vue.prototype.$trans = (key) => i18next.t(key)
        Vue.prototype.$settings = Framework.Config
    }
});

require('../vuejs/filters/trans')
require('../vuejs/filters/date')
