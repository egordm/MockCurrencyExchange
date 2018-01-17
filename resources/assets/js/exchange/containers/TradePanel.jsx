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
			<div className="nav nav-tabs" id="nav-tab" role="tablist">
				<a className="nav-item nav-link active" data-toggle="tab" href="#limit-order" role="tab" aria-selected="true">Limit Order</a>
			</div>
			<div className="tab-content">
				<div className="tab-pane fade show active" id="limit-order" role="tabpanel">
					<TradeWidget key="buy" type="buy" defaultPrice={999} submitCallback={this.onBuy} submitText="Buy"/>
					<TradeWidget key="sell" type="sell" defaultPrice={999} submitCallback={this.onSell} submitText="Sell"/>
				</div>
			</div>
		</div>;
	}
}