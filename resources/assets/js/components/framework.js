module.exports = class Framework {
    constructor(token, config) {
        let ConfigReposirtory = require('./config');

        this.token = token
        this.Config = new ConfigReposirtory(config)

        let Url = require('./url');

        this.Url = new Url(
            this.Config.get('url'),
            this.Config.get('backend_url'),
            this.Config.get('url_prefix', 'backend'),
            this.Config.get('theme.asset_dir', 'backend')
        )
    }

    /**
     * @returns {String}
     */
    static get locale () {
        return this.Config.get('locale', 'en')
    }

    /**
     * @returns {String}
     */
    static get token () {
        return this.token
    }

    /**
     * @returns {ConfigReposirtory}
     */
    static get Config () {
        return this.Config
    }

    /**
     * @returns {Url}
     */
    static get Url () {
        return this.Url
    }

    static set token (value) {
        throw new Error(`The token property cannot be written.`);
    }

    static set Config (value) {
        throw new Error(`The Config property cannot be written.`);
    }

    static set Url (value) {
        throw new Error(`The Url property cannot be written.`);
    }

    log (error) {
        console.log(error)
    }
}