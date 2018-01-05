import React, {Component} from 'react';
import {connect} from 'react-redux';

import OrderList from '../components/OrderList';

@connect((store) => {
	return {
		order_history: store.order_history
	};
})
export default class OrderHistory extends Component {
	shouldComponentUpdate() {
		return false;
	}

	render() {
		return <div className="orders-history-panel">
			<h3 className="panel-title text-center">Last Trades</h3>
			<table className="table order-table">
				<tbody>
					<tr>
						<th>Price</th>
						<th>Amount</th>
						<th>Time</th>
					</tr>
				</tbody>
			</table>
			<OrderList typeField="type" columns={['price', 'amount', 'time']} data={this.props.order_history}/>
		</div>;
	}
}