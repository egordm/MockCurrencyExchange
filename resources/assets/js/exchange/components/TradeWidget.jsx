import React, {Component} from 'react';
import PropTypes from "prop-types";
import {format} from "d3-format";

export default class TradeWidget extends Component {
	static propTypes = {
		submitCallback: PropTypes.func.isRequired,
		type: PropTypes.string.isRequired,
		market: PropTypes.object.isRequired,
		balance: PropTypes.object
	};

	state = {
		price: '',
		quantity: ''
	};

	componentWillReceiveProps(nextProps) {
		this.setState({price: nextProps.market.price});
	}


	handleSubmit = (e) => {
		e.preventDefault();
		this.props.submitCallback(this.state.price, this.state.quantity)
	};

	handleChange = (e) => {
		if(e.target.value < 99999999999) this.setState({[e.target.name]: e.target.value});
	};

	render() {
		const actionName = this.props.type.replace(/\b\w/g, l => l.toUpperCase());
		const market = this.props.market;
		const balance = this.props.balance ? this.props.balance.quantity - this.props.balance.halted : null;
		const price = this.state.price ? this.state.price : '';
		return <div className="trade-widget" id="form">
			<div className="row trade-header">
				<div className="col-3">
					<h4 className="title">{actionName} {market.valuta_secondary.symbol}</h4>
				</div>
				<div className="col-9 balance">
					<i className="material-icons">&#xE850;</i>
					<span> {balance ? format("(,.2f")(balance) : '-'}</span>
					<span> {this.props.type === 'buy' ? market.valuta_primary.symbol : market.valuta_secondary.symbol}</span>
				</div>
			</div>
			<form onSubmit={this.handleSubmit}>
				<div className="form-group row">
					<label className="col-3 col-form-label" htmlFor={`price-${this.props.type}`}>Price:</label>
					<div className="col-9 input-group">
						<input type="text" id={`price-${this.props.type}`} name="price" className="form-control" placeholder="0.00" autoComplete="off"
						       value={price} onChange={this.handleChange}/>
						<div className="input-group-append">
							<div className="input-group-text">{market.valuta_primary.symbol}</div>
						</div>
					</div>
				</div>
				<div className="form-group row">
					<label className="col-3 col-form-label" htmlFor={`amount-${this.props.type}`}>Amount:</label>
					<div className="col-9 input-group">
						<input type="text" id={`amount-${this.props.type}`} name="quantity" className="form-control" placeholder="0.00" autoComplete="off"
						       value={this.state.quantity} onChange={this.handleChange}/>
						<div className="input-group-append">
							<div className="input-group-text">{market.valuta_secondary.symbol}</div>
						</div>
					</div>
				</div>
				<div className="form-group trade-total row">
					<div className="col-3 col-form-label">Total:</div>
					<div className="col-9 col-form-label display-label">
						<span>{format("(,.2f")(this.state.price * this.state.quantity)}</span>
						<span> {this.props.type === 'buy' ? market.valuta_primary.symbol : market.valuta_secondary.symbol}</span>
					</div>
				</div>

				<button type="submit" className={`btn ${this.props.type}`}>{this.props.type === 'buy' ? 'Buy' : 'Sell'}</button>
			</form>
		</div>;

	}
}

