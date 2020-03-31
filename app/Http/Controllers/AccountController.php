<?php

namespace App\Http\Controllers;

use App\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showPaymentForm()
    {

        return view('send_payment');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function sendPayment(Request $request)
    {
        $accounts = DB::table('accounts')
            ->where('user_id','=', Auth::id())->get();

        if (Gate::allows('allow', $accounts[0])) {

            $recipientAccountId = DB::table('accounts')
                ->where('number', '=', $request->get('account'))
                ->value('id');

            $v = Validator::make($request->all(), []);
            // check for valid account
            if ($recipientAccountId === null) {
                $v->getMessageBag()->add('account', 'Invalid account number');
                return Redirect::back()->withErrors($v)->withInput();
            }

            $senderCurrentBalance = DB::table('accounts')
                ->where('user_id', '=', Auth::id())
                ->where('is_main', '=', true)
                ->value('amount');

            // check if enough funds
            if ($request->get('amount') > $senderCurrentBalance) {
                $v->getMessageBag()->add('amount', 'Insufficient funds');
                return Redirect::back()->withErrors($v)->withInput();
            }

            $validatedData = $request->validate([
                'account' => 'required',
                'name' => 'required',
                'lastname' => 'required',
                'amount' => 'required',
                'message' => 'required',
            ]);

            $senderAccountId = DB::table('accounts')
                ->where('user_id', '=', Auth::id())
                ->where('is_main', '=', true)
                ->value('id');

            $recipientCurrentBalance = DB::table('accounts')
                ->where('id', '=', $recipientAccountId)
                ->value('amount');

            $this->createOperations($senderAccountId, $recipientAccountId);

            $this->updateAccounts(
                $senderAccountId,
                $recipientAccountId,
                request('amount'),
                $senderCurrentBalance,
                $recipientCurrentBalance
            );

            return redirect('/');
        }

        return view('authorization_error');
    }

    public function createOperations(int $senderAccountId, int $recipientAccountId)
    {
        Operation::create([
            'account_id' => $senderAccountId,
            'in' => false,
            'out' => true,
            'message' => request('message'),
            'amount' => request('amount')
        ]);

        Operation::create([
            'account_id' => $recipientAccountId,
            'in' => true,
            'out' => false,
            'message' => request('message'),
            'amount' => request('amount')
        ]);
    }

    private function updateAccounts(
        int $senderAccountId,
        int $recipientAccountId,
        float $amount,
        float $senderCurrentBalance,
        float $recipientCurrentBalance
    )
    {

        DB::table('accounts')
            ->where('id', $senderAccountId)
            ->update(['amount' => $senderCurrentBalance - $amount]);
        DB::table('accounts')
            ->where('id', $recipientAccountId)
            ->update(['amount' => $recipientCurrentBalance + $amount]);
    }

    public function showSelfPaymentForm()
    {
        $accounts = DB::table('accounts')
            ->where('user_id','=', Auth::id())->get();

        return view('send_self', compact('accounts'));
    }

    public function sendSelfPayment(Request $request)
    {

        $accounts = DB::table('accounts')
            ->where('user_id','=', Auth::id())->get();

        if (Gate::allows('allow', $accounts[0])) {
            $recipientAccountId = $request->get('toAccount');

            $v = Validator::make($request->all(), []);
            // check for valid account
            if ($recipientAccountId === null) {
                $v->getMessageBag()->add('toAccount', 'Invalid account number');
                return Redirect::back()->withErrors($v)->withInput();
            }

            $senderAccountId = $request->get('fromAccount');
            if ($senderAccountId === null) {
                $v->getMessageBag()->add('fromAccount', 'Invalid account number');
                return Redirect::back()->withErrors($v)->withInput();
            }

            $senderCurrentBalance = DB::table('accounts')
                ->where('id', '=', $senderAccountId)
                ->value('amount');
            // check if enough funds
            if ($request->get('amount') > $senderCurrentBalance) {
                $v->getMessageBag()->add('amount', 'Insufficient funds');
                return Redirect::back()->withErrors($v)->withInput();
            }

            $validatedData = $request->validate([
                'fromAccount' => 'required',
                'toAccount' => 'required',
                'amount' => 'required',
                'message' => 'required',
            ]);

            $recipientCurrentBalance = DB::table('accounts')
                ->where('id', '=', $recipientAccountId)
                ->value('amount');

            $this->createOperations(intval($senderAccountId), intval($recipientAccountId));

            $this->updateAccounts(
                intval($senderAccountId),
                intval($recipientAccountId),
                request('amount'),
                $senderCurrentBalance,
                $recipientCurrentBalance
            );

            return redirect('/');
        }

        return view('authorization_error');
    }
}
