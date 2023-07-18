@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Holder: {{ $holder->first_name }} {{ $holder->last_name }}</h1>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">IBAN</th>
                    <th scope="col">Balance</th>
                    <th scope="col"></th> <!-- Empty column for Actions -->
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->iban }}</td>
                        <td>{{ $account->balance }}</td>
                        <td>
                            <div style="display: flex; gap: 20px; justify-content: center;">
                                <a class="btn btn-secondary" href="{{ route('bank-edit', $account) }}">Keisti</a>
                                <a class="btn btn-secondary" href="{{ route('bank-delete', $account) }}">Ištrinti</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-md-12 mt-4">
            {{ $accounts->links() }}
        </div>
    </div>
@endsection
