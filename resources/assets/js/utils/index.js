/**
 * Determine if an element has a specific class.
 *
 * @param {Object} el Node.
 * @param {string} className Class name to search for.
 * @return {boolean} If the class exists.
 */
export const hasClass = ( el, className ) => {
	if ( el.classList ) {
		return el.classList.contains( className );
	}

	return new RegExp( '(^| )' + className + '( |$)', 'gi' ).test( el.className );
};

/**
 * Determine if an element has a specific class.
 *
 * @param {Object} el Node.
 * @param {string} className Class name to search for.
 * @return {boolean} If the DOM element is visible.
 */
export const isHidden = ( el ) => {
	return el.offsetParent === null;
};
