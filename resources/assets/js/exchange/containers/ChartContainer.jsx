import React, {Component} from 'react';
import {connect} from "react-redux";
import PropTypes from "prop-types";
import {bindActionCreators} from "redux";

import * as ChartActions from "../actions/ChartActions";
import ChartWidget from "../components/ChartWidget";

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
		return this.props.width !== nextProps.width || this.props.height !== nextProps.height || this.props.data !== nextProps.data;
	}

	getChartSettings = () => this.props.charts[this.props.index];

	renderChart = () => {
		if (!this.props.data) return <p>Loading...</p>;
		return <ChartWidget ref={(el) => { this.chartComponent = el;}}
			width={this.props.width} height={this.props.height}
			data={this.props.data}
			settings={this.getChartSettings()}/>;
	};

	render() {
		return <div className="chart-component">
			<div className="chart-widget">
				{this.renderChart()}
			</div>
		</div>;
	}
}