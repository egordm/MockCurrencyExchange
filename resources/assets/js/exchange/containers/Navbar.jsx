import React, {Component} from 'react';
import MarketSelector from "./MarketSelector";
import {connect} from "react-redux";
import {bindActionCreators} from "redux";
import * as DataActions from "../actions/DataActions";

//TODO: is het merge-conflict opgelost?

@connect((store) => {
	return {
		logged_in: store.market_data.logged_in,
	};
}, (dispatch) => {
	return {
		logout: bindActionCreators(DataActions.logout, dispatch),
		user: bindActionCreators(DataActions.user, dispatch)
	}
})
export default class Navbar extends Component {
	componentDidMount() {
		this.props.user();
	}

	render() {
		const navItems = this.props.logged_in ? [
			<li key="portfolio" className="nav-item"><a className="nav-link" href='/portfolio'>Portfolio</a></li>,
			<li key="account" className="nav-item"><a className="nav-link" href='/account'>Account</a></li>,
			<li key="logout" className="nav-item"><a className="nav-link" onClick={this.props.logout}>Logout</a></li>,
		] : [
			<li key="login" className="nav-item"><a className="nav-link login" data-toggle="modal" data-target="#login-modal">Login</a></li>,
			<li key="register" className="nav-item"><a className="nav-link" href="/register">Register</a></li>,
		];

		return <nav className="navbar navbar-dark">
			<a className="navbar-brand" href="https://crypto-mex.ml/">
				<img className="logo" src="/images/logo.png" width="40" height="40" alt="C-MEX"/> Crypto-MEX
			</a>
			<ul className="navbar-nav ml-auto">
				<li className="nav-item"><MarketSelector/></li>
				{navItems}
			</ul>
		</nav>

	}
}