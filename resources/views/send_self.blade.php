@extends('layouts/main')
@section('promo')
    @component('_partials.promo')
        @slot('title')
            <h1 class="my-auto w-100">Payments between my accounts</h1>
        @endslot
    @endcomponent
@stop
@section('content')
    <div class="container">
        <div class="row add-task">
            <form method="post" action="{{ url('/send-self/send') }}" class="p-5 bg-white w-100">
                @csrf
                <div class="row errors">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="row form-group">
                    <div class="offset-md-3 col-md-6 mb-3 mb-md-0">
                        <label class="text-black" for="fromAccount">Send from:</label>
                        <select id="fromAccount" class="form-control" name="fromAccount">
                            <option selected value="{{ $accounts[1]->id }}">{{ $accounts[1]->number }} ({{ $accounts[1]->amount }}EUR)</option>
                            <option selected value="{{ $accounts[0]->id }}">{{ $accounts[0]->number }} ({{ $accounts[0]->amount }}EUR)</option>
                        </select>
                    </div>
                    <div class="offset-md-3 col-md-6 mb-3 mb-md-0">
                        <label class="text-black" for="toAccount">Send from:</label>
                        <select id="toAccount" class="form-control" name="toAccount">
                            <option selected value="{{ $accounts[0]->id }}">{{ $accounts[0]->number }} ({{ $accounts[0]->amount }}EUR)</option>
                            <option selected value="{{ $accounts[1]->id }}">{{ $accounts[1]->number }} ({{ $accounts[1]->amount }}EUR)</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="offset-md-3 col-md-6 mb-3 mb-md-0">
                        <label class="text-black" for="amount">Amount</label>
                        <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="offset-md-3 col-md-6 mb-3 mb-md-0">
                        <label class="text-black" for="message">Message</label>
                        <textarea type="text" id="message" class="form-control" name="message" placeholder="Message"></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="offset-md-3 col-md-6">
                        <input type="submit" value="Send Payment" class="btn btn-primary py-2 px-4 text-white">
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
