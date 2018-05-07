/* global BigBoxLicenseManager */

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
import { activateLicense, deactivateLicense } from './../state/ActivateLicense/actions.js';
import { INITIAL_STATE } from './../state/ActivateLicense/reducer.js';

// i18n bootstrapped in page.
const {
	licensePlaceholder,
	licenseSubmit,
	licenseValid,
	licenseInvalid,
	licenseLabel,
	licenseDeactivate,
} = BigBoxLicenseManager.i18n;

/**
 * ActivateLicense class.
 */
class ActivateLicense extends Component {
	/**
	 * Bind callbacks.
	 *
	 * @param {Object} props Component properties.
	 */
	constructor( props ) {
		super( props );

		this.state = INITIAL_STATE;

		this.handleChange = this.handleChange.bind( this );
		this.handleSubmit = this.handleSubmit.bind( this );
		this.handleDeactivate = this.handleDeactivate.bind( this );
	}

	componentWillReceiveProps( nextProps ) {
		this.setState( nextProps );
	}

	/**
	 * Check license on page load.
	 */
	componentDidMount() {
		const {
			doActivateLicense,
			license,
		} = this.props;

		doActivateLicense( license );
	}

	/**
	 * License key changed.
	 *
	 * @param {Object} event Change event.
	 */
	handleChange( event ) {
		this.setState( {
			license: event.target.value,
			validLicense: false,
			isSubmitting: false,
		} );
	}

	/**
	 * Activate site on submit.
	 *
	 * @param {Object} event Submit event.
	 */
	handleSubmit( event ) {
		event.preventDefault();

		this.props.doActivateLicense( this.state.license );
	}

	/**
	 * Deactivate license.
	 */
	handleDeactivate() {
		this.props.doDeactivateLicense( this.state.license );
	}

	/**
	 * Render component.
	 *
	 * @return {Object} React Component.
	 */
	render() {
		const {
			license,
			validLicense,
			isSubmitting,
		} = this.state;

		const licenseClass = classNames( {
			license: true,
			[ `license--status-${ validLicense ? 'valid' : 'invalid' }` ]: ! isSubmitting,
		} );

		const spinnerStyle = {
			float: 'none',
			margin: '-4px 0 0 5px',
		};

		return [
			<form key="enter-license" className="bigbox-activate-license" onSubmit={ this.handleSubmit }>
				<input type="text" name="license" className={ licenseClass } value={ license } onChange={ this.handleChange } placeholder={ licensePlaceholder } />
				<input type="submit" name="submit" className="button button-large button-primary" value={ licenseSubmit } disabled={ isSubmitting || validLicense } />
			</form>,

			<p key="license-status">
				<strong>{ licenseLabel }</strong> { isSubmitting ? <span className="spinner is-active" style={ spinnerStyle } /> : <span className={ licenseClass }>{ validLicense ? licenseValid : licenseInvalid }</span> }
			</p>,

			validLicense && (
				<p key="deactivate-license">
					<button className="button" onClick={ this.handleDeactivate } >{ licenseDeactivate }</button>
				</p>
			),
		];
	}
}

/**
 * Map state to props.
 *
 * @param {Object} state    Current state.
 * @param {Object} ownProps Component properties.
 * @return {Object} Properties.
 */
const mapStateToProps = ( state, ownProps ) => {
	return {
		license: ( state.license || ownProps.license ) || '',
		validLicense: state.validLicense || false,
		isSubmitting: state.isSubmitting || false,
	};
};

/**
 * Map dispatch to props.
 *
 * @param {Object} dispatch Dispatch
 * @return {Object} bindActionCreators.
 */
const mapDispatchToProps = ( dispatch ) => {
	return bindActionCreators( {
		doActivateLicense: activateLicense,
		doDeactivateLicense: deactivateLicense,
	}, dispatch );
};

export default connect( mapStateToProps, mapDispatchToProps )( ActivateLicense );
