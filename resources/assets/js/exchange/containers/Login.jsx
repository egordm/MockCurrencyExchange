import React, { Component } from 'react';
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
            Email: undefined,
            Password: undefined
        };

        this.handleInputChange = this.handleInputChange.bind(this);
    }

    handleInputChange(event) {
        const target = event.target;
        const name = target.name;

        this.setState({
            [name]: value
        });
    }
    handleSubmit(event){
        login(this.state.Email, this.state.Password);
    }

    render() {
        return [
            <div>
                <button type="button" className="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                    Login
                </button>

                <div className="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-body">
                                <form onSubmit={this.handleSubmit}>
                                    <label>
                                        Email:
                                        <input
                                            name="Email"
                                            type="text"
                                            value={this.state.Email}
                                            onChange={this.handleInputChange} />
                                    </label>
                                    <br />
                                    <label>
                                        Password:
                                        <input
                                            name="Password"
                                            type="password"
                                            value={this.state.Password}
                                            onChange={this.handleInputChange} />
                                    </label>
                                    <br />
                                    <input type="submit" value="Login" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        ];
    }
}


if (document.getElementById('login')) {
    ReactDOM.render(<Login />, document.getElementById('login'));
}


