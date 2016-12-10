<template>
    <div id="dashboard" class="gridster">
        <ul class="list-unstyled"></ul>
    </div>
</template>

<script>

    export default{
        data() {
            return{}
        },

        mounted() {
            this.dashboard = new Framework.Dashboard('#dashboard ul')
            this.dashboard.loadWidgets()
        },

        methods: {

        }
    }
</script>
