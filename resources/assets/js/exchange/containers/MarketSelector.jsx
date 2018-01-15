import React, {Component} from 'react';
import {connect} from "react-redux";
import {bindActionCreators} from "redux";
import * as DataActions from "../actions/DataActions";
import * as ExchangeAction from "../actions/ExchangeActions";

@connect((store) => {
	return {
		market: store.market_data.market,
		markets: store.market_data.markets
	};
}, (dispatch) => {
	return {
		getMarkets: bindActionCreators(DataActions.getMarkets, dispatch),
		setMarket: bindActionCreators(ExchangeAction.setMarket, dispatch),
	}
})
export default class MarketSelector extends Component {

	componentDidMount() {
		this.props.getMarkets();
	}

	renderMarket = market => {
		const identifier = `${market.valuta_primary.symbol}_${market.valuta_secondary.symbol}`;
		return <tr key={identifier} onClick={() => this.props.setMarket(market.id, identifier)}>
			<td>{identifier.replace('_', '/')}</td>
			<td>13299.00</td>
		</tr>
	};

	render() {
		return <div className="dropdown market-selector">
			<button className="btn dropdown-toggle" type="button" id="market-selection" data-toggle="dropdown">{this.props.market.symbol.replace('_', '/')}</button>
			<div className="dropdown-menu" aria-labelledby="market-selection">
				<table>
					<tbody>
					<tr>
						<th>Pair</th>
						<th>Price</th>
					</tr>
					{this.props.markets ? this.props.markets.map(market => this.renderMarket(market)) : <tr><td><p>Loading</p></td></tr>}
					</tbody>
				</table>

			</div>
		</div>;
	}
}