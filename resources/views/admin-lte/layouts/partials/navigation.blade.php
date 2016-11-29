@foreach($pages as $page)
    {!! $page->render(theme()->viewPath('layouts.partials.navigation.page')) !!}
@endforeach