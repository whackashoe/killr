@extends('layouts.default')

@section('menu_items')
    @if(isset($paste->parent_slug) && !empty($paste->parent_slug))
        <a href="{{ url($paste->parent_slug) }}"><button id="parent">parent</button></a>
    @endif
    <a href="{{ url($paste->slug) }}"><button id="back">back</button></a>
@stop

@section('content')
<div id="modlisting">
    <ul>
        @foreach($paste->children as $mod)
            <li>
                <a href="{{ url($mod->slug) }}">{{ $mod->created_at }} ({{ $mod->modsCount }} mods)</a>
            </li>
        @endforeach
    </ul>
</div>
@stop