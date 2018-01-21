import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import * as ExchangeActions from "../actions/ExchangeActions";
import {bindActionCreators} from "redux";
import {connect} from "react-redux";

@connect((store) => store.massage_data, (dispatch) => {
	return {
		hideMessageAction: bindActionCreators(ExchangeActions.hideMessageAction, dispatch),
	}
})
export default class MessageModal extends Component {
	componentDidMount() {
		const hideActions = this.props.hideMessageAction;
		$('#message-modal').on('hide.bs.modal', function (e) {
			hideActions();
		})
	}

	render() {
		$('#message-modal').modal('show');
		return <div className="modal modal-message fade" id="message-modal" tabIndex="-1" role="dialog" aria-hidden="true">
			<div className="modal-dialog">
				<div className="modal-content">
					<div className="modal-header">
						<h5 className="modal-title">{this.props.title}</h5>
						<button type="button" className="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div className="modal-body">
						<div className="text-center">
							{this.props.message}
						</div>
					</div>
				</div>
			</div>
		</div>;
	}
}