import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export default class LoaderWidget extends Component {
	render() {
		return <div className="loader-wrapper">
			<div className="spinner loader">
				<div class="bounce1"/>
				<div class="bounce2"/>
				<div class="bounce3"/>
			</div>
		</div>;
	}
}
