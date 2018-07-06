/**
 * Determine if an element has a specific class.
 *
 * @param {object} el Node.
 * @param {string} className Class name to search for.
 */
export const hasClass = ( el, className ) => {
  if ( el.classList ) {
    return el.classList.contains( className );
  }

  return new RegExp('(^| )' + className + '( |$)', 'gi').test( el.className );
}

/**
 * Determine if an element has a specific class.
 *
 * @param {object} el Node.
 * @param {string} className Class name to search for.
 */
export const isHidden = ( el ) => {
  return el.offsetParent === null;
}
