import React, {Component} from 'react';
import OrderList from "../components/OrderList";
import {bindActionCreators} from "redux";
import * as DataActions from "../actions/DataActions";
import {connect} from "react-redux";
import {format} from "d3-format";
import {timeFormat} from 'd3-time-format';
import {orderStates} from "../constants/MarketConstants";

const timeFormatter = timeFormat('%e-%m-%Y %H:%M:%S');

function balanceFormatter(column, data) {
	switch (column) {
		case 'currency': return data.valuta.name;
		case 'quantity': return `${format(`(,.${data.valuta.decimal_places}f`)(data.quantity)} ${data.valuta.symbol}`;
		case 'liquid_quantity': return `${format(`(,.${data.valuta.decimal_places}f`)(data.quantity - data.halted)} ${data.valuta.symbol}`;
	}
}

@connect((store) => {
	return {
		logged_in: store.user_data.logged_in,
		orders: store.user_data.orders,
		balance: store.user_data.balance,
	};
}, (dispatch) => {
	return {
		getOrders: bindActionCreators(DataActions.getOrders, dispatch),
		cancelOrder: bindActionCreators(DataActions.cancelOrder, dispatch),
	}
})
export default class MyOrdersPanel extends Component {
	orderFormatter = (column, data) => {
		switch (column) {
			case 'date': return timeFormatter(new Date(data['updated_at']['date']));
			case 'pair': return `${data.valuta_pair.valuta_primary.symbol}/${data.valuta_pair.valuta_secondary.symbol}`; // TODO: full name
			case 'side': return <span className={data.buy ? 'green' : 'red'}>{data.buy ? 'buy' : 'sell'}</span>;
			case 'price': return format(`(,.${data.valuta_pair.valuta_primary.decimal_places}f`)(data.price);
			case 'amount': return format(`(.${data.valuta_pair.valuta_secondary.decimal_places}f`)(data.quantity);
			case 'filled': return format("(.2%")(data.filled_quantity / data.quantity);
			case 'total': return format(`(,.${data.valuta_pair.valuta_primary.decimal_places}f`)(data.price * data.quantity);
			case 'state':
				let stateClass = '';
				if(data.status === 2) stateClass = 'red'; // TODO: magic strings
				if(data.status === 0) stateClass = 'green'; // TODO: magic strings
				return <span className={stateClass}>{orderStates[data.status]}</span>;
			case 'actions':
				return data.status === 0 ?
					<button className="btn btn-danger btn-cancel" onClick={() => this.props.cancelOrder(data.id)}>Cancel</button> : null;
			default:
				return null;
		}
	};

	render() {
		const orders = this.props.orders ? Object.values(this.props.orders).reverse() : [];
		const openOrders = this.props.orders ? orders.filter((el) => el.status === 0) : [];
		const balance = this.props.balance ? Object.values(this.props.balance) : [];

		return <div className="secondary-panel">
			<div className="nav nav-tabs" id="nav-tab" role="tablist">
				<a className="nav-item nav-link active" data-toggle="tab" href="#open-orders" role="tab" aria-selected="true">Open Orders</a>
				<a className="nav-item nav-link" data-toggle="tab" href="#order-history" role="tab" aria-selected="false">Order History</a>
				<a className="nav-item nav-link" data-toggle="tab" href="#balance" role="tab" aria-selected="false">Balance</a>
			</div>
			<div className="tab-content">
				<div className="tab-pane user-order-list fade show active" id="open-orders" role="tabpanel">
					<OrderList data={openOrders} dataFormatter={this.orderFormatter} renderHeader={true}
					           columns={['date', 'pair', 'side', 'price', 'amount', 'filled', 'total', 'state', 'actions']}/>
				</div>
				<div className="tab-pane user-order-list fade" id="order-history" role="tabpanel">
					<OrderList data={orders} dataFormatter={this.orderFormatter} renderHeader={true}
					           columns={['date', 'pair', 'side', 'price', 'amount', 'filled', 'total', 'state', 'actions']}/>
				</div>
				<div className="tab-pane fade" id="balance" role="tabpanel">
					<OrderList data={balance} dataFormatter={balanceFormatter} renderHeader={true}
					           columns={['currency', 'quantity', 'liquid_quantity']}/>
				</div>
			</div>
		</div>;
	}
}