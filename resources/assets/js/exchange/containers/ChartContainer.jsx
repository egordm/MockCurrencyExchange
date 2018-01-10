import React, {Component} from 'react';
import {connect} from "react-redux";
import PropTypes from "prop-types";
import {bindActionCreators} from "redux";

import * as ChartActions from "../actions/ChartActions";
import ChartWidget from "../components/ChartWidget";
import ChartSettings from "../components/ChartSettings";
import {chartSettingHeight} from "../constants/ChartStyles";

@connect((store) => store.charting, (dispatch) => {
	return {
		requestData: bindActionCreators(ChartActions.requestData, dispatch),
	};
})
export default class ChartContainer extends Component {
	static propTypes = {
		index: PropTypes.number.isRequired,
	};

	componentDidMount() {
		if(!this.props.data) this.props.requestData();
	}

	shouldComponentUpdate(nextProps) {
		return this.props.width !== nextProps.width || this.props.height !== nextProps.height || this.props.data !== nextProps.data
			|| this.getChartSettings() !== nextProps.charts[this.props.index];
	}

	getChartSettings = () => this.props.charts[this.props.index];

	renderChart = () => {
		if (!this.props.data) return <p>Loading...</p>;
		return <ChartWidget index={this.props.index} ref={(el) => { this.chartComponent = el;}}
			width={this.props.width} height={this.props.height - chartSettingHeight}
			data={this.props.data}
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