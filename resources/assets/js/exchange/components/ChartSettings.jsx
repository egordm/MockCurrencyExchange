import React, {Component} from 'react';
import {connect} from "react-redux";
import {bindActionCreators} from "redux";

import {Indicators} from '../constants/IndicatorTypes';
import {Tools} from '../constants/ToolTypes';
import {intervalDays, intervalHours, intervalMinutes} from '../constants/ChartSettings';
import * as ChartActions from "../actions/ChartActions";
import PropTypes from "prop-types";

@connect((store) => store.charting, (dispatch) => {
	return {
		addIndicator: bindActionCreators(ChartActions.addIndicator, dispatch),
		setInterval: bindActionCreators(ChartActions.setInterval, dispatch),
		setTool: bindActionCreators(ChartActions.setTool, dispatch),
	};
})
export default class ChartSettings extends Component {
	static propTypes = {
		index: PropTypes.number.isRequired,
	};

	settingChanged(setting, option) {
		switch(setting.value) {
			case 'INDICATOR':
				return this.props.addIndicator(option, this.props.index);
			case 'INTERVAL':
				return this.props.setInterval(option);
			case 'TOOL':
				return this.props.setTool(option);
			default:
				console.log('Indicator selected ' + option.value)
		}
	}

	renderDropdown = (setting, i) => {
		const indentifier = setting.value + '-' + i;
		return <div className="dropdown chart-setting" key={indentifier}>
			<button className="btn dropdown-toggle" type="button" id={indentifier} data-toggle="dropdown">{setting.label}</button>
			<div className="dropdown-menu" aria-labelledby={indentifier}>
				{setting.options.map((el) =>
					<a key={setting.value + '-' + el.value} className="dropdown-item" onClick={() => this.settingChanged(setting, el)}>{el.label}</a>)}
			</div>
		</div>;
	};

	render() {
		const settings = [
			{label: 'Minute', value: 'INTERVAL', options: intervalMinutes},
			{label: 'Hour', value: 'INTERVAL', options: intervalHours},
			{label: 'Indicator', value: 'INDICATOR', options: Indicators},
			{label: 'Tool', value: 'TOOL', options: Tools},
		];
		return <div className="chart-settings">
			{settings.map(this.renderDropdown)}
		</div>;
	}
}