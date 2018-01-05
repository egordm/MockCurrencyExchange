import React, {Component} from 'react';
import { bindActionCreators } from "redux";
import {connect} from "react-redux";
export default class ChartPanel extends Component {
	shouldComponentUpdate() {
		return false;
	}

	render() {
		return <div className="chart-panel" ref={(el) => { this.chart_panel = el; }}>
		</div>;
	}
}