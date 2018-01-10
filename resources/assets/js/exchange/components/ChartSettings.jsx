import React, {Component} from 'react';
import {Indicators} from '../constants/IndicatorTypes';
import {Tools} from '../constants/ToolTypes';
import {intervalDays, intervalHours, intervalMinutes} from '../constants/ChartSettings';

export default class ChartSettings extends Component {
	settingChanged(setting, option) {
		console.log('Indicator selected ' + option.value)
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
			{label: 'Hours', value: 'INTERVAL', options: intervalHours},
			{label: 'Days', value: 'INTERVAL', options: intervalDays},
			{label: 'Indicator', value: 'INDICATOR', options: Indicators},
			{label: 'Tool', value: 'TOOL', options: Tools},
		];
		return <div className="chart-settings">
			{settings.map(this.renderDropdown)}
		</div>;
	}
}