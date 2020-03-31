@extends('layouts/main')
@section('promo')
    @component('_partials.promo')
        @slot('title')
            <div class="container">
                <div class="row errors">
                    <div class="alert alert-danger justify-content-center">
                        <h5>Error: unauthorized access.</h5>
                    </div>
                </div>
            </div>
        @endslot
    @endcomponent
@stop
