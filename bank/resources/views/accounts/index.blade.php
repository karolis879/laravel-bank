@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Sorts and Filters</h4>
                    <form action="{{ route('bank-index') }}" method="get">
                        <fieldset>
                            <div class="row">
                                <div class="col-4">
                                    <select class="form-select" name="sort_by">
                                        <option value="" @if ('' == $sortBy) selected @endif>No sort
                                        </option>
                                        <option value="balance" @if ('balance' == $sortBy) selected @endif>Balance
                                        </option>
                                        <option value="name" @if ('name' == $sortBy) selected @endif>Name
                                        </option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" name="order_by">
                                        <option value="asc" @if ('asc' == $orderBy) selected @endif>ASC
                                        </option>
                                        <option value="desc" @if ('desc' == $orderBy) selected @endif>DESC
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-4">
                                    <select class="form-select" name="filter_by">
                                        <option value="" @if ('' == $filterBy) selected @endif>No filter
                                        </option>
                                        <option value="balance" @if ('balance' == $filterBy) selected @endif>Balance
                                        </option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" name="filter_value">
                                        @foreach (range(1, 100) as $number)
                                            <option value="{{ $number }}"
                                                @if ($number == $filterValue) selected @endif>
                                                {{ $number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 mt-4">
                                    <select class="form-select" name="per_page">
                                        @foreach ([20, 10, 5] as $number)
                                            <option value="{{ $number }}"
                                                @if ($number == $perPage) selected @endif>
                                                {{ $number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Go</button>
                                    <a class="btn btn-secondary" href="{{ route('bank-index') }}">Clear</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Find</h4>
                    <form action="{{route('bank-index')}}" method="get">
                        <fieldset>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control" name="s"
                                        value="{{$s ?? ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Find</button>
                                    <a class="btn btn-secondary" href="{{route('bank-index')}}">Clear</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>


        <h1>Sąskaitų sąrašas</h1>
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
            @forelse($accounts as $account)
                <tbody>
                    <tr>
                        <td>{{ $account->holder->first_name }}</td>
                        <td>{{ $account->holder->last_name }}</td>
                        <td>{{ $account->holder->personal_id }}</td>
                        <td>{{ $account->iban }}</td>
                        <td>{{ $account->balance }}</td>
                        <td>
                            <div style="display: flex; gap:20px">
                                <a class="btn btn-secondary" href="{{ route('bank-edit', $account) }}">Keisti</a>
                                <a class="btn btn-secondary" href="{{ route('bank-delete', $account) }}">Ištrinti</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <p>No saskaitos</p>
            @endforelse
            </tbody>
        </table>
        <div class="col-md-12 mt-4">
            {{ $accounts->links() }}
        </div>
    </div>
@endsection
