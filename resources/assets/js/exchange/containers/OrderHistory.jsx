import React, {Component} from 'react';
import {connect} from 'react-redux';

import OrderList from '../components/OrderList';

class OrderHistory extends Component {
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

function mapStateToProps(state) {
	return {
		order_history: state.order_history
	};
}

export default connect(mapStateToProps)(OrderHistory);
