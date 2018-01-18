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
		case 'date':
			return timeFormatter(new Date(data['updated_at']['date']));
		case 'pair':
			return `${data.valuta_pair.valuta_primary.symbol}/${data.valuta_pair.valuta_secondary.symbol}`; // TODO: full name
		case 'side':
			return <span className={data.buy ? 'green' : 'red'}>{data.buy ? 'buy' : 'sell'}</span>;
		case 'price':
			return format("(.2f")(data.price);
		case 'amount':
			return format("(.4f")(data.quantity);
		case 'filled':
			return format("(.2%")(data.filled_quantity / data.quantity);
		case 'total':
			return format("(.4f")(data.price * data.quantity);
		case 'state':
			let stateClass = '';
			if(data.status === 2) stateClass = 'red'; // TODO: magic strings
			if(data.status === 0) stateClass = 'green'; // TODO: magic strings
			return <span className={stateClass}>{orderStates[data.status]}</span>;
		case 'actions':
			return null;
		default:
			return null;
	}
}

@connect((store) => {
	return {
		logged_in: store.user_data.logged_in,
		orders: store.user_data.orders,
	};
}, (dispatch) => {
	return {
		getOrders: bindActionCreators(DataActions.getOrders, dispatch),
	}
})
export default class MyOrdersPanel extends Component {
	shouldComponentUpdate(nextProps) {
		return this.props.logged_in !== nextProps.logged_in || this.props.orders !== nextProps.orders;
	}

	render() {
		const orders = this.props.orders ? Object.values(this.props.orders) : [];
		const openOrders = this.props.orders ? orders.filter((el) => el.status === 0) : [];

		return <div className="secondary-panel">
			<div className="nav nav-tabs" id="nav-tab" role="tablist">
				<a className="nav-item nav-link active" data-toggle="tab" href="#open-orders" role="tab" aria-selected="true">Open Orders</a>
				<a className="nav-item nav-link" data-toggle="tab" href="#order-history" role="tab" aria-selected="false">Order History</a>
				<a className="nav-item nav-link" data-toggle="tab" href="#balance" role="tab" aria-selected="false">Balance</a>
			</div>
			<div className="tab-content">
				<div className="tab-pane fade show active" id="open-orders" role="tabpanel">
					<OrderList data={openOrders} dataFormatter={orderFormatter} renderHeader={true}
					           columns={['date', 'pair', 'side', 'price', 'amount', 'filled', 'total', 'state', 'actions']}/>
				</div>
				<div className="tab-pane fade" id="order-history" role="tabpanel">
					<OrderList data={orders} dataFormatter={orderFormatter} renderHeader={true}
					           columns={['date', 'pair', 'side', 'price', 'amount', 'filled', 'total', 'state', 'actions']}/>
				</div>
				<div className="tab-pane fade" id="balance" role="tabpanel">
					<h1>Balance</h1>
				</div>
			</div>
		</div>;
	}
}