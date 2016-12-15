module.exports = class User {

    constructor(userId) {
        this.__userId = userId
        this.__data = {};
    }

    /**
     * Получение ID авторизованного пользователя
     * @returns {Integer}
     */
    get id() {
        return this.__userId
    }

    /**
     * Получение статуса авторизации пользователя
     *
     * @return {boolean}
     */
    get loggedIn() {
        return this.id > 0
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


    set id(value) {
        throw new Error(`The id property cannot be written.`)
    }

    set loggedIn(value) {
        throw new Error(`The loggedIn property cannot be written.`)
    }

}