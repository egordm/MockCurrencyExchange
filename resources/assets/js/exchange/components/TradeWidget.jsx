import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import PropTypes from "prop-types";

export default class TradeWidget extends Component {
	static propTypes = {
		submitCallback: PropTypes.func.isRequired,
		submitText: PropTypes.string,
		defaultPrice: PropTypes.number,
		availableQuantity: PropTypes.number,
	};

	static defaultProps = {
		submitText: 'Submit',
		defaultPrice: 1337,
		availableQuantity: 0,
	};

	state = {
		price: this.props.defaultPrice,
		quantity: 0
	};

	handleSubmit = (e) => {
		e.preventDefault();
		this.props.submitCallback(this.state.price, this.state.quantity)
	};

	handleChange = (e) => {
		this.setState({[e.target.name]: e.target.value});
	};

	render() {
		return <form onSubmit={this.handleSubmit}>
			<input type="text" name="price" value={this.state.price} onChange={this.handleChange}/>
			<input type="text" name="quantity" value={this.state.quantity} onChange={this.handleChange}/>
			<p>Total: {this.state.price * this.state.quantity}</p>
			<button type="submit">{this.props.submitText}</button>
		</form>;
	}
}