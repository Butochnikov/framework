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
        route (route, callback) {
            if (!_.isFunction(callback))
                return this

            if (_.isObject(route))
                for (let i = 0; i < route.length; i++)
                    controllers.push([route[i], callback])
            else if (_.isString(route))
                controllers.push([route, callback])

            return this
        },

        /**
         *
         * @param {String} route
         */
        dispatch (route) {
            for (let i = 0; i < controllers.length; i++) {
                if (route == controllerss[i][0]) {
                    Framework.Events.fire('controller:call', route)
                    controllers[i][1](controllers[i][0])
                }
            }
        }
    }
})()