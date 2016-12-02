module.exports = {
    error(title, message) {
        return this.message(title, message, "error")
    },
    success(title, message) {
        return this.message(title, message, "success")
    },
    message(title, message, type) {
        return swal(title, message, type || 'success')
    },
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
};