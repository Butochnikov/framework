module.exports = (function() {
    
    var modules= {}
    
    return {
        /**
         * Регистрация модуля
         * @param {String} module ключ модуля
         * @param {Function} callback тело модуля
         * @param {Integer} priority приоритет запуска
         * @param {Array} events список событий при срабатывании которых необходимо перезапустить модуль
         * @returns {exports}
         */
        register (module, callback, priority, events) {

            if (!_.isFunction(callback)) {
                Framework.log(`Module ${module} not added. You need to specify callback`, 'Modules')
                return this
            }

            modules[module] = {
                name: module,
                callback: callback,
                priority: priority || 0
            }

            if (_.isString(events)) {
                Framework.Events.on(events, callback)
            } else if (_.isArray(events)) {
                _.each(events, function (event) {
                    Framework.Events.on(event, callback)
                })
            }

            return this
        },
        /**
         * Запус зарегестрированного модуля по имени
         *
         * @param {String} name название модуля
         */
        call (name) {
            _.each(modules, (module, index) => {
                if (_.isArray(name) && _.indexOf(name, index) != -1)
                    module.callback()
                else if (name == index)
                    module.callback()
            })
        },

        /**
         * Запуск всех модулей
         */
        boot () {
            _.each(_.sortBy(modules, function (module) {
                return module.priority
            }), (module, name) => {
                try {
                    module.callback();
                } catch (e) {
                    Framework.log(`Error with loading module ${name}`, 'Modules');
                }
            })
        }
    }
})()