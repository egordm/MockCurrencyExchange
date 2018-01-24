import React, {Component} from 'react';

import Navbar from './Navbar';
import OrderHistory from "./OrderHistory";
import OpenOrders from "./OpenOrders";
import ChartPanel from "./ChartPanel";
import TradePanel from "./TradePanel";
import MyOrdersPanel from "./MyOrdersPanel";
import LoginModal from "./LoginModal";
import MessageModal from "./MessageModal";
import IndicatorEditModal from "./IndicatorEditModal";

export default class Exchange extends Component {
	render() {
		return [
			<Navbar key="navbar"/>,
			<div key="main-content" className="wrapper">
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
			</div>,
			<LoginModal key="login"/>,
			<MessageModal key="message"/>,
			<IndicatorEditModal key="indicator"/>
		];
	}
}