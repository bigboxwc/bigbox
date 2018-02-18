/**
 * External dependencies.
 */
import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import classNames from 'classnames';

/**
 * Internal dependencies.
 */
import { activateLicense } from './../state/ActivateLicense/actions.js';
import { INITIAL_STATE } from './../state/ActivateLicense/reducer.js';

// i18n bootstrapped in page.
const {
	licensePlaceholder,
	licenseSubmit,
	licenseValid,
	licenseInvalid,
	licenseLabel,
} = BigBoxNUX.i18n;

class ActivateLicense extends Component {
	constructor(props) {
		super(props);

		this.state = INITIAL_STATE;

		this.handleChange = this.handleChange.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
	}

	componentWillReceiveProps(nextProps) {
		this.setState(nextProps);
	}

	// Check license on page load.
	componentDidMount() {
		const {
			activateLicense,
			license,
		} = this.props;

		activateLicense(license);
	}

	// License key changed.
	handleChange(event) {
		this.setState({
			license: event.target.value,
			validLicense: false,
			isSubmitting: false,
		});
	}

	// Activate site on submit.
	handleSubmit(event) {
		event.preventDefault();

		this.props.activateLicense(this.state.license);
	}

	render() {
		const {
			license,
			validLicense,
			isSubmitting
		} = this.state;

		const licenseClass = classNames({
			'license': true,
			[`license--status-${validLicense ? 'valid' : 'invalid'}`]: true,
		});

		return [
			<form key="enter-license" className="bigbox-activate-license" onSubmit={this.handleSubmit}>
				<input type="text" name="license" className={licenseClass} value={license} onChange={this.handleChange} placeholder={licensePlaceholder} />
				<input type="submit" name="submit" className="button button-large button-primary" value={licenseSubmit} disabled={isSubmitting || validLicense} />
			</form>,
			
			<p key="license-status">
				<strong>{licenseLabel}:</strong> <span className={licenseClass}>{validLicense ? licenseValid : licenseInvalid}</span>
			</p>
		];
	}
};

const mapStateToProps = (state, ownProps) => {
	return {
		license: (state.license || ownProps.license) || '',
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
