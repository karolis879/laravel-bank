@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1>Atnaujinti saskaitą</h1>
            <form action="{{ route('bank-update', $account) }}" method="post">
                <div class="mb-3">
                    <label for="first_name">Vardas: </label>
                    {{ $account->holder->first_name }}
                </div>
                <div class="mb-3">
                    <label for="last_name">Pavardė: </label>
                    {{ $account->holder->last_name }}
                </div>
                <div class="mb-3">
                    <label for="last_name">Saskaitos numeris: </label>
                    {{ $account->iban }}
                </div>
                <div class="mb-3">
                    <label for="last_name">Asmens kodas: </label>
                    {{ $account->holder->personal_id }}
                </div>
                <div class="mb-3">
                    <label for="last_name">Likutis: </label>
                    {{ $account->balance }}
                </div>
                <div class="mb-3">
                    <input class="form-control" type="number" name="funds" id="exampleFormControlInput1"
                        placeholder="Įveskite sumą">
                </div>
                <div style="display: flex; gap: 5px">
                    <button name="addFunds" class="btn btn-secondary" type="submit" class="mb-3">prideti</button>
                    <button class="btn btn-secondary" type="submit" name="removeFunds" class="mb-3">atimti</button>
                </div>
                <a href="{{ route('holders-preview', ['holder' => $account->holder_id]) }}">Atšaukti</a>
                @method('put')
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
