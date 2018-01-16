import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import MarketSelector from "./MarketSelector";

export default class Navbar extends Component {
	render() {
		return <nav>
            <ul>
                <li>
                    <a className= "logo" href="https://crypto-mex.ml/" >
						<img src="/images/logo.png" width="40" hight="40" alt="LOGO"></img>
                    </a>
                </li>

                <li><MarketSelector/></li>


                <li><a href="url">Portfolio</a></li>
                <li><a href="url">Trade History</a></li>
                <li><a href="url">Wallet</a></li>
                <li><a href="url">Account</a></li>
                <li><a href="url">Settings</a></li>
                <li><a href="url">Logout</a></li>

                <li className="float-right"><a href="url">Register</a></li>
                <li className="loginbutton"><a href="url">Login</a></li>
            </ul>
		</nav>;
	}
}