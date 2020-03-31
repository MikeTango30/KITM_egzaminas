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
                        <th scope="col">Status</th>
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
                            <td class="operation operation--created">{{ $operation->updated_at }}</td>
                            <td class="operation operation--status">
                            @if($operation->is_pending)
                                Pending <span class="badge badge-pill"><a href="{{ url('/cancel-payment') }}" data-toggle="modal" data-target="#deleteModal">Cancel payment</a></span>
                            @endif
                            @if($operation->is_canceled)
                                Canceled
                            @endif
                            @if(!$operation->is_canceled && !$operation->is_pending)
                                Confirmed
                            @endif
                            </td>
                        </tr>
                        <!-- Really Delete Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                             aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm cancel payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Cancel payment?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abort</button>
                                        <a href="/payment/cancel/{{ $operation->id }}" class="btn btn-danger">Cancel Payment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
                {{ $operations->links() }}
            </div>
        </div>
    </div>
@stop
