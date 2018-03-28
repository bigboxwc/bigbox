/** global wp */

$(document).on( 'facetwp-loaded', () => {

	wp.hooks.addFilter( 'facetwp/set_options/autocomplete', ( $this, obj ) => {
		return {
			...$this,
			collision: 'flip',
			position: {
				my: 'left top',
				at: 'left bottom'
			}
		};
	} );

} );
