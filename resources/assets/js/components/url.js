module.exports = class Url {
    
    /**
     * @param {String} url
     * @param {String} backend_url
     * @param {String} url_prefix
     * @param {String} asset_dir
     */
    constructor(url, backend_url, url_prefix, asset_dir) {
        this._url = url
        this._backend_url = backend_url
        this._url_prefix = url_prefix
        this._asset_dir = asset_dir

        window.history.go(-(window.history.length - 1));
    }

    /**
     * Получение якоря
     *
     * @returns {string}
     */
    get hash () {
        return window.location.hash ? window.location.hash.substr(1) : ''
    }

    /**
     * @param {String} path
     */
    set hash(path) {
        if(_.isString(path) && path.length > 0)
            window.history.pushState({ path: this.hash }, document.title, `#${path}`)
        else
            window.history.pushState({ path: this.hash }, document.title, window.location.pathname)
    }

    /**
     * Ссылка на front
     *
     * @returns {String}
     */
    get url() {
        return this._url
    }

    set url(value) {
        throw new Error(`The url property cannot be written.`);
    }

    /**
     * Ссылка на backend
     *
     * @returns {String}
     */
    get backend_url() {
        return this._backend_url
    }

    set backend_url(value) {
        throw new Error(`The backend_url property cannot be written.`);
    }

    /**
     * Получение значения url prefix админ панели
     *
     * @returns {String}
     */
    get url_prefix() {
        return this._url_prefix
    }

    set url_prefix(value) {
        throw new Error(`The url_prefix property cannot be written.`);
    }

    /**
     * Относительный путь до хранения ассетов для текущей темы
     *
     * @returns {String}
     */
    get asset_dir() {
        return this._asset_dir
    }

    set asset_dir(value) {
        throw new Error(`The asset_dir property cannot be written.`);
    }

    /**
     * Генерация ссылки на asset файл для текущей темы
     *
     * @param {String} path относительный путь до файла
     * @param {Object} query (Опционально) параметры для генерации query string {foo: bar, baz: bar} = ?foo=bar&baz=bar
     * @returns {String}
     */
    asset(path, query) {
        return this.app(
            this._asset_dir + '/' + _.trimStart(path, '/'),
            query
        );
    }

    /**
     * Генерация api ссылки
     *
     * @param {String} path относительный путь
     * @param {Object} query (Опционально) параметры для генерации query string {foo: bar, baz: bar} = ?foo=bar&baz=bar
     * @returns {String}
     */
    api(path, query) {
        return this.app(
            this._url_prefix + '/api/' + _.trimStart(path, '/'),
            query
        );
    }

    /**
     * Генерация admin ссылки
     *
     * @param {String} path относительный путь
     * @param {Object} query (Опционально) параметры для генерации query string {foo: bar, baz: bar} = ?foo=bar&baz=bar
     * @returns {String}
     */
    backend(path, query) {
        return this._buildUrl(
            this._backend_url + '/' + _.trimStart(path, '/'),
            query
        )
    }

    /**
     * Генерация front ссылки
     *
     * @param {String} path относительный путь
     * @param {Object} query (Опционально) параметры для генерации query string {foo: bar, baz: bar} = ?foo=bar&baz=bar
     * @returns {String}
     */
    app(path, query) {
        return this._buildUrl(
            this._url + '/' + _.trimStart(path, '/'),
            query
        );
    }

    _buildUrl(url, query) {
        if(_.isObject(query)) {
            query = this._serialize(query)

            if (query.length) {
                url += `?${query}`
            }
        }

        return url;
    }

    _serialize (query) {
        let str = [];
        for (let p in query)
            if (query.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(query[p]));
            }

        return str.join("&");
    }
}