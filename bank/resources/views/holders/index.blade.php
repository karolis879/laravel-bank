@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h1>Sąskaitų sąrašas</h1>
        </div>
        <table class="table table-dark table-striped" style="border-radius: 10px;">
            <thead>
                <tr>
                    <th scope="col">Vardas</th>
                    <th scope="col">Pavardė</th>
                    <th scope="col">Visų saskaitų suma</th>
                    <th scope="col"></th> <!-- Empty column for Actions -->
                </tr>
            </thead>
            <tbody>
                @forelse($holders as $holder)
                    <tr>
                        <td>{{ $holder->first_name }}</td>
                        <td>{{ $holder->last_name }}</td>
                        <td>[{{ $holder->accounts()->sum('balance') }}]</td>
                        <td>
                            <div style="display: flex; gap: 20px; justify-content: flex-end;">
                                <a class="btn btn-secondary" href="{{ route('holders-preview', $holder) }}">Peržiūrėti sąskaitas</a>
                                <a class="btn btn-secondary" href="{{ route('holders-edit', $holder) }}">Keisti</a>
                                <a class="btn btn-secondary" href="{{ route('holders-delete', $holder) }}">Ištrinti</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No saskaitos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="col-md-12 mt-4">
            {{ $holders->links() }}
        </div>
    </div>
@endsection
