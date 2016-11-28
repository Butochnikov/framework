module.exports = function () {
	return {
        _controllers: [],
        add: function(route, callback) {
            if (!_.isFunction(callback))
                return this;

            if (_.isObject(route))
                for (let i = 0; i < route.length; i++)
                    this._controllers.push([route[i], callback]);
            else if (_.isString(route))
                this._controllers.push([route, callback]);

            return this;
        },
        dispatch: function(route) {
            for (let i = 0; i < this._controllers.length; i++) {
                if (route == this._controllers[i][0]) {
                    window.Framework.Events.fire('controller:call', bodyId);
                    this._controllers[i][1](this._controllers[i][0]);
                }
            }
        }
	}
}();