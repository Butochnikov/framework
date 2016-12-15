<div class="event" >
    <div class="label">
        <i class="circular {{ array_get($notification->data, 'icon') }} icon"></i>
    </div>
    <div class="content">
        <div class="summary">
            {!! array_get($notification->data, 'text') !!}
        </div>

        <div class="meta">
            <div>
                <small class="date">
                    @{{ notification.attributes.created_at }}
                </small>
            </div>
        </div>
    </div>
</div>