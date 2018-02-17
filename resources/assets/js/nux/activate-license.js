/**
 * External dependencies.
 */
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

class ActivateLicense extends Component {
	constructor(props) {
		super(props);

		this.state = {
			license: props.license,
			activeLicense: props.activeLicense,
		};

		this.handleChange = this.handleChange.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
	}

	handleChange(event) {
		this.setState({
			license: event.target.value
		});
	}

	handleSubmit(event) {
		event.preventDefault();
		alert('A name was submitted: ' + this.state.license);
	}

  render() {
    return (
			<form onSubmit={this.handleSubmit}>
				<input type="text" name="license" value={this.state.license} onChange={this.handleChange} placeholder="Enter license key..." />
				<input type="submit" name="submit" className="button button-primary" value="Submit" />
			</form>
    );
  }
};

const mapStateToProps = (state, ownProps) => {
  return {
		license: 123,
    activeLicense: false,
  };
};

export default connect(mapStateToProps)(ActivateLicense);
