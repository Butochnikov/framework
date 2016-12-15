/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('filemanager', require('./vuejs/components/filemanager.vue'))
Vue.component('filemanager', require('./vuejs/components/filemanager.vue'))

Framework.Modules.boot();
Framework.Controllers.dispatch(
    $('body:first').data('route')
)

const app = new Vue({
    el: '#framework',
    data() {
        return {
            loadingNotifications: false,
            notifications: []
        }
    },
    mounted() {
        Framework.User.loggedIn && this.loadDataForAuthenticatedUser()
    },
    methods: {
        showNotifications () {
            let $sidebar = $('.control-sidebar');
            if (!$sidebar.hasClass('control-sidebar-open')) {
                this.markNotificationsAsRead();
            }

            $sidebar.toggleClass('control-sidebar-open');
        },

        loadDataForAuthenticatedUser () {
            this.getNotifications();
        },

        getNotifications () {
            this.notifications = [];
            this.loadingNotifications = true;

            let self = this;

            this.$http.get(Framework.Url.api('notifications')).then(response => {
                _.each(response.data.data, (el) => {
                    self.notification = el
                    el.attributes.html = self.$interpolate(el.attributes.html)
                })

                this.notification = null;
                this.notifications = response.data.data;
                this.loadingNotifications = false;
            });
        },

        getNotification(id) {
            this.$http.get(Framework.Url.api(`notification/${id}`)).then(response => {
                this.notification = response.data.data;
                this.notification.read = false;
                this.notification.attributes.html = this.$interpolate(this.attributes.html);
                this.notifications.unshift(this.notification);
                this.notification = null;
                this.loadingNotifications = false;
            });
        },

        /**
         *
         * Mark the current notifications as read.
         */
        markNotificationsAsRead () {
            if (!this.hasUnreadNotifications) {
                return;
            }

            this.$http.put(Framework.Url.api('notifications/read'), {ids: _.map(this.notifications, 'id')});

            _.each(this.notifications, notification => {
                notification.read = true;
            });
        }
    },
    computed: {
        unreadNotifications () {
            if (this.notifications) {
                return _.filter(this.notifications, notification => {
                    return !notification.read;
                }).length;
            }

            return 0;
        },

        hasNotifications () {
            return this.notifications.length;
        },

        /**
         * Determine if the user has any unread notifications.
         */
        hasUnreadNotifications () {
            return this.unreadNotifications > 0;
        }
    }
});