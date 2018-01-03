@extends('layouts.exchange')

@section('content')
	<div class="main-panel">
		<div class="chart-panel">

		</div>
		<div class="secondary-panel">

		</div>
	</div>
	<div class="sidebar">
		<div class="market-panel">
			{{--Open orders per price / Depth data--}}
			<div class="orders-panel">
				<h3 class="panel-title text-center">Open Trades</h3>
				<table class="table order-table">
					<tr>
						<th>Price</th>
						<th>Amount</th>
						<th>Total</th>
					</tr>
				</table>
				{{--Asks/Sell orders--}}
				<div class="table-wrapper">
					<table class="table order-table ask">
						@for($i = 0; $i < 30; ++$i)
							<tr>
								<td class="price">{{number_format(rand(2000000, 1400000) / 100, 2)}}</td>
								<td class="amount">{{number_format(rand(100000, 0) / 100, 2)}}</td>
								<td class="total">{{number_format(rand(2000000, 0) / 100, 2)}}</td>
							</tr>
						@endfor
					</table>
				</div>
				{{--Last trade price--}}
				<table class="table price-bar">
					<tr>
						<th class="{{($buy = rand(0,1)) ? 'green' : 'red'}}">
							{{number_format(rand(2000000, 1400000) / 100, 2)}}{{$buy ? '↑' : '↓'}}
						</th>
					</tr>
				</table>
				{{--Bids/Buy orders--}}
				<div class="table-wrapper">
					<table class="table order-table bid">
						@for($i = 0; $i < 30; ++$i)
							<tr>
								<td class="price">{{number_format(rand(2000000, 1400000) / 100, 2)}}</td>
								<td class="amount">{{number_format(rand(100000, 0) / 100, 2)}}</td>
								<td class="total">{{number_format(rand(2000000, 0) / 100, 2)}}</td>
							</tr>
						@endfor
					</table>
				</div>
			</div>
			{{--Order history--}}
			<div class="orders-history-panel">
				<h3 class="panel-title text-center">Last Trades</h3>
				<table class="table order-table">
					<tr>
						<th>Price</th>
						<th>Amount</th>
						<th>Time</th>
					</tr>
				</table>
				<div class="table-wrapper">
					<table class="table order-table">
						@for($i = 0; $i < 60; ++$i)
							<tr>
								<td class="price {{rand(0,1) == 1 ? 'green' : 'red'}}">{{number_format(rand(2000000, 1400000) / 100, 2)}}</td>
								<td class="amount">{{number_format(rand(100000, 0) / 100, 2)}}</td>
								<td class="time">18:32:12</td>
							</tr>
						@endfor
					</table>
				</div>
			</div>
		</div>
		<div class="trade-panel">

		</div>
	</div>
@stop