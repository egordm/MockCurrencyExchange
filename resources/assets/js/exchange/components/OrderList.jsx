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
		dataFormatter: PropTypes.func,
		renderHeader: PropTypes.bool,
		scrollBottom: PropTypes.bool,
	};

	static defaultProps = {
		dataFormatter: formatData,
		renderHeader: false,
		scrollBottom: false
	};

	scrollToBottom = () => {
		if(this.props.scrollBottom) this.wrapper.scrollTop = this.wrapper.scrollHeight - this.wrapper.clientHeight;
	};

	componentDidMount() {
		this.scrollToBottom();
	};

	componentDidUpdate() {
		this.scrollToBottom();
	};

	renderOrder = (order, i) => {
		let columnData = [];
		let type = this.props.typeField ? this.props.dataFormatter(this.props.typeField, order) : '';
		for(let column of this.props.columns) columnData.push(<td className={column} key={column}>{this.props.dataFormatter(column, order)}</td>)
		return <tr key={i} className={type}>{columnData}</tr>;
	};

	shouldComponentUpdate(nextProps) {
		// TODO: Not sure if this works
		return this.props.data !== nextProps.data;
	}

	renderHeader() {
		return <tr>
				{this.props.columns.map((el) => <th key={el}>{el}</th>)}
			</tr>;
	}

	render() {
		return <div className="table-wrapper" ref={(el) => { this.wrapper = el; }}>
			<table className={'table order-table ' + this.props.tableClass}>
				<tbody>
				{this.props.renderHeader ? this.renderHeader() : null}
				{this.props.data.map(this.renderOrder)}
				</tbody>
			</table>
		</div>;
	}
}