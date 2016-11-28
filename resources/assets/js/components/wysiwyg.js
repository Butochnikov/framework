module.exports = {
    _filters: [],
    _switchedOn: {},
    _editors: {},
    add (name, switchOnHandler, switchOffHandler, execHandler) {
        if (_.isUndefined(switchOnHandler) || _.isUndefined(switchOffHandler)) {
            Framework.log('System try to add filter without required callbacks.');
            return;
        }

        this._filters.push([
            name,
            switchOnHandler,
            switchOffHandler,
            execHandler
        ]);
    },
    get (textareaId) {
        for (let key in this._switchedOn) {
            if (key == textareaId)
                return this._switchedOn[key];
        }
    },
    switchOn (textareaId, filter, params) {
        $('#' + textareaId).css('display', 'block');

        if (this._filters.length > 0) {
            let oldFilter = this.get(textareaId);
            let newFilter = null;

            for (let i = 0; i < this._filters.length; i++) {
                if (this._filters[i][0] == filter) {
                    newFilter = this._filters[i];
                    break;
                }
            }

            if (oldFilter !== newFilter) {
                this.switchOff(textareaId);
            }

            try {
                this._switchedOn[textareaId] = newFilter;
                this._editors[textareaId] = newFilter[1](textareaId, params);

                Framework.Events.fire('wysiwyg:switchOn', this._editors[textareaId]);

            } catch (e) {
                Admin.log(e);
            }
        }
    },
    switchOff (textareaId) {
        let filter = this.get(textareaId);
        try {
            if (filter && typeof(filter[2]) == 'function') {
                filter[2](this._editors[textareaId], textareaId);
            }
            this._switchedOn[textareaId] = null;

            Framework.Events.fire('wysiwyg:switchOff', textareaId);

        } catch (e) {
            Framework.log(e);
        }
    },
    exec (textareaId, command, data) {
        let filter = this.get(textareaId);

        if (filter && _.isFunction(filter[3]))

            Framework.Events.fire('wysiwyg:exec', command, textareaId, data);

            return filter[3](this._editors[textareaId], command, textareaId, data);
    }
}