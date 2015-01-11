@extends('layouts.default')
@section('content')
<div id="linenumbers"></div>
<div id="content"><pre><code></code></pre></div>
<textarea spellcheck="false" autocomplete="off" autofocus="true" id="editor" name="code">{{ $paste->code or '' }}</textarea>
<div id="caret"></div>
<menu id="mainmenu">
    <div id="linepadder"></div>
    @if(isset($paste->ip) && strcmp($paste->ip, Request::getClientIp()) == 0)
        <button id="views">views {{ $paste->views }}</button>
        <button id="delete">delete</button>
    @endif
    <button id="save">save</button>
    <a href="{{ url('terms') }}"><button id="terms">terms</button></a>
    <a href="{{ url('about') }}"><button id="about">about</button></a>
</menu>
<div class="hide" id="overlay"></div>
<div class="modal hide" id="success-modal"></div>
<div class="modal hide" id="error-modal"></div>
@stop
