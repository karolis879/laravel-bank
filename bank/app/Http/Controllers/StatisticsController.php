<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Holder;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $holders = Holder::all();
        $accounts = Account::all();

        return view('statistics', [
            'holders' => $holders,
            'accounts' => $accounts
        ]);
    }
}