@extends('agent::layouts.app')

@section('title')
    {{ __('404 Error') }}
@endsection

@section('panel_content')
<h2 class="error">Eror Occured</h2>
<p class="message">Please try again</p>
@endsection