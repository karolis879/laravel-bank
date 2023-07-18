<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holder;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;


class HolderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $holders = Holder::orderBy('last_name')->paginate(5)->withQueryString();
    
        return view('holders.index', [
            'holders' => $holders
        ]);
    }
    
    


    public function preview(Request $request)
    {
        $holder = Holder::findOrFail($request->holder);
        $accounts = $holder->accounts()->paginate(10); // Assuming you want to paginate with 10 accounts per page
    
        return view('accounts.preview', [
            'holder' => $holder,
            'accounts' => $accounts,
        ]);
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('holders.create');
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

        $existingAccount = Holder::where('personal_id', $request->PersonId)->first();
        if ($existingAccount) {
            return redirect()->back()->withErrors(['PersonId' => 'Personal ID already exists!']);
        }

        $account = new Holder;
        $account->first_name = $request->name;
        $account->last_name = $request->lastName;
        $account->personal_id = $request->PersonId;
        $account->save();
        return redirect()->route('holders-index')->with('success', 'Sveikinimai!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Holder $holder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holder $holder)
    {
        return view('holders.edit', [
            'holder' => $holder
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Holder $holder)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:50|min:3|alpha',
            ],
            [
                'name.required' => 'Please enter author name!',
                'name.max' => 'Author name is too long!',
                'name.min' => 'Author name is too short!',
                'name.alpha' => 'Author name must contain only letters!',
            ]
        );

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $holder->first_name = $request->name;
        $holder->last_name = $request->lastName;
        $holder->save();
        return redirect()->route('holders-index');
    }


    public function delete(Holder $holder)
    {
        $balance = $holder->accounts()->sum('balance');
        if ($balance > 0) {
            return redirect()->back()->with('info', 'Cannot delete holder because it has accounts with a non-zero balance!');
        }

        return view('holders.delete', [
            'holder' => $holder
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holder $holder)
    {
        $balance = $holder->accounts()->sum('balance');
        if ($balance > 0) {
            return redirect()->back()->with('info', 'Cannot delete holder because it has accounts with a non-zero balance!');
        }

        $holder->delete();
        return redirect()->route('holders-index')->with('success', 'Holder has been deleted!');
    }
}
