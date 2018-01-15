import React, {Component} from 'react';
import {connect} from "react-redux";
import PropTypes from "prop-types";

import ChartWidget from "../components/ChartWidget";
import ChartSettings from "../components/ChartSettings";
import {chartSettingHeight} from "../constants/ChartStyles";

@connect((store) => {
	return {
		width: store.charting.width,
		height: store.charting.height,
		charts: store.charting.charts,
		candles: store.market_data.candles,
	};
})
export default class ChartContainer extends Component {
	static propTypes = {
		index: PropTypes.number.isRequired,
	};

	shouldComponentUpdate(nextProps) {
		return this.props.width !== nextProps.width || this.props.height !== nextProps.height || this.props.candles !== nextProps.candles
			|| this.getChartSettings() !== nextProps.charts[this.props.index];
	}

	getChartSettings = () => this.props.charts[this.props.index];

	renderChart = () => {
		if (!this.props.candles || this.props.candles.length === 0) return <p>Loading...</p>;
		return <ChartWidget index={this.props.index} ref={(el) => { this.chartComponent = el;}}
		                    width={this.props.width} height={this.props.height - chartSettingHeight}
		                    data={this.props.candles}
		                    settings={this.getChartSettings()}/>;
	};

	render() {
		return <div className="chart-component">
			<div className="chart-widget">
				<ChartSettings index={this.props.index}/>
				{this.renderChart()}
			</div>
		</div>;
	}
}