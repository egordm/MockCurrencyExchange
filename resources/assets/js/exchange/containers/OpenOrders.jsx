import React, {Component} from 'react';
import {connect} from 'react-redux';

import OrderList from '../components/OrderList';
import {format} from "d3-format";

function openOrderFormatter(column, data) {
	switch (column) {
		case 'price':
			return format("(.2f")(data[column]);
		case 'amount':
			return format("(.4f")(data.quantity);
		case 'total':
			return format("(.4f")(data.quantity * data.price);
		default:
			return null;
	}
}

@connect((store) => {
	return {
		open_orders: store.market_data.depth,
		order_history: store.market_data.history
	};
})
export default class OpenOrders extends Component {
	shouldComponentUpdate(nextProps) {
		return nextProps.open_orders !== this.props.open_orders;
	}

	render() {
		if (!this.props.open_orders) return <p>Loading...</p>;
		const {order_history} = this.props;

		const last_order = order_history && order_history.length > 0 ? order_history[0] : null;
		let price_label = '-';
		if(last_order) price_label = format("(.2f")(last_order.price) + ' ' + (last_order.buy ? '↑' : '↓');

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

			<OrderList tableClass={'ask'} dataFormatter={openOrderFormatter} data={this.props.open_orders.asks} columns={['price', 'amount', 'total']}/>
			<table className="table price-bar">
				<tbody>
				<tr>
					<th className={last_order ? (last_order.buy ? 'green' : 'red') : ''}>
						{price_label}
					</th>
				</tr>
				</tbody>
			</table>
			<OrderList tableClass={'bid'} dataFormatter={openOrderFormatter} data={this.props.open_orders.bids} columns={['price', 'amount', 'total']}/>
		</div>;
	}
}