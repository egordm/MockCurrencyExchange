@extends('layouts.default')

@section('content')
    <section class="section section-gray text-center">
        <h1>Balance</h1>
        @foreach ($balances as $balance)
            <li class="list-group-item">
                {{$balance->valuta->name}}
                {{$balance->quantity}}
            </li>
        @endforeach
        <h1>Orders</h1>
        @foreach ($orders as $order)
            <li class="list-group-item">
                {{$order->valuta_pair->valuta_primary->name}}
                {{$order->price}}
                {{'for'}}
                {{$order->valuta_pair->valuta_secondary->name}}
                {{$order->quantity}}
                @if($order->status==0)
                    {{'open'}}
                    @else
                {{'closed'}}
                    @endif
            </li>
        @endforeach
        <h1>Total Balance</h1>
        {{$convertedbalance}}
    </section>
@endsection
