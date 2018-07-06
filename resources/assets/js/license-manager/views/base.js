/* global wp */

/**
 * Shared simplified base. Simply rerender on model attributes change.
 */
const Base = wp.Backbone.View.extend( {
	/**
	 * Bind model to view.
	 *
	 * @return {undefined}
	 */
	initialize: function() {
		this.listenTo( this.model, 'change', this.render );
	},

	/**
	 * Render
	 */
	render: function() {
		this.$el.html( this.template( {
			className: this.model.className(),
			status: this.model.status(),
			...this.model.toJSON(),
		} ) );
	},
} );

export default Base;
