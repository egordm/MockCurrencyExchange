import React, {Component} from 'react';

import Navbar from './Navbar';
import OrderHistory from "./OrderHistory";
import OpenOrders from "./OpenOrders";

export default class Exchange extends Component {
	render() {
		return  [
			<Navbar/>,
			<div className="wrapper">
				<div className="main-panel">
					<div className="chart-panel">

					</div>
					<div className="secondary-panel">

					</div>
				</div>
				<div className="sidebar">
					<div className="market-panel">
						<OpenOrders/>
						<OrderHistory/>
					</div>
					<div className="trade-panel">

					</div>
				</div>
			</div>
		];
	}
}