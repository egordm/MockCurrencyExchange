import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import {login} from "../actions/DataActions"

//TODO: Fix bug waardoor tekst onzichtbaar is op login overlay
//TODO: Email en ww uit de adressbalk halen na een submit
//TODO: Testen of de login functie goed wordt uitgevoerd
//TODO: Betere startwaarde van email en ww in constructor this.state

export default class Login extends Component {
	constructor(props) {
		super(props);
		this.state = {
			email: null,
			password: null
		};

		this.handleInputChange = this.handleInputChange.bind(this);
	}

	handleInputChange(e) {
		this.setState({[e.target.name]: e.target.value});
	}

	handleSubmit(event) {
		login(this.state.email, this.state.password);
	}

	render() {
		return <li key="login" className="nav-item">
			<a className="nav-link login" data-toggle="modal" data-target="#myModal">Login</a>
			<div className="modal modal-login fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div className="modal-dialog">
					<div className="modal-content">
						<div className="modal-body">
							<form onSubmit={this.handleSubmit}>
								<div class="form-group">
									<input type="email" class="form-control" id="email" placeholder="Enter email" value={this.state.email}
									       onChange={this.handleInputChange}/>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="email" placeholder="Password" value={this.state.password}
									       onChange={this.handleInputChange}/>
								</div>

								<button type="submit" class="btn btn-primary">Login</button>
							</form>
							<small className="register-link">Or <a href="#">register</a>.</small>
						</div>
					</div>
				</div>
			</div>
		</li>;
	}
}


if (document.getElementById('login')) {
	ReactDOM.render(<Login/>, document.getElementById('login'));
}


