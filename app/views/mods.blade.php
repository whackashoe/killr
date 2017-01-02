@extends ('layouts.default')

@section ('title')
killr.io :: {{ $paste->slug }} modification tree
@stop

@section ('description')
view the modification tree for {{ $paste->slug }} 
@stop

@section ('menu_items')
    @if (isset($paste->parent_slug) && !empty($paste->parent_slug))
        <a href="{{ url($paste->parent_slug) }}"><button id="parent">parent</button></a>
    @endif
    <a href="{{ url($paste->slug) }}"><button id="back">back</button></a>
@stop

@section ('content')
<div id="modlisting">
    <ul>
        @forelse ($paste->children as $mod)
            <li>
                <a href="{{ url($mod->slug) }}">{{ $mod->created_at }} ({{ $mod->modsCount }} mods)</a>
                @if ($mod->modsCount > 0)
                    <button class="expand-mods" data-slug="{{ $mod->slug }}">+</button>
                @endif
            </li>
        @empty
            <li><a href="{{ url($paste->slug) }}">there's been no modifications :( </a></li>
        @endforelse
    </ul>
</div>
@stop
