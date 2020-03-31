@extends('layouts.main')
@section('promo')
    @component('_partials.promo')
        @slot('title')
            <h1 class="my-auto w-100">{{ $account->number }} ({{ $account->amount }}EUR)</h1>
            <h4>Operations report</h4>
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
                        <th scope="col">Amount</th>
                        <th scope="col">Message</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($operations as $operation)
                        <tr>
                            <td class="operation operation--id">{{ $loop->index + 1 }}</td>
                            <td class="operation operation--amount">
                                @if($operation->out)
                                    -
                                @endif
                                {{ $operation->amount }}
                            </td>
                            <td class="operation operation--message">{{ ucfirst($operation->message) }}</td>
                            <td class="operation operation--modified">{{ $operation->updated_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $operations->links() }}
            </div>
        </div>
    </div>
@stop
