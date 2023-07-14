@extends('layouts.app')

@section('content')

<div class="container">
    <div>
        <h1>Sąskaitų sąrašas</h1>
    </div>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">Vardas</th>
                    <th scope="col">Pavardė</th>
                    <th scope="col">Asmens kodas</th>
                    <th scope="col">Sąskaitos numeris</th>
                    <th scope="col">Balansas</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            @forelse($account as $accounts) 
            <tbody>
                    <tr>
                        <td>{{ $accounts->first_name }}</td>
                        <td>{{  $accounts->last_name  }}</td>
                        <td>{{ $accounts->personal_id }}</td>
                        <td>{{ $accounts->iban }}</td>
                        <td>{{ $accounts->balance }}</td>
                        <td>
                            <div style="display: flex; gap:20px">
                                <a class="btn btn-secondary" href="{{ route('bank-edit', $accounts) }}">Keisti</a>
                                <a class="btn btn-secondary" href="{{ route('bank-delete', $accounts) }}">Ištrinti</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <p>No saskaitos</p>
                @endforelse
            </tbody>
        </table>
</div>

@endsection