/**
 * External dependencies.
 */
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import classNames from 'classnames';

/**
 * Internal dependencies.
 */
import { activateLicense } from './../state/ActivateLicense/actions.js';

class ActivateLicense extends Component {
	constructor(props) {
		super(props);

		this.state = {
			license: props.license,
		};

		this.handleChange = this.handleChange.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
	}

	componentWillMount() {
		this.props.activateLicense(this.props.license);
	}

	handleChange(event) {
		this.setState({
			validLicense: false,
			license: event.target.value
		});
	}

	handleSubmit(event) {
		event.preventDefault();

		this.props.activateLicense(this.state.license);
	}

	render() {
		const inputClass = classNames({
			'license': true,
			[`license--status-${this.props.validLicense ? 'valid' : 'invalid'}`]: true,
		});

		return (
			<form className="bigbox-activate-license" onSubmit={this.handleSubmit}>
				<input type="text" name="license" className={inputClass} value={this.state.license} onChange={this.handleChange} placeholde={BigBoxNUX.i18n.placeholder} />
				<input type="submit" name="submit" className="button button-primary" value={BigBoxNUX.i18n.activate} disabled={this.props.isSubmitting} />
			</form>
		);
	}
};

const mapStateToProps = (state, ownProps) => {
	return {
		license: state.license || ownProps.license,
		validLicense: state.validLicense || false,
		isSubmitting: state.isSubmitting || false,
	};
};

const mapDispatchToProps = (dispatch, ownProps) => {
	return bindActionCreators({
		activateLicense,
	}, dispatch);
};

export default connect(mapStateToProps, mapDispatchToProps)(ActivateLicense);
