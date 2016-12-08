<template>
    <div id="dashboard" class="gridster">
        <ul class="list-unstyled">
            <li data-row="1" data-col="1" data-sizex="1" data-sizey="1"></li>
            <li data-row="2" data-col="1" data-sizex="1" data-sizey="1"></li>
            <li data-row="3" data-col="1" data-sizex="1" data-sizey="1"></li>

            <li data-row="1" data-col="2" data-sizex="2" data-sizey="1"></li>
            <li data-row="2" data-col="2" data-sizex="2" data-sizey="2"></li>

            <li data-row="1" data-col="4" data-sizex="1" data-sizey="1"></li>
            <li data-row="2" data-col="4" data-sizex="2" data-sizey="1"></li>
            <li data-row="3" data-col="4" data-sizex="1" data-sizey="1"></li>

            <li data-row="1" data-col="5" data-sizex="1" data-sizey="1"></li>
            <li data-row="3" data-col="5" data-sizex="1" data-sizey="1"></li>

            <li data-row="1" data-col="6" data-sizex="1" data-sizey="1"></li>
            <li data-row="2" data-col="6" data-sizex="1" data-sizey="2"></li>
        </ul>
    </div>
</template>

<script>
    export default{
        data() {
            return{}
        },

        mounted() {
            this.__initGridster()
            this.addWidgets()
        },

        methods: {
            __initGridster() {
                this.gridster = $("#dashboard ul").gridster({
                    widget_margins: [10, 10],
                    widget_base_dimensions: [140, 140]
                }).data('gridster');

                setTimeout(this.updateWidgets, 1000)
            },

            addWidgets() {
                let self = this

                // send ajax for getting widgets for current user
                Framework.User.meta('dashboard', function(widgets) {
                    for(widget in widgets) {
                       console.log(widget);
                    }
                })
            },

            getWidget(id) {
                return _.findLast(this._widgets, {id: id})
            },

            updateWidgets() {
                Framework.User.storeMeta('dashboard', this.gridster.serialize())
            }
        }
    }
</script>
