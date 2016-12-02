module.exports = class Url {

    constructor(url, backend_url, url_prefix, asset_dir) {
        this.url = url
        this.backend_url = backend_url
        this.url_prefix = url_prefix
        this.asset_dir = asset_dir
    }

    static get hash() {
        return window.location.hash.substr(1)
    }

    static set hash(value) {
        throw new Error(`The hash property cannot be written.`);
    }

    static get url() {
        return this.url
    }

    static set url(value) {
        throw new Error(`The url property cannot be written.`);
    }

    static get backend_url() {
        return this.backend_url
    }

    static set backend_url(value) {
        throw new Error(`The backend_url property cannot be written.`);
    }

    static get url_prefix() {
        return this.url_prefix
    }

    static set url_prefix(value) {
        throw new Error(`The url_prefix property cannot be written.`);
    }

    static get asset_dir() {
        return this.asset_dir
    }

    static set asset_dir(value) {
        throw new Error(`The asset_dir property cannot be written.`);
    }

    asset(path, query) {
        return this.app(
            this.asset_dir + '/' + _.trimStart(path, '/'),
            query
        );
    }

    api(path, query) {
        return this.app(
            this.url_prefix + '/api/' + _.trimStart(path, '/'),
            query
        );
    }

    backend(path, query) {
        return this._buildUrl(
            this.backend_url + '/' + _.trimStart(path, '/'),
            query
        )
    }

    app(path, query) {
        return this._buildUrl(
            this.url + '/' + _.trimStart(path, '/'),
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