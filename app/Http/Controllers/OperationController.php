<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OperationController extends Controller
{
    public function generateReport($accountId)
    {
        $account = DB::table('accounts')->find($accountId);

        if (Gate::allows('allow', $account)) {

            $operations = DB::table('operations')
                ->where('account_id', '=', $accountId)
                ->simplePaginate(10);

            return view('show_operations', compact('operations', 'account'));
        }

        return view('authorization_error');
    }

    public function cancel($operationId)
    {
        $operation = DB::table('operations')->find($operationId);
        if($operation->is_pending) {
            DB::table('operations')
                ->where('id', '=', $operationId)
                ->update([
                    'is_canceled' => true,
                    'is_pending'  => false
                    ]);
        }

        return view('todo');
    }
}
