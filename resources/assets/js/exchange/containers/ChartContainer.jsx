import React, {Component} from 'react';
import {connect} from "react-redux";
import PropTypes from "prop-types";

import ChartWidget from "../components/ChartWidget";
import ChartSettings from "../components/ChartSettings";
import {chartSettingHeight} from "../constants/ChartStyles";
import LoaderWidget from "../components/LoaderWidget";
import * as DataActions from "../actions/DataActions";
import {bindActionCreators} from "redux";

@connect((store) => {
	return {
		width: store.charting.width,
		height: store.charting.height,
		charts: store.charting.charts,
		tool: store.charting.tool,
		candles: store.market_data.candles,
		market: store.market_data.market,
		interval: store.market_data.interval,
		loading_more: store.market_data.loading_more,
	};
}, (dispatch) => {
	return {
		getCandles: bindActionCreators(DataActions.getCandles, dispatch),
	}
})
export default class ChartContainer extends Component {
	static propTypes = {
		index: PropTypes.number.isRequired,
	};

	shouldComponentUpdate(nextProps) {
		return this.props.width !== nextProps.width || this.props.height !== nextProps.height || this.props.candles !== nextProps.candles
			|| this.getChartSettings() !== nextProps.charts[this.props.index] || this.props.tool !== nextProps.tool;
	}

	getChartSettings = () => this.props.charts[this.props.index];

	loadMore = () => {
		if(!this.props.candles || this.props.loading_more) return;
		this.props.getCandles(this.props.market, this.props.interval, null, this.props.candles[0]['open_time'])
	};

	renderChart = () => {
		if (!this.props.candles || this.props.candles.length === 0) return <LoaderWidget/>;
		return <ChartWidget index={this.props.index} ref={(el) => { this.chartComponent = el;}}
		                    width={this.props.width} height={this.props.height - chartSettingHeight}
		                    data={this.props.candles}
		                    settings={this.getChartSettings()}
		                    tool={this.props.tool}
		                    loadMore={this.loadMore}/>;
	};

	render() {
		return <div className="chart-component" style={{width: this.props.width, height: this.props.height}}>
			<div className="chart-widget">
				<ChartSettings index={this.props.index}/>
				{this.renderChart()}
			</div>
		</div>;
	}
}