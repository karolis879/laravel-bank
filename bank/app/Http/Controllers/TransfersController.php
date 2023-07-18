<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Holder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransfersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function transfer()
    {
        $holders = Holder::all();
        $accounts = Account::all();

        return view('accounts.transfer', [
            'holders' => $holders,
            'accounts' => $accounts
        ]);
    }

    public function execute(Account $account, Request $request)
    {
        $amount = $request->amount;

            $validator = Validator::make(
            $request->all(),[
                'amount' => ['required', 'min:0', 'not_in:0', 'regex:/^0$|^[1-9]\d*$|^\.\d+$|^0\.\d*$|^[1-9]\d*\.\d*$/']
            ],
            [
                'amount.required' => 'Please enter the amount!',
                'amount.min', 'amount.not_in' => 'The amount must be a positive digit!'
            ]);

            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }

            $account = Account::find($request->from_account_id);
            $account2 = Account::find($request->to_account_id);
            // dump($account, $account2);
            // dump($account->id);

            if ($account->balance >= $request->amount){
                $account->balance -= $request->amount;
                $account2->balance += $request->amount;

                $account->save();
                $account2->save();
                return redirect()->back()->with('success', $amount . ' € from ' . $account->holder->first_name . ' ' . $account->holder->last_name . ' account No' . $account->iban . ' has been transfared to ' . $account2->holder->first_name . ' ' . $account2->holder->last_name . ' account No' . $account2->iban . '!');
            }

            return redirect()->back()->withErrors('Balance of ' . $account->holder->first_name . ' ' . $account->holder->last_name . ' account No ' . $account->iban . ' is insufficient for the transfer!');
    }

}