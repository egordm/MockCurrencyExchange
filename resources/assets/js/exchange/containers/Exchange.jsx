import React, {Component} from 'react';

import Navbar from './Navbar';
import OrderHistory from "./OrderHistory";
import OpenOrders from "./OpenOrders";
import ChartPanel from "./ChartPanel";
import TradePanel from "./TradePanel";
import TradeWidget from "../components/TradeWidget";
import MyOrdersPanel from "./MyOrdersPanel";

export default class Exchange extends Component {
	render() {
		return [
			<Navbar/>,
			<div className="wrapper">
				<div className="main-panel">
					<ChartPanel/>
					<MyOrdersPanel/>
				</div>
				<div className="sidebar">
					<div className="market-panel">
						<OpenOrders/>
						<OrderHistory/>
					</div>
					<TradePanel/>
				</div>
			</div>
		];
	}
}