import React, {Component} from 'react';

import Navbar from './Navbar';
import OrderHistory from "./OrderHistory";
import OpenOrders from "./OpenOrders";
import ChartPanel from "./ChartPanel";
import TradePanel from "./TradePanel";
import TradeWidget from "../components/TradeWidget";

export default class Exchange extends Component {
	render() {
		return [
			<Navbar/>,
			<div className="wrapper">
				<div className="main-panel">
					<ChartPanel/>
					<div className="secondary-panel">

					</div>
				</div>
				<div className="sidebar">
					<div className="market-panel">
						<OpenOrders/>
						<OrderHistory/>
					</div>
					<div className="trade-panel">
						<TradePanel/>
					</div>
				</div>
			</div>
		];
	}
}