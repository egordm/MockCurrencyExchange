import React, {Component} from 'react';
import {bindActionCreators} from "redux";
import {connect} from "react-redux";

import * as ChartActions from '../actions/ChartActions'
import ChartContainer from "./ChartContainer";
import DepthChart from "./DepthChart";

@connect((store) => store.charting, (dispatch) => {
	return {
		resizeChart: bindActionCreators(ChartActions.resizeChart, dispatch)
	};
})
export default class ChartPanel extends Component {
	handleWindowResize = () => {
		let {width, height} = this.chart_panel.getBoundingClientRect();
		this.props.resizeChart(width, height);
	};

	componentWillUnmount() {
		window.removeEventListener("resize", this.handleWindowResize);
	}

	componentDidMount() {
		window.addEventListener("resize", this.handleWindowResize);
		this.handleWindowResize();
	}

	shouldComponentUpdate(nextProps) {
		return this.props.width !== nextProps.width || this.props.height !== nextProps.height;
	}

	renderCandleChart = (chart, i) => {
		return <ChartContainer key={i} index={i} width={this.props.width} height={this.props.height / this.props.charts.length}/>
	};

	renderDepthChart = () => {
		return <DepthChart width={this.props.width} height={this.props.height}/>
	};

	render() {
		return <div className="chart-panel tab-content" ref={(el) => { this.chart_panel = el;}}>
			<div className="chart-panel-header nav justify-content-end">
				<a className="btn nav-item active show" data-toggle="tab" role="tab" href="#candle-chart">Candles</a>
				<a className="btn nav-item" data-toggle="tab" role="tab" href="#depth-chart">Depth</a>
			</div>
			<div className="tab-pane fade show active" id="candle-chart">
				{this.props.charts.map(this.renderCandleChart)}
			</div>
			<div className="tab-pane fade" id="depth-chart">
				{this.renderDepthChart()}
			</div>
		</div>;
	}
}