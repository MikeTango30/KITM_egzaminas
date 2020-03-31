@extends('layouts.main')
@section('promo')
    @component('_partials.promo')
        @slot('title')
            <h3 class="my-auto text-white w-100">Time is lost...</h3>
        @endslot
    @endcomponent
@stop
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row my-4">
                <h3>This funcionality is not implemented</h3>
            </div>
            <div class="row my-4">
                <h4><a href="{{ url('/') }}">Head back</a></h4>
            </div>
        </div>
    </div>
@stop
