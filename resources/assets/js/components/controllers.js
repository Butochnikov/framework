module.exports = (function(){

    var controllers = []

    return {

        /**
         * Регистрация нового контроллера
         *
         * @param {String} route
         * @param {Function} callback
         * @returns {exports}
         */
        route (route, callback, assets) {
            if (!_.isFunction(callback))
                return this

            if (_.isObject(route))
                _.forEach(route, function(r) {
                    controllers.push({
                        route: r,
                        callback: callback
                    })
                });

            else if (_.isString(route))
                controllers.push({
                    route: route,
                    callback: callback

                })

            return this
        },

        /**
         *
         * @param {String} route
         */
        dispatch (route) {
            _.forEach(controllers, function(controller) {
                if (route == controller.route) {
                    Framework.Events.fire('controller:call', controller.route)
                    controller.callback(controller.route)

                }
            })
        }
    }
})()