import Config from "./config";
import Url from "./url";

module.exports = class Framework {
    constructor(token, config) {
        this.__token = token
        this.__config = new Config(config)

        this.__url = new Url(
            this.Config.get('url'),
            this.Config.get('backend_url'),
            this.Config.get('url_prefix', 'backend'),
            this.Config.get('theme.asset_dir', 'backend')
        )
    }

    /**
     * @returns {Integer}
     */
    get userId() {
        return this.Config.get('userId')
    }

    /**
     * @returns {String}
     */
    get locale() {
        return this.Config.get('locale', 'en')
    }

    /**
     * @returns {String}
     */
    get token() {
        return this.__token
    }

    /**
     * @returns {boolean}
     */
    get debug() {
        return this.Config.get('debug')
    }

    /**
     * @returns {String}
     */
    get env() {
        return this.Config.get('env')
    }

    /**
     * @returns {ConfigReposirtory}
     */
    get Config() {
        return this.__config
    }

    /**
     * @returns {Url}
     */
    get Url() {
        return this.__url
    }

    log(error, module) {
        if (this.debug)
            console.log(`[${module || 'SleepingOwl Framework'}]: ${error}`)
    }


    set token(value) {
        throw new Error(`The token property cannot be written.`)
    }

    set debug(value) {
        throw new Error(`The debug property cannot be written.`)
    }

    set env(value) {
        throw new Error(`The env property cannot be written.`)
    }

    set Config(value) {
        throw new Error(`The Config property cannot be written.`)
    }

    set Url(value) {
        throw new Error(`The Url property cannot be written.`)
    }

    set userId(value) {
        throw new Error(`The userId property cannot be written.`)
    }
}