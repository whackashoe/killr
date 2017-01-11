@extends ('layouts.default')

@section ('title')
@if (!isset($paste->id))
killr.io :: paste code and text, optionally collaborate with friends or strangers
@else
killr.io :: {{ $paste->slug }} paste
@endif
@stop

@section ('description')
@if (!isset($paste->id))
killr.io is the most intuitive, quick to use, and beautiful pasting and collaboration tool available.
@endif
@stop

@section ('menu_items')
    @if (isset($paste->ip) && strcmp($paste->ip, Request::getClientIp()) == 0)
        <button id="views">views {{ $paste->views }}</button>
        <button id="delete">delete</button>
    @endif
    <button id="save">save</button>
    @if (isset($paste->id) && !empty($paste->id))
        <a href="{{ url($paste->slug . '/raw') }}"><button id="raw">raw</button></a>
        <a href="{{ url($paste->slug . '/demo') }}"><button id="demo">demo</button></a>
    @endif
    <button id="preview">preview</button>
    @if (isset($paste->parent_id) && $paste->parent != null)
        <a href="{{ url($paste->parent->slug . '/diff/' . $paste->slug) }}"><button id="parent">diff</button></a>
        <a href="{{ url($paste->parent->slug) }}"><button id="parent">parent</button></a>
    @endif
    @if (isset($paste->id) && isset($paste->modsCount) && $paste->modsCount > 0)
        <a href="{{ url($paste->slug . '/mods') }}"><button id="mods">mods ({{ $paste->modsCount }})</button></a>
    @endif
@stop

@section ('content')
    <div id="linenumbers"></div>
    <div id="content"><pre><code></code></pre></div>
    <textarea spellcheck="false" autocomplete="off" autofocus="true" id="editor" name="code"></textarea>
    <input type="hidden" name="parent_id" id="parent_id" value="{{ $paste->id or '' }}">
    <div id="caret"></div>
    <div class="hide" id="overlay"></div>
    <div class="modal hide" id="success-modal"></div>
    <div class="modal hide" id="error-modal"></div>
@stop

@section ('scripts')
    <script>
    $(document).ready(function() {
        @if (isset($paste->code))
            $("#editor").val({{ json_encode($paste->code) }});
        @endif
        $("#editor").bind('input propertychange', function() {
            var decoded = $("#editor").val();
            var cols_per_line = [];

            $('#linenumbers').html('<table>'+$.map(decoded.split('\n'), function(t, i) {
                cols_per_line.push(t.length);
                return '<tr><td>'+(i+1)+'</td></tr>';
            }).join('')+'</table>');
        }).trigger('propertychange');

        $("#save").click(function() {
            var url = document.URL + (document.URL.endsWith('/') ? '' : '/') + 'create';
            $.post(url, {code: $('#editor').val(), parent_id: $("#parent_id").val()}, function(result) {
                console.log(result);
                if(result.success) {
                    $("#success-modal").html('<a href="/' + result.slug + '">killr.io/' + result.slug + '</a>');
                    $("#overlay").show();
                    $("#success-modal").show();
                } else {
                    var error_html = '<li>' + result.errors.code + '</li>';

                    $("#error-modal").html('<ul>' + error_html + '</ul>');
                    console.log(error_html);
                    $("#overlay").show();
                    $("#error-modal").show();
                }
            });
        });

        $("#delete").click(function() {
            var url = document.URL + (document.URL.endsWith('/') ? '' : '/') + 'delete';
            $.post(url, function(result) {
                console.log(result);
                if(result.success) {
                    $("#success-modal").html('<a href="/">deleted</a>');
                    $("#overlay").show();
                    $("#success-modal").show();
                }
            });
        });

        $("#error-modal").click(function() {
            $("#overlay").hide();
            $("#error-modal").hide();
            $("#editor").focus();
        });

        $(window).load(function() {
            redraw();
        });

        $(this).scrollTop(0);

        var preview_window;
        $("#preview").click(function() {
            if(typeof(preview_window) === 'undefined' || preview_window.closed) {
                preview_window = window.open('', '_blank', 'toolbar=0,location=0,directories=0,status=1,menubar=0,titlebar=0,scrollbars=1,resizable=1');
            }
 
            $.post('/preview', {'code': $("#editor").val()}, function(res) {
                if(res.success) {
                    preview_window.location.assign('/preview/' + res.slug);
                } else {
                    console.log(res);
                }
            });
        });
    });

    </script>
@stop
