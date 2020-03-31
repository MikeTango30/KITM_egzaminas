<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showAccount()
    {
        $accounts = DB::table('accounts')
            ->where('user_id','=', Auth::id())->get();

        if (Gate::allows('allow', $accounts[0])) {

            return view('/show_account', compact('accounts'));
        }

        return view('authorization_error');
    }
}
