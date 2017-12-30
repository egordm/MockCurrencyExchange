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
			<div class="orders-panel">
				<h3 class="panel-title text-center">Open Trades</h3>
				<div class="order-table-container">
					<table>
						<tr>
							<th>Price</th>
							<th>Amount</th>
							<th>Time</th>
						</tr>
					</table>
				</div>
			</div>
			<div class="orders-history-panel">
				<h3 class="panel-title text-center">Last Trades</h3>
				<div class="order-table-container">
					<table>
						<tr>
							<th>Price</th>
							<th>Amount</th>
							<th>Time</th>
						</tr>
						@for($i = 0; $i < 20; ++$i)
							<tr class="buy">
								<td class="price">13,455.10</td>
								<td class="amount">1.23</td>
								<td class="time">18:32:12</td>
							</tr>
							<tr class="sell">
								<td class="price">13,455.10</td>
								<td class="amount">1.23</td>
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