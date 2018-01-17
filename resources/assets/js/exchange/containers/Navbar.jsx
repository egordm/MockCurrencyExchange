import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import Login from './Login';

export default class Navbar extends Component {
	render() {
		return <nav><Login/></nav>;
	}
}