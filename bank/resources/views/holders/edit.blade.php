@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
        <h1>Atnaujinti saskaitą</h1>
            <form action="{{ route('holders-update', $holder) }}" method="post">
                <div class="mb-3">
                    <label for="last_name">Vardas</label>
                    {{ $holder->first_name }}
                    <input  class="form-control"  name="name" id="exampleFormControlInput1" placeholder="Įveskite vardą">
                </div>
                <div class="mb-3">
                    <label for="last_name">Pavardė</label>
                    {{ $holder->last_name }}
                    <input  class="form-control"  name="lastName" id="exampleFormControlInput1" placeholder="Įveskite pavardę">
                </div>
                <div style="display: flex; gap: 5px">
                    <button name="addFunds" class="btn btn-secondary" type="submit" class="mb-3">Patvirtinti</button>
                </div>
                <a href="{{ route('holders-index') }}">Atšaukti</a>
                @method('put')
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection