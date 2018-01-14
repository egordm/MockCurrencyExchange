import React, {Component} from 'react';
import {connect} from "react-redux";
import {bindActionCreators} from "redux";
import * as DataActions from "../actions/DataActions";

@connect((store) => {
	return {
		market: store.market_data.market,
		market_id: store.market_data.market_id,
		markets: store.market_data.markets
	};
}, (dispatch) => {
	return {
		getMarkets: bindActionCreators(DataActions.getMarkets, dispatch)
	}
})
export default class MarketSelector extends Component {

	componentDidMount() {
		this.props.getMarkets();
	}

	renderMarket = market => {
		const identifier = `${market.valuta_primary.symbol}_${market.valuta_secondary.symbol}`;
		return <a key={identifier} className="dropdown-item">{identifier.replace('_', '/')}</a>;
	};

	render() {
		return <div className="dropdown market-selector">
			<button className="btn dropdown-toggle" type="button" id="market-selection" data-toggle="dropdown">{this.props.market.replace('_', '/')}</button>
			<div className="dropdown-menu" aria-labelledby="market-selection">
				{this.props.markets ? this.props.markets.map(market => this.renderMarket(market)) : <p>Loading</p>}

			</div>
		</div>;
	}
}