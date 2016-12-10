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
     */
    meta (key, callback) {
        Vue.http.get(Framework.Url.api('me/meta'), {params: {key, key}}).then(function (response) {
            if(_.isFunction(callback)) {
                callback(response.data)
            }
        })
    }

    /**
     * Удаление настроек по ключу
     *
     * @param {String} key
     */
    deleteMeta (key) {
        Vue.http.delete(Framework.Url.api('me/meta'), {params: {key, key}}).then(function (response) {
            console.log(response)
        })
    }

    /**
     * Добавление настроек
     *
     * @param {String} key
     * @param {Object} data
     */
    storeMeta (key, data) {
        Vue.http.post(Framework.Url.api('me/meta'), {key, key, data: data}).then(function (response) {
            console.log(response)
        })
    }
}