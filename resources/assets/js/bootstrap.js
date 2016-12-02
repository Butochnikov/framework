/**
 * A modern JavaScript utility library delivering modularity, performance & extras.
 */
require('./libs/lodash')
let Framework = require('./components/framework');
window.Framework = new Framework(
    document.querySelector("meta[name='csrf-token']").getAttribute('content'),
    window.GlobalConfig || {}
)

require('./libs/jquery')
require('./libs/bootstrap')
require('./libs/urijs')
require('./libs/moment')
require('./libs/i18next')
require('./libs/dropzone')
require('./libs/metismenu')
require('./libs/cookies')
require('./libs/magnific-popup')
require('./libs/sweetalert')
require('./libs/vuejs')

/**
 * Best open source admin dashboard & control panel theme.
 * Built on top of Bootstrap 3, AdminLTE provides a range of
 * responsive, reusable, and commonly used components.
 *
 * @see https://almsaeedstudio.com/preview
 */
require('admin-lte')

window.Framework.Events = require('./components/events');
window.Framework.Controllers = require('./components/controllers');
window.Framework.Modules = require('./components/modules');
window.Framework.WYSIWYG = require('./components/wysiwyg');
window.Framework.Message = require('./components/messages');