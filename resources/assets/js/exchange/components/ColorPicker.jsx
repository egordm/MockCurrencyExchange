import React from 'react'
import reactCSS from 'reactcss'
import {SketchPicker} from 'react-color'
import PropTypes from "prop-types";

class ColorPicker extends React.Component {
	static propTypes = {
		name: PropTypes.string.isRequired,
		onChange: PropTypes.func.isRequired,
		defaultValue: PropTypes.string.isRequired,
	};

	state = {
		displayColorPicker: false,
		color: this.props.defaultValue,
	};

	handleClick = () => {
		this.setState({displayColorPicker: !this.state.displayColorPicker})
	};

	handleClose = () => {
		this.setState({displayColorPicker: false})
	};

	handleChange = (color) => {
		this.setState({color: color.hex});
		this.props.onChange({target: {name: this.props.name, value: this.state.color}})
	};

	render() {

		const styles = reactCSS({
			'default': {
				color: {
					height: '14px',
					borderRadius: '2px',
					background: this.state.color,
					width: '100%',
				},
				swatch: {
					padding: '5px',
					//background: '#fff',
					borderRadius: '1px',
					boxShadow: '0 0 0 1px rgba(0,0,0,.1)',
					display: 'inline-block',
					cursor: 'pointer',
					width: '100%',
				},
				popover: {
					position: 'absolute',
					zIndex: '2',
				},
				cover: {
					position: 'fixed',
					top: '0px',
					right: '0px',
					bottom: '0px',
					left: '0px',
				},
			},
		});

		return (
			<div>
				<div style={styles.swatch} onClick={this.handleClick}>
					<div style={styles.color}/>
				</div>
				{this.state.displayColorPicker ? <div style={styles.popover}>
					<div style={styles.cover} onClick={this.handleClose}/>
					<SketchPicker color={this.state.color} onChange={this.handleChange}/>
				</div> : null}

			</div>
		)
	}
}

export default ColorPicker;