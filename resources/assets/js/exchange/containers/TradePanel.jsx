import React, {Component} from 'react';
import {connect} from "react-redux";
import {bindActionCreators} from "redux";

import TradeWidget from "../components/TradeWidget";
import * as DataActions from "../actions/DataActions";

@connect((store) => {
	return {
		market: store.market_data.market,
		balance: store.user_data.balance
	}
}, (dispatch) => {
	return {
		createOrder: bindActionCreators(DataActions.createOrder, dispatch)
	}
})
export default class TradePanel extends Component {
	onBuy = (price, quantity) => {
		this.props.createOrder(this.props.market.id, price, quantity, true);
	};

	onSell = (price, quantity) => {
		this.props.createOrder(this.props.market.id, price, quantity, false);
	};

	render() {
		const market = this.props.market;
		const balanceBuy = this.props.balance ? this.props.balance[market.valuta_primary.id] : null;
		const balanceSell = this.props.balance ? this.props.balance[market.valuta_secondary.id] : null;
		return <div className="trade-panel">
			<div className="nav nav-tabs" id="nav-tab" role="tablist">
				<a className="nav-item nav-link active" data-toggle="tab" href="#limit-order" role="tab" aria-selected="true">Limit Order</a>
			</div>
			<div className="tab-content">
				<div className="tab-pane fade show active" id="limit-order" role="tabpanel">
					<TradeWidget key="buy" type="buy" market={market} balance={balanceBuy} submitCallback={this.onBuy}/>
					<TradeWidget key="sell" type="sell" market={market} balance={balanceSell}  submitCallback={this.onSell}/>
				</div>
			</div>
		</div>;
	}
}