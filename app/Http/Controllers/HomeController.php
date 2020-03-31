<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Account $account
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $accounts = Account::select('*')
            ->where('user_id','=', Auth::id());
        dd($accounts);
        if (Gate::allows('show', $account)) {

            return view('/home',compact($account));
        }

        return view('pages.authorization_error');
    }
}
