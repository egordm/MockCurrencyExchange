import React, {Component} from 'react';
import PropTypes from "prop-types";

export default class OrderList extends Component {
	static propTypes = {
		tableClass: PropTypes.string,
		data: PropTypes.array.isRequired,
		columns: PropTypes.array.isRequired,
		typeField: PropTypes.string // TODO: get type recognizer function instead
	};

	renderOrder = (order, i) => {
		let columnData = [];
		let type = this.props.typeField ? order[this.props.typeField] : '';
		for(let column of this.props.columns) columnData.push(<td className={column} key={column}>{order[column]}</td>)
		return <tr key={i} className={type}>{columnData}</tr>;
	};

	shouldComponentUpdate() {
		return false;
	}

	render() {
		return <div className="table-wrapper">
			<table className={'table order-table ' + this.props.tableClass}>
				<tbody>
				{this.props.data.map(this.renderOrder)}
				</tbody>
			</table>
		</div>;
	}
}