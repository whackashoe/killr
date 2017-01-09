@extends ('layouts.default')

@section ('title')
killr.io :: {{ $paste->slug }} modification tree
@stop

@section ('description')
view the modification tree for {{ $paste->slug }} 
@stop

@section ('menu_title')
killr.io :: viewing mods of {{ $paste->slug }}
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
                <a href="{{ url($mod->slug) }}">{{ $mod->created_at }} ({{ $mod->modsCount }} mods)  <a href="/{{ $paste->slug }}/diff/{{ $mod->slug }}">[diff]</a>
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

@section ('scripts')
    <script>
    function expand_mods(el)
    {
        el.hide();
        var parent = el.parent();
        var m_slug = el.data('slug');
        console.log(parent);
        parent.append($("<ul/>"));

        $.getJSON("/" + m_slug + "/mods.json", function(results) {
            $.each(results, function(i, v) {
                var html = '<li><a href="/' + v.slug + '">' + v.created_at + ' (' + v.mods.length + ' mods)</a> <a href="/{{ $paste->slug }}/diff/' + v.slug +'">[diff]</a>';
                if(v.mods.length > 0) {
                    html += '<button class="expand-mods" data-slug="' + v.slug + '">+</button></li>';
                }
                var nli = $(html);
                nli.click(function() { expand_mods(nli.find("button")); });
                parent.find("ul").append(nli);
            });
        });
    }

    $(".expand-mods").click(function() { expand_mods($(this)); });
    </script>
@stop
