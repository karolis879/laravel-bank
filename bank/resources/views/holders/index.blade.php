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
                    <th scope="col">Balansas</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            @forelse($holder as $holders) 
            <tbody>
                    <tr>
                        <td>{{ $holders->first_name }}</td>
                        <td>{{  $holders->last_name  }}</td>
                        <td>[{{ $holders->accounts()->count() }}]</td>
                        <td>
                            <div style="display: flex; gap:20px">
                                <a class="btn btn-secondary" href="{{ route('holders-edit', $holders) }}">Keisti</a>
                                <a class="btn btn-secondary" href="{{ route('holders-delete', $holders) }}">Ištrinti</a>
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