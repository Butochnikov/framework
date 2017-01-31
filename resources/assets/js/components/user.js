module.exports = class User {

    constructor(userId) {
        this.__userId = userId
        this.__data = {};
    }

    /**
     *
     * @returns {Integer}
     */
    get id() {
        return this.__userId
    }

    /**
     * TODO реализовать возврат значений
     *
     * Получение настроек по ключу
     * @param {String} key
     * @return Promise
     */
    meta (key) {
        return Vue.http.get(Framework.Url.api('me/meta'), {params: {key, key}})
    }

    /**
     * Удаление настроек по ключу
     *
     * @param {String} key
     * @return Promise
     */
    deleteMeta (key) {
        return Vue.http.delete(Framework.Url.api('me/meta'), {params: {key, key}})
    }

    /**
     * Добавление настроек
     *
     * @param {String} key
     * @param {Object} data
     * @return Promise
     */
    storeMeta (key, data) {
        return Vue.http.post(Framework.Url.api('me/meta'), {key, key, data: data})
    }
}