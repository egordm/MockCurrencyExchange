import React, {Component} from 'react';
import PropTypes from "prop-types";

function formatData(column, data) {
	return data[column];
}

export default class OrderList extends Component {
	static propTypes = {
		tableClass: PropTypes.string,
		data: PropTypes.array.isRequired,
		columns: PropTypes.array.isRequired,
		typeField: PropTypes.string, // TODO: get type recognizer function instead
		dataFormatter: PropTypes.func
	};

	static defaultProps = {
		dataFormatter: formatData
	};

	renderOrder = (order, i) => {
		let columnData = [];
		let type = this.props.typeField ? this.props.dataFormatter(this.props.typeField, order) : '';
		for(let column of this.props.columns) columnData.push(<td className={column} key={column}>{this.props.dataFormatter(column, order)}</td>)
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