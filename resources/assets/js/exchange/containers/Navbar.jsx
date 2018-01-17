import React, {Component} from 'react';
import MarketSelector from "./MarketSelector";
import {connect} from "react-redux";
import Login from './Login';

//TODO: is het merge-conflict opgelost?

@connect((store) => {
	return {
		logged_in: store.market_data.logged_in,
	};
})
export default class Navbar extends Component {
	render() {
		const navItems = this.props.logged_in ? [
			<li key="portfolio" className="nav-item"><a className="nav-link">Portfolio</a></li>,
			<li key="account" className="nav-item"><a className="nav-link">Account</a></li>,
			<li key="logout" className="nav-item"><a className="nav-link">Logout</a></li>,
		] : [
			<li key="login" className="nav-item"><a className="nav-link login"><Login/></a></li>,
			<li key="register" className="nav-item"><a className="nav-link">Register</a></li>,
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