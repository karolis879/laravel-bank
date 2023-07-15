@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Patvirtinti sąskaitos trinimą</h5>
                <div class="card-body">
                    <h5 class="card-title">Ar tikrai norite ištrint šią sąskaitą?</h5>
                    <h2>{{ $holder-> first_name }}</h2>
                    
                        <form action="{{ route('holders-destroy', $holder) }}" method="post">
                            <div>
                                <button class="btn btn-dark" type="submit">Ištrinti</button>
                            </div>
                            <div>
                                <a  href="{{ route('holders-index') }}">Atšaukti</a>
                            </div>
                            @method('delete')
                            @csrf
                        </form>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                </div>
            </div>
        </div>
    </div>
    @endsection