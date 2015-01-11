@extends('layouts.default')
@section('content')
<div id="linenumbers"></div>
<div id="content"><pre><code></code></pre></div>
<textarea spellcheck="false" autocomplete="off" id="editor" name="code"></textarea>
<menu id="mainmenu">
    <div id="linepadder"></div>
    <button id="save">save</button>
</menu>
<div class="hide" id="overlay"></div>
<div class="modal hide" id="success-modal"></div>
<div class="modal hide" id="error-modal"></div>
@stop
