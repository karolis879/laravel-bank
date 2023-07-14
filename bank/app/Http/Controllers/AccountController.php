<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $accounts = Account::all();

        return view('accounts.index', [
            'account' => $accounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:50|min:3|alpha',
                'lastName' => 'required',
                'PersonId' => [
                    'required',
                    'integer',
                    'regex:/^(3[0-9]{2}|4[0-9]{2}|6[0-9]{2}|5[0-9]{2})(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])\d{4}$/'
                ],
            ],
            [
                'name.required' => 'First name required!',
                'lastName.required' => 'Last name required!',
                'PersonId.required' => 'Personal id required!',
                'PersonId.regex' => 'Personal id incorrect!',

            ]
        );

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $existingAccount = Account::where('personal_id', $request->PersonId)->first();
        if ($existingAccount) {
            return redirect()->back()->withErrors(['PersonId' => 'Personal ID already exists!']);
        }

        $account = new Account;
        $account->first_name = $request->name;
        $account->last_name = $request->lastName;
        $account->personal_id = $request->PersonId;
        $account->iban = Account::generateIban();
        $account->balance = 0;
        $account->save();
        return redirect()->route('bank-index')->with('success', 'Sveikinimai!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return view('accounts.edit', [
            'account' => $account
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validator = Validator::make($request->all(), [
            'funds' => 'required|integer|min:0',
        ], [
            'funds.required' => 'Funds field is required!',
            'funds.integer' => 'Funds must be an integer!',
            'funds.min' => 'Funds must be a positive integer or zero!',
        ]);
    
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
    
        if ($request->has('addFunds')) {
            $addFunds = $request->funds;
            $account->balance += $addFunds;
        } elseif ($request->has('removeFunds')) {
            $removeFunds = $request->funds;
            if ($removeFunds > $account->balance) {
                return redirect()->back()->withErrors(['funds' => 'Insufficient balance to remove!']);
            }
            $account->balance -= $removeFunds;
        }
    
        $account->save();
        return redirect()->route('bank-index');
    }
    

    public function delete(Account $account)
    {
        return view('accounts.delete', [
            'account' => $account
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('bank-index');
    }
}
