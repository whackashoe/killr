@extends ('layouts.default')

@section ('title')
killr.io :: {{ $paste->slug }} -> {{ $mod->slug }} diff 
@stop

@section ('description')
@if (!isset($paste->id))
killr.io is the most intuitive, quick to use, and beautiful pasting and collaboration tool available.
@endif
@stop

@section ('menu_items')
    <a href="{{ url($paste->slug . '/mods') }}"><button id="back">back</button></a>
@stop

@section ('content')
    <div id="linenumbers">
        <table>
            <tbody>
            @foreach ($changes as $i)
                <tr><td>{{ $i }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="content"><pre><code></code></pre></div>
    <textarea spellcheck="false" autocomplete="off" autofocus="true" id="editor" name="code" disabled>{{ $diff or '' }}</textarea>
@stop

@section ('scripts')
    <script>
    $(document).ready(function() {
        hljs.initHighlightingOnLoad();
        var cur_line = 1;
        $('#linenumbers td').each(function(i, v) {
            var val = $(v).text();
            if(val == '-') {
                $(v).css('color', 'rgba(250, 35, 35, 0.7)');
            } else if(val == '+') {
                $(v).css('color', 'rgba(10, 175, 10, 0.7)');
                ++cur_line;
            } else {
                ++cur_line;
            }

            $(v).text((cur_line - 1));
        });
    });
    </script>
@stop
