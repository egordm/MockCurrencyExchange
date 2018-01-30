@extends('layouts.default')

@section('content')
	<section class="section section-gray text-center">
		<div class="container">
			<h1>Balance</h1>
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>Currency</th>
						<th>Quantity</th>
						<th>Liquid quantity</th>
					</tr>
					</thead>
					<tbody>
					@foreach($balances as $balance)
						<tr>
							<td>{{$balance->valuta->name}}</td>
							<td>{{$balance->quantity}} {{$balance->valuta->symbol}}</td>
							<td>{{$balance->quantity - $balance->halted}} {{$balance->valuta->symbol}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="section section-white text-center">
		<div class="container">
			<h1>History</h1>
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>Buy/Sell</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Fee</th>
						<th>Status</th>
						<th>Filled Quantity</th>
						<th>Created At</th>
					</tr>
					</thead>
					<tbody>
					@foreach($orders as $order)
						<tr>
							<td>{{$order->buy ? 'Buy' : 'Sell'}}</td>
							<td>{{$order->price}}</td>
							<td>{{$order->quantity}}</td>
							<td>{{$order->fee}}</td>
							<td>{{App\Models\Order::STATUS_STRINGS[$order->status]}}</td>
							<td>{{$order->getFilledQuantity()}}</td>
							<td>{{$order->created_at}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			{{$orders->links()}}
		</div>
    </section>
        <section class="section section-gray text-center">
        <div class="container">
            <h1>Balance in USD</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                    {{'$'}} {{$convertedbalance}}
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

	</section>
@endsection
