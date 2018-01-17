import React, {Component} from 'react';
import {connect} from "react-redux";
import {bindActionCreators} from "redux";

import TradeWidget from "../components/TradeWidget";
import * as DataActions from "../actions/DataActions";

@connect((store) => {
	return {
		market_id: store.market_data.market_id
	}
}, (dispatch) => {
	return {
		createOrder: bindActionCreators(DataActions.createOrder, dispatch)
	}
})
export default class TradePanel extends Component {
	onBuy = (price, quantity) => {
		this.props.createOrder(this.props.market_id, price, quantity, true);
	};

	onSell = (price, quantity) => {
		this.props.createOrder(this.props.market_id, price, quantity, false);
	};

	render() {
		return <div className="trade-panel">
			<TradeWidget key="buy" defaultPrice={999} submitCallback={this.onBuy} submitText="Buy"/>,
			<TradeWidget key="sell" defaultPrice={999} submitCallback={this.onSell} submitText="Sell"/>
		</div>;
	}
}