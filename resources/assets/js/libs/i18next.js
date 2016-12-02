/**
 * i18next is a very popular internationalization library for
 * browser or any other javascript environment (eg. node.js).
 *
 * @see http://i18next.com/
 */
window.i18next = require('i18next')

i18next.init({
    lng: Framework.locale,
    fallbackLng: 'en',
    defaultNS: 'core',
    ns: 'core',
    nsSeparator: '::',
    resources: {
        [Framework.locale]: Framework.Config.get('trans', {})
    }
});

function trans(key) {
    return i18next.t(key);
}