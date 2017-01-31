<a href="#">
    <i class="menu-icon fa fa-{{ array_get($notification->data, 'icon') }}"></i>
    <div class="menu-info">
        <h4 class="control-sidebar-subheading">{!! array_get($notification->data, 'text') !!}</h4>

        <p>@{{ notification.attributes.created_at }}</p>
    </div>
</a>