import React, {Component} from 'react';
import {connect} from 'react-redux';

import OrderList from '../components/OrderList';
import {format} from "d3-format";

class OpenOrders extends Component {
	render() {
		let buy = Math.random() >= 0.5;

		return <div className="orders-panel">
			<h3 className="panel-title text-center">Open Trades</h3>
			<table className="table order-table">
				<tr>
					<th>Price</th>
					<th>Amount</th>
					<th>Total</th>
				</tr>
			</table>

			<OrderList tableClass={'ask'} data={this.props.open_orders.asks} columns={['price', 'amount', 'total']}/>
			<table className="table price-bar">
				<tr>
					<th className={buy ? 'green' : 'red'}>
						{format("(.2f")(Math.random() * (20000 - 14000) + 14000)}{buy ? '↑' : '↓'}
					</th>
				</tr>
			</table>
			<OrderList tableClass={'bid'} data={this.props.open_orders.bids} columns={['price', 'amount', 'total']}/>

		</div>;
	}
}

function mapStateToProps(state) {
	return {
		open_orders: state.open_orders
	};
}

export default connect(mapStateToProps)(OpenOrders);