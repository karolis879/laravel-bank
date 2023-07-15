@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1>Sukurti sąskaitą</h1>
            <form method="post" action="{{ route('bank-store') }}">
               
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <select name="holder_id" class="form-select">
                        <option>Open this select menu</option>
                        @foreach ($holders as $holder)
                            <option value="{{ $holder->id }}" @if($holder->id == old('holder_id')) selected @endif>{{ $holder->first_name }}</option>
                        @endforeach
                    </select>
                </div>
           
                <button type="submit" class="btn btn-primary">Add</button>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
