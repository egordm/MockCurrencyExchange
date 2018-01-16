@extends('layouts.default')

@section('content')
    <section class="section section-gray text-center">
        <h1>Portfolio</h1>
        @foreach (Auth::user()->balances as $balance)
            <li class="list-group-item">
                {{$balance->valuta_id}}
                {{$balance->quantity}}
            </li>
            @endforeach
    </section>
@endsection

