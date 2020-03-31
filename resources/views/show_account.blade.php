@extends('layouts.main')
@section('promo')
    @component('_partials.promo')
        @slot('title')
            <h1 class="my-auto w-100">My Accounts</h1>
        @endslot
    @endcomponent
@stop
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Account type</th>
                        <th scope="col">Balance, EUR</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td class="account account--id">{{ $loop->index + 1 }}</td>
                            <td class="account account--number">{{ $account->number }}</td>
                            <td class="account account--main">
                                <span class="badge badge-pill badge-{{ $account->is_main }}">
                                    @if($account->is_main)
                                        Main account
                                    @endif
                                </span>
                            </td>
                            <td class="account account--balance">{{ $account->amount }}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ url('/send-payment/form') }}" class="btn btn-success">
                                            Send Payment
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ url('/send-self/form') }}" class="btn btn-success">
                                            Send money between my accounts
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ url('/generate-report/' . $account->id) }}" class="btn btn-info">
                                            Generate Report
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
