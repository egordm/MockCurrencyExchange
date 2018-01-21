import React, {Component} from 'react';
import {connect} from "react-redux";
import * as DataActions from "../actions/DataActions";
import {bindActionCreators} from "redux";

@connect((store) => store.user_data, (dispatch) => {
	return {
		login: bindActionCreators(DataActions.login, dispatch)
	}
})
export default class LoginModal extends Component {
	state = {
		email: '',
		password: ''
	};

	handleInputChange = (e) => {
		this.setState({[e.target.name]: e.target.value});
	};

	handleSubmit = (e) => {
		e.preventDefault();
		this.props.login(this.state.email, this.state.password);
	};

	render() {
		if(this.props.logged_in) $('#login-modal').modal('hide');

		return <div className="modal modal-login fade" id="login-modal" tabIndex="-1" role="dialog" aria-hidden="true">
				<div className="modal-dialog">
					<div className="modal-content">
						<div className="modal-body">
							<h1 className="title text-center">Login</h1>
							<form onSubmit={this.handleSubmit}>
								<div className="form-group">
									<input type="email" className="form-control" name="email" placeholder="Enter email" value={this.state.email}
									       onChange={this.handleInputChange}/>
								</div>
								<div className="form-group">
									<input type="password" className="form-control" name="password" placeholder="Password" value={this.state.password}
									       onChange={this.handleInputChange}/>
								</div>

								<button type="submit" className="btn btn-primary">Login</button>
							</form>
							<small className="register-link">Or <a href="/register">register</a>.</small>
						</div>
					</div>
				</div>
			</div>;
	}
}
