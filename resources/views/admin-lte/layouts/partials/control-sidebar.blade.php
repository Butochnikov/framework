<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <div class="control-sidebar__content">
        <h3 class="control-sidebar__heading">Recent Activity</h3>

        <ul class="control-sidebar-menu" v-show="hasNotifications">
            <li v-for="notification in notifications">
                <span v-html="notification.attributes.html"></span>
            </li>
        </ul>
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>