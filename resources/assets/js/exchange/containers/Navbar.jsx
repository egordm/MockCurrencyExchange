import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import MarketSelector from "./MarketSelector";

export default class Navbar extends Component {
	render() {
		return <nav>
			<MarketSelector/>
		</nav>;
	}
}