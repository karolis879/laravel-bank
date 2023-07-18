<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Holder;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $accounts = Account::all();

        $sortBy = $request->sort_by ?? '';
        $orderBy = $request->order_by ?? '';
        if ($orderBy && !in_array($orderBy, ['asc', 'desc'])) {
            $orderBy = '';
        }
        $filterBy = $request->filter_by ?? '';
        $filterValue = $request->filter_value ?? '0';
        $perPage = (int) $request->per_page ?? 20;

        if ($request->s) {

            $accounts = Account::where('balance', 'like', '%' . $request->s . '%')->paginate(20)->withQueryString();
        } else {

            $accounts = Account::select('accounts.*');

            //filtravimas
            $accounts = match ($filterBy) {
                'balance' => Account::where('balance', '=', $filterValue),
                default => Account::where('balance', '>', 0),
            };


            //rikiavimas
            $accounts = match ($sortBy) {
                'name' => $accounts->orderBy('id', $orderBy),
                'balance' => $accounts->orderBy('balance', $orderBy),
                default => $accounts
            };

            $accounts = $accounts->paginate($perPage)->withQueryString();
        }
        return view('accounts.index', [
            'accounts' => $accounts,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
            'filterBy' => $filterBy,
            'filterValue' => $filterValue,
            'perPage' => $perPage,
            's' => $request->s ?? ''
        ]);
    }

    public function transfer()
    {
        $accounts = Account::all();

        return view('accounts.transfer', [
            'accounts' => $accounts,
        ]);
    }

    /**
 * Process the fund transfer between accounts.
 */
public function transferFunds(Request $request)
{
    $validator = Validator::make($request->all(), [
        'from_account' => 'required|exists:accounts,id',
        'to_account' => 'required|exists:accounts,id',
        'amount' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }

    $fromAccount = Account::find($request->from_account);
    $toAccount = Account::find($request->to_account);
    $amount = $request->amount;

    if ($fromAccount->balance < $amount) {
        return redirect()->back()->withErrors(['amount' => 'Insufficient balance for the transfer.']);
    }

    // Perform the fund transfer
    $fromAccount->balance -= $amount;
    $fromAccount->save();

    $toAccount->balance += $amount;
    $toAccount->save();

    // Log the transfer details in a variable
    $transferDetails = [
        'from_account' => $fromAccount->iban,
        'to_account' => $toAccount->iban,
        'amount' => $amount,
    ];

    return view('accounts.transfer_confirmation', compact('transferDetails'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $holders = Holder::all(['id', 'first_name']); // Retrieve only the 'id' and 'first_name' columns
        return view('accounts.create', [
            'holders' => $holders
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'holder_id' => 'required|integer',
            ],
            [
                'holder_id.required' => 'Please select author!',
                'holder_id.integer' => 'Rate must be a number!',
            ]
        );



        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }



        $account = new Account;
        $account->iban = Account::generateIban();
        $account->holder_id = $request->holder_id;
        $account->balance = 0;
        $account->save();
        return redirect()->route('holders-index')->with('success', 'Sveikinimai!');
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
        $holders = Holder::all();
    
        return view('accounts.edit', [
            'account' => $account,
            'holders' => $holders
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
        $holder = Holder::find($account->holder_id);
        return redirect()->route('holders-preview', ['holder' => $holder]);
    }


    public function delete(Account $account)
    {
        $balance = $account->balance;
    
        if ($balance > 0) {
            return redirect()->back()->with('info', 'Cannot delete the account because it has a non-zero balance!');
        }
    
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
        $holder = Holder::find($account->holder_id);
        return redirect()->route('holders-preview', ['holder' => $holder]);
    }
}
