/**
 * Format the given date into a relative time.
 */
Vue.filter('relative', (value) => moment(value).local().fromNow());

/**
 * Format the given date into a formated from config
 */
Vue.filter('formated', (value, format) => {
    return moment(value).format(
        format || this.$settings.date.format || 'Y.m.d'
    );
});