module.exports = (function () {

    return {

        /**
         * Вывод сообщения об ошибке
         *
         * @param {String} title заголовок
         * @param {String} message текст
         * @returns {*}
         */
        error(title, message) {
            return this.message(title, message, "error")
        },

        /**
         * Вывод Success сообщения
         * @param {String} title заголовок
         * @param {String} message текст
         * @returns {*}
         */
        success(title, message) {
            return this.message(title, message, "success")
        },

        /**
         * Вывод сообщения
         *
         * @param {String} title заголовок
         * @param {String} message текст
         * @param {String} type Тип сообщения (error, success)
         * @returns {*}
         */
        message(title, message, type) {
            return swal(title, message, type || 'success')
        },

        /**
         * Вывод сообщения с подтверждением
         *
         * @param {String} title заголовок
         * @param {String} message текст
         * @param {Function} callback Код выполняемый при подтверждении
         */
        confirm(title, message, callback) {
            swal({
                title: title,
                text: message || '',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3c8dbc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then(callback)
        },

        /**
         * Вывод сообщения с полем ввода
         *
         * @param {String} title
         * @param {String} message
         * @param {Function} callback Код выполняемый при подтверждении
         * @param {String} inputPlaceholder Вспомогательный текст для поля ввода
         */
        prompt(title, message, callback, inputPlaceholder) {
            swal({
                title: title,
                text: message || '',
                type: 'input',
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: inputPlaceholder || ''
            }).then(callback)
        },
    }

})()