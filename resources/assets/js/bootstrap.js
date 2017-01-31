import Framework from './components/framework';

/**
 * A modern JavaScript utility library delivering modularity, performance & extras.
 */
require('./libs/lodash')

window.Framework = new Framework(
    document.querySelector("meta[name='csrf-token']").getAttribute('content'),
    window.GlobalConfig || {}
)

require('./libs/jquery')

window.Framework.Events = require('./components/events')

require('./libs/sweetalert')
window.Framework.Message = require('./components/messages')

require('./libs/bootstrap')
require('./libs/urijs')
require('./libs/moment')
require('./libs/i18next')
require('./libs/dropzone')
require('./libs/metismenu')
require('./libs/cookies')
require('./libs/magnific-popup')
require('./libs/vuejs')
require('./libs/gridster')

/**
 * Best open source admin dashboard & control panel theme.
 * Built on top of Bootstrap 3, AdminLTE provides a range of
 * responsive, reusable, and commonly used components.
 *
 * @see https://almsaeedstudio.com/preview
 */
require('admin-lte')

window.Framework.Dashboard = require('./components/dashboard')
window.Framework.Asset = require('./components/asset')
window.Framework.Controllers = require('./components/controllers')
window.Framework.Storage = require('./components/storage')
window.Framework.Modules = require('./components/modules')
window.Framework.WYSIWYG = require('./components/wysiwyg')