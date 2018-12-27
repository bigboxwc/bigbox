/* global bigbox, $, _ */

const partialCache = {};

/**
 * Retreive a partial from the page.
 *
 * Stored in a cache because finding can happen multiple times on a page.
 *
 * @param {string} selector Partial selector.
 * @return {Object} DOM element.
 */
export const getPartial = ( selector ) => {
	if ( partialCache.selector ) {
		return partialCache.selector;
	}

	return partialCache[ selector ] = document.querySelector( selector );
};

/**
 * Block partials when something is changing.
 *
 * @param {Array} partials List of partial selectors
 */
export const blockPartials = ( partials ) => {
	_.each( partials, ( selector ) => {
		const partial = getPartial( selector );

		if ( ! partial ) {
			return;
		}

		partial.classList.add( 'processing' );

		$( selector ).block( {
			message: null,
			overlayCSS: {
				background: bigbox.backgroundColor,
				opacity: 0.6,
			},
		} );
	} );
};

/**
 * Unblock partials.
 *
 * @param {Array} partials List of partial selectors
 */
export const unblockPartials = ( partials ) => {
	_.each( partials, ( selector ) => {
		const partial = getPartial( selector );

		if ( ! partial ) {
			return;
		}

		partial.classList.remove( 'processing' );

		$( selector ).unblock();
	} );
};

/**
 * Update partials with new response data.
 *
 * {
 *   checkout: '#checkout',
 * }
 *
 * {
 *   success: true,
 *   data: {
 *     checkout: 'Some new data.',
 *   },
 * }
 *
 * @param {Object} response AJAX response object with updated cart/checkout data.
 * @param {Object} partials Partials object with match response data slugs.
 */
export const updatePartialsWithResponse = ( response, partials ) => {
	_.each( partials, ( selector, partialSlug ) => {
		const partial = getPartial( selector );

		if ( ! partial ) {
			return;
		}

		partial.innerHTML = response.data[ partialSlug ];
	} );
};
