module.exports = class Dashboard {

    /**
     * @param {String} containerId
     */
    constructor(containerId) {

        let self = this

        this.__$container = $(containerId).gridster({
            widget_margins: [10, 10],
            autogrow_cols: true,
            widget_base_dimensions: [150, 100],
            serialize_params ($el, widget) {
                return {
                    col: widget.col,
                    row: widget.row,
                    sizeX: widget.size_x,
                    sizeY: widget.size_y,
                    maxSize: [widget.max_size_x, widget.max_size_y],
                    minSize: [widget.min_size_x, widget.min_size_y],
                    id: $el.data('id')
                }
            },
            resize: {
                enabled: true,
                start (e, ui, $el) {

                },
                stop (e, ui, $el) {
                    if (
                        (this.resize_initial_sizex !== this.resize_last_sizex)
                        ||
                        (this.resize_initial_sizey !== this.resize_last_sizey)
                    ) {
                        self.updateState()

                        Framework.Events.fire('dashboard:widget:resized', ui, $el)
                    }
                }
            },
            draggable: {
                stop: function (e, ui, $el) {
                    self.updateState()
                }
            }
        })

        this.__gridster = this.__$container.data('gridster')
    }

    loadWidgets() {
        Vue.http.get(Framework.Url.api('dashboard')).then((response) => {
            if(_.isArray(response.data.widgets)) {
                for (id in response.data.widgets) {
                    let widget = response.data.widgets[id]

                    this.placeWidget(id, widget)
                }
            }
        })
    }

    /**
     * @param {Integer} id
     * @param {Object} widget
     */
    placeWidget(id, widget) {

        let maxSize = widget.maxSize || [widget.sizeX, widget.sizeY],
            minSize = widget.minSize || [widget.sizeX, widget.sizeY]

        let gridsterWidget = this.__gridster.add_widget(
            $(`<li data-id="${id}" />`).append(widget.html),
            widget.sizeX,
            widget.sizeY,
            widget.col || false,
            widget.row || false,
            maxSize,
            minSize
        )

        Framework.Events.fire('dashboard:widget:placed', gridsterWidget)
    }

    /**
     *
     * @param {Integer} id
     */
    removeWidget(id) {
        let $el = this.__$container.find(`[data-id="${id}"]`).closest('li')

        this.__gridster.remove_widget($el, () => {
            Framework.Events.fire('dashboard:widget:deleted', id)
            this.updateState()
        })
    }

    updateState() {
        Vue.http.post(Framework.Url.api('dashboard'), {widgets: this.__gridster.serialize()})
            .then(() => {
                Framework.Events.fire('dashboard:update')
            })
    }
}