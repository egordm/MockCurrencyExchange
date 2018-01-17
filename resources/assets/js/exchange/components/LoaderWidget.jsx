import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export default class LoaderWidget extends Component {
	render() {
		return <div className="loader-wrapper">
			<div className="spinner loader">
				<div className="bounce1"/>
				<div className="bounce2"/>
				<div className="bounce3"/>
			</div>
		</div>;
	}
}
