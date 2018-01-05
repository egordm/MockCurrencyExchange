import React, {Component} from 'react';
import {connect} from "react-redux";

@connect((store) => store.chart)
export default class ChartContainer extends Component {
	shouldComponentUpdate(nextProps) {
		return this.props.width !== nextProps.width || this.props.height !== nextProps.height;
	}

	render() {
		return <h1 style={{width:this.props.width, height: this.props.height, backgroundColor: '#ffffff'}}>Hello, {this.props.name}</h1>;
	}
}