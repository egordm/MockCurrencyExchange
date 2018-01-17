import React, {Component} from 'react';
import OrderList from "../components/OrderList";
import {bindActionCreators} from "redux";
import * as DataActions from "../actions/DataActions";
import {connect} from "react-redux";
import {format} from "d3-format";
import {timeFormat} from 'd3-time-format';
import {orderStates} from "../constants/MarketConstants";

const timeFormatter = timeFormat('%e-%m-%Y %H:%M:%S');

function orderFormatter(column, data) {
	switch (column) {
		case 'date': return timeFormatter(new Date(data[column] * 1000));
		case 'pair': return `${data.valuta_pair.valuta_primary.symbol}/${data.valuta_pair.valuta_secondary.symbol}`; // TODO: full name
		case 'side': return data.buy ? 'buy' : 'sell';
		case 'price': return format("(.2f")(data.price);
		case 'amount': return format("(.4f")(data.quantity);
		case 'filled': return format("(.2%")(data.filled_quantity / data.quantity);
		case 'total': return format("(.4f")(data.price * data.quantity);
		case 'state': return orderStates[data.status];
		case 'actions': return null;
		default: return null;
	}
}

@connect((store) => {
	return {
		logged_in: store.market_data.logged_in,
		orders: store.market_data.orders,
	};
}, (dispatch) => {
	return {
		getOrders: bindActionCreators(DataActions.getOrders, dispatch),
	}
})
export default class MyOrdersPanel extends Component {
	componentDidMount() {
		if(this.props.logged_in) this.props.getOrders();
	}

	shouldComponentUpdate(nextProps) {
		return this.props.logged_in !== nextProps.logged_in || this.props.market !== nextProps.market;
	}

	render() {
		const openOrders = this.props.orders ? this.props.orders.filter((el) => el.status === 0) : [];
		const orders = this.props.orders ? this.props.orders : [];

		return <div className="secondary-panel">
			<div className="nav nav-tabs" id="nav-tab" role="tablist">
				<a className="nav-item nav-link active" data-toggle="tab" href="#open-orders" role="tab" aria-selected="true">Open Orders</a>
				<a className="nav-item nav-link" data-toggle="tab" href="#order-history" role="tab" aria-selected="false">Order History</a>
				<a className="nav-item nav-link" data-toggle="tab" href="#balance" role="tab" aria-selected="false">Balance</a>
			</div>
			<div className="tab-content">
				<div className="tab-pane fade show active" id="open-orders" role="tabpanel">
					<table className="table order-table">
						<tbody>
						<tr>
							<th>Date</th>
							<th>Pair</th>
							<th>Side</th>
							<th>Price</th>
							<th>Amount</th>
							<th>Filled%</th>
							<th>Total</th>
							<th>State</th>
							<th>Actions</th>
						</tr>
						</tbody>
					</table>
					<OrderList data={openOrders} dataFormatter={orderFormatter}
					           columns={['date', 'pair', 'side', 'price', 'amount', 'filled', 'total', 'state', 'actions']}/>
				</div>
				<div className="tab-pane fade" id="order-history" role="tabpanel">
					<OrderList data={orders} dataFormatter={orderFormatter}
					           columns={['date', 'pair', 'side', 'price', 'amount', 'filled', 'total', 'state', 'actions']}/>
				</div>
				<div className="tab-pane fade" id="balance" role="tabpanel">
					<h1>Balance</h1>
				</div>
			</div>
		</div>;
	}
}