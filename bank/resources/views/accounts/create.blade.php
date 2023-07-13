@extends('layouts.app')

@section('content')

<div class="container">
    <div class= "row justify-content-center">
        <div class="col-md-4">
            <h1>Sukurti sąskaitą</h1>
            <form action="{{ route('bank-store') }}" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Vardas</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name" placeholder="Įveskite vardą" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Pavardė</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="lastName" rows="1" placeholder="Įveskite pavardę" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Asmens kodas</label>
                    <input type="number" class="form-control" id="exampleFormControlTextarea1" name="PersonId" rows="1" placeholder="Įveskite asmens kodą" required></input>
                </div>
                <div class= "row justify-content-center">
                    <button class="btn btn-dark" style="width:95%" type="submit">Sukurti</button>
                    @csrf
                </div>
            </form>
        </div>
    </div>
</div>
@endsection