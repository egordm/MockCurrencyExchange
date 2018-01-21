import React, {Component} from 'react';
import {connect} from "react-redux";
import {bindActionCreators} from "redux";
import {format} from "d3-format";
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
		return <tr key={market.symbol} onClick={() => this.props.setMarket(market)}>
			<td>{market.symbol.replace('_', '/')}</td>
			<td>{market.price ? format("(.2f")(market.price) : '-'}</td>
		</tr>
	};

	render() {
		return <div className="dropdown dropdown-menu-right market-selector">
			<button className="btn dropdown-toggle" type="button" id="market-selection" data-toggle="dropdown">{this.props.market.symbol.replace('_', '/')}</button>
			<div className="dropdown-menu" aria-labelledby="market-selection">
				<table>
					<tbody>
					<tr>
						<th>Pair</th>
						<th>Price</th>
					</tr>
					{this.props.markets ? Object.values(this.props.markets).map(market => this.renderMarket(market)) : <tr><td><p>Loading</p></td></tr>}
					</tbody>
				</table>

			</div>
		</div>;
	}
}