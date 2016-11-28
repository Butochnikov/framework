@foreach($pages as $page)
    {!! $page->render(themeView('layouts.partials.navigation.page')) !!}
@endforeach