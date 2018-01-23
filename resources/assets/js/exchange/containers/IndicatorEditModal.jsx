import React, {Component} from 'react';
import {bindActionCreators} from "redux";
import {connect} from "react-redux";
import * as ChartActions from "../actions/ChartActions";
import {formatField} from "../utils/DataFormating";
import ColorPicker from "../components/ColorPicker";

@connect((store) => {
	return {
		charts: store.charting.charts,
		editing_indicator: store.charting.editing_indicator
	}
}, (dispatch) => {
	return {
		saveIndicator: bindActionCreators(ChartActions.saveIndicator, dispatch),
		editIndicator: bindActionCreators(ChartActions.editIndicator, dispatch),
		deleteIndicator: bindActionCreators(ChartActions.deleteIndicator, dispatch),
	}
})
export default class IndicatorEditModal extends Component {
	componentDidMount() {
		const editIndicator = this.props.editIndicator;
		$('#modal-indicator').on('hide.bs.modal', function (e) {
			editIndicator(null);
		})
	}

	handleSubmit = (e) => {
		e.preventDefault();
		const indicator = this.props.charts[0].indicators[this.props.editing_indicator];
		if(!indicator) return;

		const newIndicator = {
			type: indicator.type,
			options: {...indicator.options},
			styling: {...indicator.styling}
		};

		for(const field of indicator.getFillableOptions()) {
			if(!(field.name in this.state)) continue;
			const fieldPath = field.name.split('_');
			const fieldName = fieldPath.splice(fieldPath.length - 1)[0];
			let option = newIndicator;
			for(let path of fieldPath) {
				option = option[path];
			}
			option[fieldName] = formatField(field.format, this.state[field.name]);
		}

		this.props.saveIndicator(this.props.editing_indicator, newIndicator)
	};

	handleInputChange = (e) => {
		this.setState({[e.target.name]: e.target.value});
	};

	renderField = (field, i) => {
		const input = field.type === 'color'
			? <ColorPicker onChange={this.handleInputChange} defaultValue={field.value} name={field.name}/>
			: <input className="form-control" onChange={this.handleInputChange} type={field.type} name={field.name} defaultValue={field.value} {...field.props} required/>;
		return <div key={i} className="form-group">
			<label>{field.label}</label>
			{input}
		</div>;
	};

	renderForm = () => {
		const indicator = this.props.charts[0].indicators[this.props.editing_indicator];
		if(!indicator) return null;
		return <div className="modal-content">
			<div className="modal-header">
				<h5 className="modal-title">{indicator.type.label}</h5>
				<button type="button" className="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div className="modal-body">
				<form onSubmit={this.handleSubmit}>
					{indicator.getFillableOptions().map(this.renderField)}
					<button type="submit" className="btn btn-primary">Apply</button>
					<button className="btn btn-danger" onClick={() => this.props.deleteIndicator(this.props.editing_indicator)}>Delete</button>
				</form>
			</div>
		</div>
	};

	render() {
		if (!this.props.editing_indicator && this.props.editing_indicator !== 0) $('#modal-indicator').modal('hide');
		if (this.props.editing_indicator || this.props.editing_indicator === 0) $('#modal-indicator').modal('show');
		return <div className="modal modal-indicator fade" id="modal-indicator" tabIndex="-1" role="dialog" aria-hidden="true">
			<div className="modal-dialog">
				{this.props.editing_indicator !== null ? this.renderForm() : null}
			</div>
		</div>;
	}
}