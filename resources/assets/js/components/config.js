module.exports = class ConfigReposirtory {

    constructor(config) {
        this._config = config || {};
    }

    /**
     * @param {String} key
     * @param {*} def
     * @returns {*}
     */
    get(key, def) {
        return _.get(this._config, key, def)
    }

    /**
     * @param {String} key
     * @param {*} value
     * @returns {Object}
     */
    set(key, value) {
        return _.set(this._config, key, value)
    }

    /**
     * @param {String} key
     * @returns {boolean}
     */
    has(key) {
        return _.has(this._config, key)
    }

    /**
     * @param {Object} config
     */
    merge(config) {
        _.merge(this._config, config)
    }

    /**
     *
     * @returns {Array}
     */
    keys () {
        return _.keys(this._config)
    }

    /**
     *
     * @returns {Object}
     */
    all () {
        return this._config
    }

    /**
     * @param {Array} paths
     */
    omit(paths) {
        this._config = _.omit(this._config, paths)
    }
}