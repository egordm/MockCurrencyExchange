import React, {Component} from 'react';
import {bindActionCreators} from "redux";
import {connect} from "react-redux";

import * as ChartActions from '../actions/ChartActions'
import ChartContainer from "./ChartContainer";

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

	renderChart = (chart, i) => {
		return <ChartContainer key={i} index={i} width={this.props.width} height={this.props.height / this.props.charts.length}/>
	};

	render() {
		return <div className="chart-panel" ref={(el) => { this.chart_panel = el;}}>
			{this.props.charts.map(this.renderChart)}
		</div>;
	}
}