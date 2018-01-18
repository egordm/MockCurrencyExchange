import React, {Component} from 'react';
import PropTypes from "prop-types";
import {format} from "d3-format";

export default class TradeWidget extends Component {
	static propTypes = {
		submitCallback: PropTypes.func.isRequired,
		type: PropTypes.string.isRequired,
		submitText: PropTypes.string,
		defaultPrice: PropTypes.number,
		availableQuantity: PropTypes.number
	};

	static defaultProps = {
		submitText: 'Submit',
		defaultPrice: 1337,
		availableQuantity: 0,
	};

	state = {
		price: this.props.defaultPrice,
		quantity: ''
	};

	handleSubmit = (e) => {
		e.preventDefault();
		this.props.submitCallback(this.state.price, this.state.quantity)
	};

	handleChange = (e) => {
		this.setState({[e.target.name]: e.target.value});
	};

	render() {
		const actionName = this.props.type.replace(/\b\w/g, l => l.toUpperCase());
		return <div className="trade-widget" id="form">
			<div className="row trade-header">
				<div className="col-3">
					<h4 className="title">{actionName} BTC</h4>
				</div>
				<div className="col-9">

				</div>
			</div>
			<form onSubmit={this.handleSubmit}>
				<div className="form-group row">
					<label className="col-3 col-form-label" htmlFor={`price-${this.props.type}`}>Price:</label>
					<div className="col-9 input-group">
						<input type="text" id={`price-${this.props.type}`} name="price" className="form-control" placeholder="0.00" autoComplete="off"
						       value={this.state.price} onChange={this.handleChange}/>
						<div className="input-group-append">
							<div className="input-group-text">USDT</div>
						</div>
					</div>
				</div>
				<div className="form-group row">
					<label className="col-3 col-form-label" htmlFor={`amount-${this.props.type}`}>Amount:</label>
					<div className="col-9 input-group">
						<input type="text" id={`amount-${this.props.type}`} name="quantity" className="form-control" placeholder="0.00" autoComplete="off"
						       value={this.state.quantity} onChange={this.handleChange}/>
						<div className="input-group-append">
							<div className="input-group-text">BTC</div>
						</div>
					</div>
				</div>
				<div className="form-group trade-total row">
					<div className="col-3 col-form-label">Total:</div>
					<div className="col-9 col-form-label display-label">{format("(.2f")(this.state.price * this.state.quantity)} USDT</div>
				</div>

				<button type="submit" className={`btn ${this.props.type}`}>{actionName}</button>
			</form>
		</div>;

	}
}

