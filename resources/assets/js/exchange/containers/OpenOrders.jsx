import React, {Component} from 'react';
import {connect} from 'react-redux';

import OrderList from '../components/OrderList';
import {format} from "d3-format";

@connect((store) => {
	return {
		open_orders: store.open_orders
	};
})
export default class OpenOrders extends Component {
	shouldComponentUpdate() {
		return false;
	}

	render() {
		let buy = Math.random() >= 0.5;

		return <div className="orders-panel">
			<h3 className="panel-title text-center">Open Trades</h3>
			<table className="table order-table">
				<tbody>
					<tr>
						<th>Price</th>
						<th>Amount</th>
						<th>Total</th>
					</tr>
				</tbody>
			</table>

			<OrderList tableClass={'ask'} data={this.props.open_orders.asks} columns={['price', 'amount', 'total']}/>
			<table className="table price-bar">
				<tbody>
					<tr>
						<th className={buy ? 'green' : 'red'}>
							{format("(.2f")(Math.random() * (20000 - 14000) + 14000)}{buy ? '↑' : '↓'}
						</th>
					</tr>
				</tbody>
			</table>
			<OrderList tableClass={'bid'} data={this.props.open_orders.bids} columns={['price', 'amount', 'total']}/>
		</div>;
	}
}