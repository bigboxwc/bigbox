/* global wp, BigBoxLicenseManager, Backbone */

/**
 * External dependencies.
 */
import classNames from 'classnames';

// i18n bootstrapped in page.
const {
	licensePlaceholder,
	licenseSubmit,
	licenseValid,
	licenseInvalid,
	licenseLabel,
	licenseDeactivate,
} = BigBoxLicenseManager.i18n;

const { license, valid } = BigBoxLicenseManager.local;

const License = Backbone.Model.extend( {
	apiRoot: wpApiSettings.root,
	versionString: wpApiSettings.versionString,
	routeName: 'settings',

	nonce: function() {
		return wpApiSettings.nonce;
	},

	url: function() {
		return this.apiRoot + this.versionString + this.routeName;
	},

	defaults: {
		key: '',
		valid: false,
		isPending: false,
		className: function() {
			const valid = this.get( 'valid' );
			const pending = this.get( 'isPending' );

			return classNames(
				'license',
				{
					[ `license--status-${ valid ? 'valid' : 'invalid' }` ]: ! pending
				},
			);
		}
	},
} );

/**
 * License key form.
 */
const LicenseForm = wp.Backbone.View.extend( {
	/**
	 * Template. Found in `resources/views/nux/steps/license-manager.php`
	 */
	template: wp.template( 'bigbox-license-manager-form' ),

	/**
	 * Bind events.
	 */
	events: {
		'submit form': 'submitForm',
	},

	/**
	 * Bind model to view.
	 *
	 * @return {undefined}
	 */
	initialize: function() {
		this.listenTo( this.model, 'change', this.render );
	},

	/**
	 * Handle form submission.
	 *
	 * @param {Object} e Event.
	 */
	submitForm: function( e ) {
		e.preventDefault();

		this.model.set( 'isPending','hi' );
		this.model.set( 'key','hi' );
	},

	/**
	 * Render.
	 *
	 * @return {undefined}
	 */
	render: function() {
		this.$el.html( this.template( this.model.toJSON() ) );
	},
} );

const LicenseStatus = wp.Backbone.View.extend( {
	/**
	 * Template. Found in `resources/views/nux/steps/license-manager.php`
	 */
	template: wp.template( 'bigbox-license-manager-status' ),

	/**
	 * Bind model to view.
	 *
	 * @return {undefined}
	 */
	initialize: function() {
		this.listenTo( this.model, 'change', this.render );
	},

	/**
	 * Render.
	 *
	 * @return {undefined}
	 */
	render: function() {
		this.$el.html( this.template( this.model.toJSON() ) );
	},
} );

const LicenseDeactivate = wp.Backbone.View.extend( {
	/**
	 * Template. Found in `resources/views/nux/steps/license-manager.php`
	 */
	template: wp.template( 'bigbox-license-manager-form' ),

	/**
	 * Bind model to view.
	 *
	 * @return {undefined}
	 */
	initialize: function() {
		this.listenTo( this.model, 'change', this.render );
	},

	render: function() {
		this.$el.html( 'deactivate' );
	},
} );

const LicenseManager = wp.Backbone.View.extend( {
	el: $( '#bigbox-license-manager' ),

	render: function() {
		// Add main form.
		this.views.add( new LicenseForm( {
			model: this.model,
		} ) );

		// Add status text.
		this.views.add( new LicenseStatus( {
			model: this.model,
		} ) );

		// Add deactivate button.
		this.views.add( new LicenseDeactivate( {
			model: this.model,
		} ) );
	}
} );

// Init manager.
const licenseManager = new LicenseManager( {
	model: new License ( {
		license,
		valid,
	} ),
} );

licenseManager.render();
